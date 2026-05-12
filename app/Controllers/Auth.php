<?php

namespace App\Controllers;

use App\Models\ProfilSanteModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    protected $helpers = ['form', 'url'];

    public function showLogin(): string
    {
        return view('auth/login', [
            'errors' => session()->getFlashdata('errors') ?? [],
            'message' => session()->getFlashdata('message'),
        ]);
    }

    public function login(): RedirectResponse
    {
        $rules = [
            'email' => 'required|valid_email',
            'mot_de_passe' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify($this->request->getPost('mot_de_passe'), $user['mot_de_passe'])) {
            return redirect()->back()->withInput()->with('errors', ['login' => 'Email ou mot de passe invalide.']);
        }

        session()->set([
            'id_user' => $user['id_user'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/accueil');
    }

    public function showRegister(): string
    {
        return view('auth/inscription', [
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function register(): RedirectResponse
    {
        $rules = [
            'nom' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'mot_de_passe' => 'required|min_length[6]',
            'mot_de_passe_confirm' => 'required|matches[mot_de_passe]',
            'genre' => 'required|in_list[HOMME,FEMME]',
            'date_naissance' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        session()->set('register_step1', [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'mot_de_passe' => password_hash((string) $this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT),
            'genre' => $this->request->getPost('genre'),
            'date_naissance' => $this->request->getPost('date_naissance'),
        ]);

        return redirect()->to('/inscription-sante');
    }

    public function showRegisterHealth(): string
    {
        if (! session()->get('register_step1')) {
            return redirect()->to('/inscription');
        }

        return view('auth/inscription_sante', [
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function registerHealth(): RedirectResponse
    {
        $step1 = session()->get('register_step1');

        if (! $step1) {
            return redirect()->to('/inscription');
        }

        $rules = [
            'taille' => 'required|decimal|greater_than[0]',
            'poids' => 'required|decimal|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $taille = (float) $this->request->getPost('taille');
        $poids = (float) $this->request->getPost('poids');
        $imc = $taille > 0 ? round($poids / ($taille * $taille), 2) : null;

        $model = new UserModel();
        $insertId = $model->insert([
            'nom' => $step1['nom'],
            'email' => $step1['email'],
            'mot_de_passe' => $step1['mot_de_passe'],
            'genre' => $step1['genre'],
            'date_naissance' => $step1['date_naissance'],
            'role' => 'USER',
            'wallet' => 0,
            'gold' => 0,
        ], true);

        if ($insertId === false) {
            $errors = $model->errors();
            if ($errors === []) {
                $errors = ['register' => 'Inscription impossible. Verifiez la connexion a la base.'];
            }

            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $profilModel = new ProfilSanteModel();
        $profilModel->insert([
            'id_user' => $insertId,
            'taille' => $taille,
            'poids' => $poids,
            'imc' => $imc,
        ]);

        session()->remove('register_step1');

        return redirect()->to('/login')->with('message', 'Inscription reussie. Connectez-vous.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
