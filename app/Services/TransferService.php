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
        $this->withdrawService = new WithdrawService;
    }
    
    public function execute(Request $request) {

        $this->withdrawService->execute($request);
        $this->depositService->execute($request);

        return;
    }    

    
}