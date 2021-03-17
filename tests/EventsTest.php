<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class EventsTest extends TestCase
{   

    use DatabaseTransactions;

    const ACCOUNT_A = 2000;
    const ACCOUNT_B = 1000;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAccountWithFirstDeposit();
    }
    
    public function createAccountWithFirstDeposit()
    {
        $parameters = [
            'type' => 'deposit',
            'destination' => $this::ACCOUNT_A,
            'amount' => 10
        ];

        $this->post("/event", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'destination' => [
                'id' => $this::ACCOUNT_A,
                'balance' => 10
            ]
        ]);
    }

    public function testShouldMakeDeposit(){

        $parameters = [
            'type' => 'deposit',
            'destination' => $this::ACCOUNT_A,
            'amount' => 10
        ];

        $this->post("/event", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'destination' => [
                'id' => $this::ACCOUNT_A,
                'balance' => 20
            ]
        ]);
        
    }

    public function testShouldMakeWithdraw(){

        $parameters = [
            'type' => 'withdraw',
            'origin' => $this::ACCOUNT_A,
            'amount' => 5
        ];

        $this->post("/event", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'origin' => [
                'id' => $this::ACCOUNT_A,
                'balance' => 5
            ]
        ]);

    }

    public function testShouldTransfer(){

        $parameters = [
            'type' => 'transfer',
            'origin' => $this::ACCOUNT_A,
            'amount' => 5,
            'destination' => $this::ACCOUNT_B
        ];

        $this->post("/event", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'origin' => [
                'id' => $this::ACCOUNT_A,
                'balance' => 5 
            ],
            'destination' => [
                'id' => $this::ACCOUNT_B,
                'balance' => 5
            ]
        ]);

    }
}
