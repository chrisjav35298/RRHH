<?php
namespace App\Service;

class CalculadoraService
{
    public function sumar(int $a, int $b): int
    {
        return $a + $b;
    }

    public function dividir(int $a, int $b): float
    {
        if ($b === 0) {
            throw new \InvalidArgumentException("No se puede dividir por cero");
        }
        return $a / $b;
    }
}
