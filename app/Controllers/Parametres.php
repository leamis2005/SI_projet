<?php

namespace App\Controllers;

use App\Models\ParametreModel;
use CodeIgniter\HTTP\RedirectResponse;

class Parametres extends BaseController
{
    protected $helpers = ['form', 'url'];

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

        $model = new ParametreModel();

        return view('admin/parametres/index', [
            'parametres' => $model->findAll(),
            'message' => session()->getFlashdata('message'),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        return view('admin/parametres/form', [
            'mode' => 'create',
            'parametre' => null,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $rules = [
            'cle' => 'required|min_length[2]|is_unique[parametres.cle]',
            'valeur' => 'required|min_length[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ParametreModel();
        $model->insert([
            'cle' => $this->request->getPost('cle'),
            'valeur' => $this->request->getPost('valeur'),
        ]);

        return redirect()->to('/admin/parametres')->with('message', 'Parametre cree.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new ParametreModel();
        $parametre = $model->find($id);

        if (! $parametre) {
            return redirect()->to('/admin/parametres')->with('message', 'Parametre introuvable.');
        }

        return view('admin/parametres/form', [
            'mode' => 'edit',
            'parametre' => $parametre,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $rules = [
            'cle' => 'required|min_length[2]',
            'valeur' => 'required|min_length[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ParametreModel();
        $model->update($id, [
            'cle' => $this->request->getPost('cle'),
            'valeur' => $this->request->getPost('valeur'),
        ]);

        return redirect()->to('/admin/parametres')->with('message', 'Parametre mis a jour.');
    }

    public function delete(int $id): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new ParametreModel();
        $model->delete($id);

        return redirect()->to('/admin/parametres')->with('message', 'Parametre supprime.');
    }
}
