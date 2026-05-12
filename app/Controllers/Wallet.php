<?php

namespace App\Controllers;

use App\Models\CodeRechargeModel;
use App\Models\ParametreModel;
use App\Models\TransactionModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Wallet extends BaseController
{
    protected $helpers = ['form', 'url'];

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

    private function getGoldParams(): array
    {
        $model = new ParametreModel();
        $rows = $model->whereIn('cle', ['prix_gold', 'remise_gold'])->findAll();

        $params = [
            'prix_gold' => 0.0,
            'remise_gold' => 0.0,
        ];

        foreach ($rows as $row) {
            if (array_key_exists($row['cle'], $params)) {
                $params[$row['cle']] = (float) $row['valeur'];
            }
        }

        return $params;
    }

    public function recharge(): RedirectResponse
    {
        if ($redirect = $this->guardUser()) {
            return $redirect;
        }

        $rules = [
            'code' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('wallet_errors', $this->validator->getErrors());
        }

        $code = trim((string) $this->request->getPost('code'));
        $codeModel = new CodeRechargeModel();
        $codeRow = $codeModel->where('code', $code)->first();

        if (! $codeRow) {
            return redirect()->back()->withInput()->with('wallet_errors', [
                'code' => 'Code invalide.',
            ]);
        }

        if ($codeRow['statut'] !== 'NON_UTILISE') {
            return redirect()->back()->withInput()->with('wallet_errors', [
                'code' => 'Code deja utilise.',
            ]);
        }

        $amount = (float) $codeRow['montant'];
        $idUser = session()->get('id_user');
        $db = db_connect();

        $db->transBegin();

        $db->table('codes_recharge')
            ->where('id_code', $codeRow['id_code'])
            ->where('statut', 'NON_UTILISE')
            ->update(['statut' => 'UTILISE']);

        if ($db->affectedRows() === 0) {
            $db->transRollback();

            return redirect()->back()->withInput()->with('wallet_errors', [
                'code' => 'Code deja utilise.',
            ]);
        }

        $userModel = new UserModel();
        $userModel
            ->set('wallet', 'wallet + ' . $amount, false)
            ->where('id_user', $idUser)
            ->update();

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'id_user' => $idUser,
            'montant' => $amount,
            'type' => 'AJOUT',
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->back()->withInput()->with('wallet_errors', [
                'code' => 'Recharge impossible. Reessayez.',
            ]);
        }

        $db->transCommit();

        return redirect()->to('/accueil')->with('wallet_message', 'Wallet recharge avec succes.');
    }

    public function buyGold(): RedirectResponse
    {
        if ($redirect = $this->guardUser()) {
            return $redirect;
        }

        $idUser = session()->get('id_user');
        $userModel = new UserModel();
        $user = $userModel->find($idUser);

        if (! $user) {
            return redirect()->to('/accueil')->with('wallet_errors', [
                'gold' => 'Utilisateur introuvable.',
            ]);
        }

        if ((int) $user['gold'] === 1) {
            return redirect()->to('/accueil')->with('wallet_errors', [
                'gold' => 'Option Gold deja activee.',
            ]);
        }

        $params = $this->getGoldParams();
        $prixGold = (float) $params['prix_gold'];

        if ($prixGold <= 0) {
            return redirect()->to('/accueil')->with('wallet_errors', [
                'gold' => 'Prix Gold indisponible.',
            ]);
        }

        if ((float) $user['wallet'] < $prixGold) {
            return redirect()->to('/accueil')->with('wallet_errors', [
                'gold' => 'Solde insuffisant pour activer Gold.',
            ]);
        }

        $db = db_connect();
        $db->transBegin();

        $userModel
            ->set('wallet', 'wallet - ' . $prixGold, false)
            ->set('gold', 1)
            ->where('id_user', $idUser)
            ->update();

        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'id_user' => $idUser,
            'montant' => $prixGold,
            'type' => 'GOLD',
        ]);

        if ($db->transStatus() === false) {
            $db->transRollback();

            return redirect()->to('/accueil')->with('wallet_errors', [
                'gold' => 'Activation Gold impossible. Reessayez.',
            ]);
        }

        $db->transCommit();

        return redirect()->to('/accueil')->with('wallet_message', 'Option Gold activee.');
    }
}
