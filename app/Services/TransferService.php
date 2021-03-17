<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\DepositService;

class TransferService
{
    protected $depositService;
    
    function __construct()
    {
        $this->depositService = new DepositService;
    }
    
    public function execute(Request $request) {

        $account = Account::find($request->origin);
        if (!$account) {            
            abort(404, 0);
        }

        $account->update([
            'balance' => $account->balance - $request->amount
        ]);
        
        $this->depositService->execute($request);

        return;
    }    

    
}