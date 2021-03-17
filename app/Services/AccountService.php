<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Account;

class AccountService
{
    public function create(Request $request) {
        Account::create([
            'id' => $request->destination, 
            'balance' => $request->amount,
        ]);            
        
        $account = Account::find($request->destination);
        
        return response()->json(['destination' => $account], 201);
    }

    public function getBalance(Request $request)
    {
        $account = Account::find($request->get('account_id'));
        if (!$account) {
            abort(404, 0);
        }

        return $account;
    }

    public function getAccountById($id)
    {
        return $account = Account::find($id);
    }

    public function deleteAll()
    {
        return Account::truncate();
    }
}
