<?php

namespace App\Controllers;

use App\Models\ProfilSanteModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    protected $helpers = ['url'];

    private function guardAdmin(): ?RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'ADMIN') {
            return redirect()->to('/accueil');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $users = (new UserModel())
            ->where('role', 'USER')
            ->orderBy('date_inscription', 'DESC')
            ->findAll();

        return view('admin/users/index', [
            'users' => $users,
            'message' => session()->getFlashdata('message'),
        ]);
    }

    public function show(int $id)
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (! $user || $user['role'] !== 'USER') {
            return redirect()->to('/admin/users')->with('message', 'Utilisateur introuvable.');
        }

        $profil = (new ProfilSanteModel())
            ->where('id_user', $id)
            ->first();

        $db = db_connect();
        $objectifs = $db->table('user_objectif uo')
            ->select('o.libelle')
            ->join('objectifs o', 'o.id_objectif = uo.id_objectif')
            ->where('uo.id_user', $id)
            ->get()
            ->getResultArray();

        $regime = $db->table('user_regime ur')
            ->select('r.nom, r.duree, r.variation_poids, r.prix_base, r.prix_par_jour, r.viande_percent, r.poisson_percent, r.volaille_percent, ur.date_debut, ur.date_fin')
            ->join('regimes r', 'r.id_regime = ur.id_regime')
            ->where('ur.id_user', $id)
            ->orderBy('ur.id', 'DESC')
            ->get()
            ->getRowArray();

        $transactions = (new TransactionModel())
            ->where('id_user', $id)
            ->orderBy('date_transaction', 'DESC')
            ->findAll();

        return view('admin/users/show', [
            'user' => $user,
            'profil' => $profil,
            'objectifs' => $objectifs,
            'regime' => $regime,
            'transactions' => $transactions,
        ]);
    }
}
