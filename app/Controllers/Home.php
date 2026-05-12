<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\RegimeModel;
use App\Models\ActiviteSportiveModel;
use App\Models\ParametreModel;
use App\Models\ProfilSanteModel;
use App\Models\UserRegimeModel;
use App\Models\UserModel;
use App\Models\UserObjectifModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index(): RedirectResponse
    {
        return redirect()->to('/login');
    }

    public function accueil()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if ($role === 'ADMIN') {
            return view('accueil_admin');
        }

        $idUser = session()->get('id_user');
        $userModel = new UserModel();
        $profilModel = new ProfilSanteModel();
        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();
        $parametreModel = new ParametreModel();
        $regimeModel = new RegimeModel();
        $activiteModel = new ActiviteSportiveModel();
        $userRegimeModel = new UserRegimeModel();

        $params = $parametreModel->whereIn('cle', ['prix_gold', 'remise_gold'])->findAll();
        $goldPrice = 0.0;
        $goldDiscount = 0.0;

        foreach ($params as $param) {
            if ($param['cle'] === 'prix_gold') {
                $goldPrice = (float) $param['valeur'];
            }

            if ($param['cle'] === 'remise_gold') {
                $goldDiscount = (float) $param['valeur'];
            }
        }

        $objectifs = $objectifModel->findAll();
        $selectedObjectifs = $userObjectifModel
            ->select('id_objectif')
            ->where('id_user', $idUser)
            ->findColumn('id_objectif');

        $suggestion = null;
        $regimesForObjectif = [];
        $selectedRegimeId = null;

        $selectedObjectifId = $selectedObjectifs[0] ?? null;
        if ($selectedObjectifId) {
            $objectif = $objectifModel->find($selectedObjectifId);
            $objectifId = (int) $selectedObjectifId;

            $regimeChoices = [
                1 => [1, 4],
                2 => [2, 5],
                3 => [3],
            ];

            $regimeIds = $regimeChoices[$objectifId] ?? [];
            if ($regimeIds !== []) {
                $regimesForObjectif = $regimeModel->whereIn('id_regime', $regimeIds)->findAll();
            }

            $currentRegime = $userRegimeModel
                ->where('id_user', $idUser)
                ->orderBy('id', 'DESC')
                ->first();

            if ($currentRegime) {
                $selectedRegimeId = (int) $currentRegime['id_regime'];
            }

            $selectedRegime = $selectedRegimeId ? $regimeModel->find($selectedRegimeId) : null;
            if (! $selectedRegime && ! empty($regimesForObjectif)) {
                $selectedRegime = $regimesForObjectif[0];
                $selectedRegimeId = (int) ($selectedRegime['id_regime'] ?? 0);
            }

            $activiteByObjectif = [
                1 => 2,
                2 => 1,
                3 => 3,
            ];
            $activiteId = $activiteByObjectif[$objectifId] ?? null;
            $suggestedActivite = $activiteId ? $activiteModel->find($activiteId) : null;

            if ($selectedRegime && $suggestedActivite) {
                $suggestion = [
                    'objectif' => $objectif,
                    'regime' => $selectedRegime,
                    'activite' => $suggestedActivite,
                ];
            }
        }

        return view('accueil_user', [
            'user' => $userModel->find($idUser),
            'profil' => $profilModel->where('id_user', $idUser)->first(),
            'objectifs' => $objectifs,
            'selectedObjectifs' => $selectedObjectifs ?? [],
            'suggestion' => $suggestion,
            'regimesForObjectif' => $regimesForObjectif,
            'selectedRegimeId' => $selectedRegimeId,
            'errors' => session()->getFlashdata('errors') ?? [],
            'message' => session()->getFlashdata('message'),
            'walletErrors' => session()->getFlashdata('wallet_errors') ?? [],
            'walletMessage' => session()->getFlashdata('wallet_message'),
            'goldPrice' => $goldPrice,
            'goldDiscount' => $goldDiscount,
        ]);
    }

    public function saveProfilSante(): RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'USER') {
            return redirect()->to('/accueil');
        }

        $rules = [
            'genre' => 'required|in_list[HOMME,FEMME]',
            'taille' => 'required|decimal|greater_than[0]',
            'poids' => 'required|decimal|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idUser = session()->get('id_user');
        $genre = (string) $this->request->getPost('genre');
        $taille = (float) $this->request->getPost('taille');
        $poids = (float) $this->request->getPost('poids');
        $imc = $taille > 0 ? round($poids / ($taille * $taille), 2) : null;

        $userModel = new UserModel();
        $userModel->update($idUser, ['genre' => $genre]);

        $profilModel = new ProfilSanteModel();
        $profil = $profilModel->where('id_user', $idUser)->first();

        $payload = [
            'id_user' => $idUser,
            'taille' => $taille,
            'poids' => $poids,
            'imc' => $imc,
        ];

        if ($profil) {
            $profilModel->update($profil['id_profil'], $payload);
        } else {
            $profilModel->insert($payload);
        }

        return redirect()->to('/accueil')->with('message', 'Profil mis a jour.');
    }

    public function saveObjectifs(): RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'USER') {
            return redirect()->to('/accueil');
        }

        $selected = $this->request->getPost('objectifs');
        $selected = is_array($selected) ? $selected : [];

        if (count($selected) !== 1) {
            return redirect()->back()->withInput()->with('errors', [
                'objectifs' => 'Veuillez selectionner exactement 1 objectif.',
            ]);
        }

        $objectifModel = new ObjectifModel();
        $validIds = $objectifModel->findColumn('id_objectif') ?? [];

        foreach ($selected as $idObjectif) {
            if (! in_array((int) $idObjectif, array_map('intval', $validIds), true)) {
                return redirect()->back()->withInput()->with('errors', [
                    'objectifs' => 'Objectif invalide.',
                ]);
            }
        }

        $idUser = session()->get('id_user');
        $userObjectifModel = new UserObjectifModel();
        $userObjectifModel->where('id_user', $idUser)->delete();

        $rows = [];
        foreach ($selected as $idObjectif) {
            $rows[] = [
                'id_user' => $idUser,
                'id_objectif' => (int) $idObjectif,
            ];
        }

        $userObjectifModel->insertBatch($rows);

        return redirect()->to('/accueil')->with('message', 'Objectifs enregistres.');
    }

    public function saveRegime(): RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'USER') {
            return redirect()->to('/accueil');
        }

        $regimeId = (int) $this->request->getPost('regime_id');
        if ($regimeId <= 0) {
            return redirect()->back()->withInput()->with('errors', [
                'regime' => 'Veuillez choisir un regime.',
            ]);
        }

        $idUser = session()->get('id_user');
        $userObjectifModel = new UserObjectifModel();
        $selectedObjectifId = $userObjectifModel
            ->select('id_objectif')
            ->where('id_user', $idUser)
            ->findColumn('id_objectif');

        $objectifId = (int) ($selectedObjectifId[0] ?? 0);
        if ($objectifId === 0) {
            return redirect()->back()->withInput()->with('errors', [
                'regime' => 'Veuillez choisir un objectif avant de selectionner un regime.',
            ]);
        }

        $regimeChoices = [
            1 => [1, 4],
            2 => [2, 5],
            3 => [3],
        ];

        $allowed = $regimeChoices[$objectifId] ?? [];
        if (! in_array($regimeId, $allowed, true)) {
            return redirect()->back()->withInput()->with('errors', [
                'regime' => 'Regime invalide pour votre objectif.',
            ]);
        }

        $regimeModel = new RegimeModel();
        $regime = $regimeModel->find($regimeId);
        if (! $regime) {
            return redirect()->back()->withInput()->with('errors', [
                'regime' => 'Regime introuvable.',
            ]);
        }

        $dateDebut = date('Y-m-d');
        $duree = (int) ($regime['duree'] ?? 0);
        $dateFin = $duree > 0 ? date('Y-m-d', strtotime('+' . $duree . ' days')) : null;

        $userRegimeModel = new UserRegimeModel();
        $userRegimeModel->where('id_user', $idUser)->delete();
        $userRegimeModel->insert([
            'id_user' => $idUser,
            'id_regime' => $regimeId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);

        return redirect()->to('/accueil')->with('message', 'Regime choisi avec succes.');
    }
}
