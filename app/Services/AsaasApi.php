<?php


namespace App\Services;

use CodePhix\Asaas;


class AsaasApi
{
    /**
     *
     */
    public function getAsaasCredentials()
    {
        $dadosCliente = [
            'name' => 'teste3',
            'cpfCnpj' => '813.613.940-72',
            'email' => 'teste2@gmail.com',
            'mobilePhone' => '85913223453',
        ];

        $asaas = new Asaas\Asaas('a390f4c6612b718aedb89a85bee3b27af41cebf82a0fafc89321943252a0fed4');
        $cliente = $asaas->cliente->create($dadosCliente);
        dd($cliente);
    }
}

