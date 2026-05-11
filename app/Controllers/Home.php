<?php

namespace App\Controllers;

use App\Models\ProfilSanteModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function index(): string
    {
        return view('home');
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

        return view('accueil_user', [
            'user' => $userModel->find($idUser),
            'profil' => $profilModel->where('id_user', $idUser)->first(),
            'errors' => session()->getFlashdata('errors') ?? [],
            'message' => session()->getFlashdata('message'),
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
}
