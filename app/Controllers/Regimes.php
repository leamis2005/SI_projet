<?php

namespace App\Controllers;

use App\Models\RegimeModel;
use CodeIgniter\HTTP\RedirectResponse;

class Regimes extends BaseController
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

        $model = new RegimeModel();

        return view('admin/regimes/index', [
            'regimes' => $model->findAll(),
            'message' => session()->getFlashdata('message'),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        return view('admin/regimes/form', [
            'mode' => 'create',
            'regime' => null,
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
            'prix_base' => 'required|decimal',
            'duree' => 'required|integer|greater_than[0]',
            'viande_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'poisson_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'volaille_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'variation_poids' => 'permit_empty|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $viande = (int) $this->request->getPost('viande_percent');
        $poisson = (int) $this->request->getPost('poisson_percent');
        $volaille = (int) $this->request->getPost('volaille_percent');

        if (($viande + $poisson + $volaille) !== 100) {
            return redirect()->back()->withInput()->with('errors', [
                'viande_percent' => 'La somme des pourcentages doit faire 100.',
            ]);
        }

        $prixBase = (float) $this->request->getPost('prix_base');
        $duree = (int) $this->request->getPost('duree');
        $prixParJour = $duree > 0 ? round($prixBase / $duree, 2) : 0.0;

        $model = new RegimeModel();
        $model->insert([
            'nom' => $this->request->getPost('nom'),
            'prix_base' => $prixBase,
            'duree' => $duree,
            'viande_percent' => $viande,
            'poisson_percent' => $poisson,
            'volaille_percent' => $volaille,
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix_par_jour' => $prixParJour,
        ]);

        return redirect()->to('/admin/regimes')->with('message', 'Regime cree.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new RegimeModel();
        $regime = $model->find($id);

        if (! $regime) {
            return redirect()->to('/admin/regimes')->with('message', 'Regime introuvable.');
        }

        return view('admin/regimes/form', [
            'mode' => 'edit',
            'regime' => $regime,
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
            'prix_base' => 'required|decimal',
            'duree' => 'required|integer|greater_than[0]',
            'viande_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'poisson_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'volaille_percent' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
            'variation_poids' => 'permit_empty|max_length[50]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $viande = (int) $this->request->getPost('viande_percent');
        $poisson = (int) $this->request->getPost('poisson_percent');
        $volaille = (int) $this->request->getPost('volaille_percent');

        if (($viande + $poisson + $volaille) !== 100) {
            return redirect()->back()->withInput()->with('errors', [
                'viande_percent' => 'La somme des pourcentages doit faire 100.',
            ]);
        }

        $prixBase = (float) $this->request->getPost('prix_base');
        $duree = (int) $this->request->getPost('duree');
        $prixParJour = $duree > 0 ? round($prixBase / $duree, 2) : 0.0;

        $model = new RegimeModel();
        $model->update($id, [
            'nom' => $this->request->getPost('nom'),
            'prix_base' => $prixBase,
            'duree' => $duree,
            'viande_percent' => $viande,
            'poisson_percent' => $poisson,
            'volaille_percent' => $volaille,
            'variation_poids' => $this->request->getPost('variation_poids'),
            'prix_par_jour' => $prixParJour,
        ]);

        return redirect()->to('/admin/regimes')->with('message', 'Regime mis a jour.');
    }

    public function delete(int $id): RedirectResponse
    {
        if ($redirect = $this->guardAdmin()) {
            return $redirect;
        }

        $model = new RegimeModel();
        $model->delete($id);

        return redirect()->to('/admin/regimes')->with('message', 'Regime supprime.');
    }
}
