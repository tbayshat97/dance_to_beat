<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTransaction;

class CustomerTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Clients transactions"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $customerTransactions = CustomerTransaction::all();

        return view('backend.transactions.customer-list', compact('customerTransactions', 'breadcrumbs'));
    }
}
