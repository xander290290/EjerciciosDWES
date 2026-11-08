<?php
use PHPunit\Framework\Attributes\DataProvider;
use App\Service\LibroFromService;

final class ValidatorTest {
    public static function entradaPaginas() {
        return [
            'minimo' => ['1',true],
            'maximo' => ['3000', true],
            'bajo' => ['0', false],
            'alto' => ['3001', false],
            'formato' => ['13abc', false],
            'array' => [['412'], false]
        ];
    }

    public function probarErrores() {
        $v = new Validator();
        $v->procesar(['Dune','Frank Herbert',]);
    }
}