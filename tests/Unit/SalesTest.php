<?php

namespace Tests\Unit;

use App\Http\Controllers\Sales;
use PHPUnit\Framework\TestCase;

class SalesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
  

    public function test_aplicacao_banco_de_dados_is_running_corretly()
    {
        $controllerTest = new Sales();
        $dateFromApp = '03/10/2024';
        $result = $controllerTest->aplicacao_banco_de_dados_($dateFromApp);
        $this->assertEquals('2024-10-03', $result);
    }
    
    public function test_banco_de_dados_aplicacao_is_running_corretly()
    {
        $controllerTest = new Sales();
        $dateFromApp = '2024-10-03';
        $result = $controllerTest->banco_de_dados_aplicacao($dateFromApp);
        $this->assertEquals('03/10/2024', $result);
    }
    public function test_validandoDesconto_is_running_corretly()
    {
        $controllerTest = new Sales();
        $productPrice = 200;
        $productDiscount = 50;

        $result = $controllerTest->validandoDesconto( $productPrice, $productDiscount);
        $this->assertEquals('50', $result);
    }
    public function test_validandoDesconto_is_running_corretly_second_case()
    {
        $controllerTest = new Sales();
        $productPrice = 200;
        $productDiscount = 250;

        $result = $controllerTest->validandoDesconto( $productPrice, $productDiscount);
        $this->assertEquals('20', $result);
    }
    public function test_salesPrice_is_running_corretly()
    {
        $controllerTest = new Sales();
        $quantity = 4;
        $productPrice = 200;
        $productDiscount = 250;

        $result = $controllerTest->salesPrice($quantity,$productDiscount, $productPrice);
        $this->assertEquals(550, $result);
    }

    
}
