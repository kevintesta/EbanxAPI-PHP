<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Account;


class WithdrawService 
{
    public function execute(Request $request) {

        $account = Account::find($request->origin);
        if (!$account) {            
            abort(404, 0);
        }
        
        if ($account->balance - $request->amount < -100) {
            abort(500, 'Saldo insuficiente!');
        }

        $account->update([
            'balance' => $account->balance - $request->amount
        ]);

        return;
    }    

    
}
