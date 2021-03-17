<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{   

    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAccountWithFirstDeposit();
    }
    
    public function createAccountWithFirstDeposit()
    {
        $parameters = [
            'type' => 'deposit',
            'destination' => 1000,
            'amount' => 10
        ];

        $this->post("event", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'destination' => [
                'id' => 1000,
                'balance' => 10
            ]
        ]);
    }

    public function testShouldGetBalance()
    {
        $this->get('/balance?account_id=1000');

        $this->assertEquals(
            10, $this->response->getContent()
        );
    }
}
