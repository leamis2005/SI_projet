<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Dashboard extends BaseController
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

        $db = db_connect();

        $totalUsers = $db->table('users')->where('role', 'USER')->countAllResults();
        $goldUsers = $db->table('users')
            ->where('role', 'USER')
            ->where('gold', 1)
            ->countAllResults();

        $walletRow = $db->table('users')->selectSum('wallet')->get()->getRowArray();
        $walletTotal = (float) ($walletRow['wallet'] ?? 0);

        $regimesCount = $db->table('regimes')->countAllResults();
        $activitesCount = $db->table('activites_sportives')->countAllResults();
        $transactionsCount = $db->table('transactions')->countAllResults();

        $transactionsByType = $db->table('transactions')
            ->select('type, COUNT(*) as total, SUM(montant) as montant_total')
            ->groupBy('type')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();

        $users = $db->table('users')
            ->select('id_user, nom, email, date_inscription, wallet, gold')
            ->where('role', 'USER')
            ->orderBy('date_inscription', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        $objectifRows = $db->table('objectifs o')
            ->select('o.libelle, COUNT(uo.id) as total')
            ->join('user_objectif uo', 'uo.id_objectif = o.id_objectif', 'left')
            ->groupBy('o.id_objectif')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();

        $objectifMax = 0;
        foreach ($objectifRows as $row) {
            $objectifMax = max($objectifMax, (int) $row['total']);
        }

        $transactionMax = 0;
        foreach ($transactionsByType as $row) {
            $transactionMax = max($transactionMax, (int) $row['total']);
        }

        return view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'goldUsers' => $goldUsers,
            'walletTotal' => $walletTotal,
            'regimesCount' => $regimesCount,
            'activitesCount' => $activitesCount,
            'transactionsCount' => $transactionsCount,
            'transactionsByType' => $transactionsByType,
            'transactionMax' => $transactionMax,
            'objectifs' => $objectifRows,
            'objectifMax' => $objectifMax,
            'users' => $users,
        ]);
    }
}
