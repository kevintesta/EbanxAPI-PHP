<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Services\DepositService;
use App\Services\TransferService;
use App\Services\WithdrawService;
use App\Services\AccountService;

class EventController extends BaseController
{
    private $depositService;
    private $withdrawService;
    private $transferService;
    private $accountService;

    function __construct() 
    {
        $this->depositService = new DepositService;
        $this->withdrawService = new WithdrawService;
        $this->transferService = new TransferService;
        $this->accountService = new AccountService;
    }

    public function newEvent(Request $request)
    {   
        $response = [];

        switch ($request->type) {
            case 'deposit':
                try {

                    $this->depositService->execute($request);
                    $response = [
                        'destination' => $this->accountService->getAccountById($request->destination)
                    ];

                } catch (\Throwable $th) {                    
                    return response()->json(0, $th->getStatusCode());
                }   

                break;
        
            case 'withdraw':
                try {

                    $this->withdrawService->execute($request);
                    $response = [
                        'origin' => $this->accountService->getAccountById($request->origin)
                    ];

                } catch (\Throwable $th) {                    
                    return response()->json(0, $th->getStatusCode());
                }                
                
                break;            
            
            case 'transfer':
                try {
                    
                    $this->transferService->execute($request);
                    $response = [
                        'origin' => $this->accountService->getAccountById($request->origin),
                        'destination' => $this->accountService->getAccountById($request->destination)
                    ]; 

                } catch (\Throwable $th) {                    
                    return response()->json(0, $th->getStatusCode());
                }    

                break;
        }

        
        return response()->json($response, 201);
    }  
    
    public function reset(Request $request)
    {
        $this->accountService->deleteAll();
        return 'OK';
    }
}
