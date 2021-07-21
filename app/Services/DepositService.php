<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Account;

class DepositService

{
    protected $accountService;

    function __construct()
    {
        $this->accountService = new AccountService;
    }

    public function execute(Request $request) {

        $account = $this->accountService->getAccountById($request->destination);        
        if (!$account) {            
            return $this->accountService->create($request);
        }        

        $account->update([
            'balance' => $account->balance + $request->amount
        ]);

        return;
    }

}
