<?php
namespace App\Tests\Service;

use App\Service\CalculadoraService;
use PHPUnit\Framework\TestCase;

class CalculadoraServiceTest extends TestCase
{
    public function testSumaCorrecta()
    {
        $calc = new CalculadoraService();
        $resultado = $calc->sumar(2, 3);
        $this->assertSame(5, $resultado);
    }

    public function testDivisionPorCero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $calc = new CalculadoraService();
        $calc->dividir(10, 0);
    }
}
