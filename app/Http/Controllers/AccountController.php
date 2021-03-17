<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\AccountService;

class AccountController extends BaseController
{
    protected $accountService;

    function __construct()
    {
        $this->accountService = new AccountService;
    }

    public function getBalance(Request $request)
    {   
        try { 
            $result = $this->accountService->getBalance($request);
            return response()->json($result->balance);

        } catch (\Throwable $th) {                    
            return response()->json(0, $th->getStatusCode());
        }   
    }

}
