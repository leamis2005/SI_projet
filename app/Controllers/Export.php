<?php

namespace App\Controllers;

use App\Models\ObjectifModel;
use App\Models\ProfilSanteModel;
use App\Models\UserModel;
use App\Models\UserObjectifModel;
use CodeIgniter\HTTP\RedirectResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

class Export extends BaseController
{
    protected $helpers = ['url'];

    private function guardUser(): ?RedirectResponse
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'USER') {
            return redirect()->to('/accueil');
        }

        return null;
    }

    public function userPdf()
    {
        if ($redirect = $this->guardUser()) {
            return $redirect;
        }

        $idUser = session()->get('id_user');
        $userModel = new UserModel();
        $profilModel = new ProfilSanteModel();
        $objectifModel = new ObjectifModel();
        $userObjectifModel = new UserObjectifModel();

        $user = $userModel->find($idUser);
        if (! $user) {
            return redirect()->to('/accueil')->with('message', 'Utilisateur introuvable.');
        }

        $profil = $profilModel->where('id_user', $idUser)->first();
        $selectedIds = $userObjectifModel
            ->select('id_objectif')
            ->where('id_user', $idUser)
            ->findColumn('id_objectif');

        $objectifs = [];
        if ($selectedIds) {
            $objectifs = $objectifModel->whereIn('id_objectif', $selectedIds)->findAll();
        }

        $html = view('pdf/user_profile', [
            'user' => $user,
            'profil' => $profil,
            'objectifs' => $objectifs,
            'generatedAt' => date('d/m/Y H:i'),
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $this->response
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="profil-utilisateur.pdf"')
            ->setBody($dompdf->output());
    }
}
