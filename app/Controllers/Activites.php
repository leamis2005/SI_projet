<?php

namespace App\Controllers;

use App\Models\ActiviteSportiveModel;
use CodeIgniter\HTTP\RedirectResponse;

class Activites extends BaseController
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

        $model = new ActiviteSportiveModel();

        return view('admin/activites/index', [
            'activites' => $model->findAll(),
            'message' => session()->getFlashdata('message'),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        return view('admin/activites/form', [
            'mode' => 'create',
            'activite' => null,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[2]',
            'calories_brulees' => 'required|integer',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ActiviteSportiveModel();
        $model->insert([
            'nom' => $this->request->getPost('nom'),
            'calories_brulees' => $this->request->getPost('calories_brulees'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/activites')->with('message', 'Activite creee.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new ActiviteSportiveModel();
        $activite = $model->find($id);

        if (! $activite) {
            return redirect()->to('/admin/activites')->with('message', 'Activite introuvable.');
        }

        return view('admin/activites/form', [
            'mode' => 'edit',
            'activite' => $activite,
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $rules = [
            'nom' => 'required|min_length[2]',
            'calories_brulees' => 'required|integer',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ActiviteSportiveModel();
        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'calories_brulees' => $this->request->getPost('calories_brulees'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/activites')->with('message', 'Activite mise a jour.');
    }

    public function delete(int $id): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new ActiviteSportiveModel();
        $model->delete($id);

        return redirect()->to('/admin/activites')->with('message', 'Activite supprimee.');
    }
}
