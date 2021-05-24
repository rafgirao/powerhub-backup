<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;


class SmsBarato
{
    /**
     * @param $number
     * @param $text
     * @return string
     */
    public function sendSms($number, $text): string
    {
        $number = (new Helper)->prepareBrPhoneNumber($number);
        $text = (new Helper)->clearSmsText($text);

        $response = Http::retry(3, 200)->get(env('SMSBARATO_URL') . '/send', [
            'chave' => env('SMSBARATO_KEY'),
            'dest' => $number,
            'text' => $text
        ]);

        if ($response->body() === 'ERRO1-1') {
            return '(ERRO1-1) Problemas com a sua chave';
        } elseif ($response->body() === 'ERRO1-2') {
            return '(ERRO1-2) Problemas com seu IP (nao autorizado)';
        } elseif ($response->body() === 'ERRO1-3') {
            return '(ERRO1-3) Saldo insuficiente para enviar mensagem';
        } elseif ($response->body() === 'ERRO2') {
            return '(ERRO2) Problemas com o numero de destino';
        } elseif ($response->body() === 'ERRO3') {
            return '(ERRO3) Problemas com o texto da mensagem';
        }
        return $response->body();
    }

    /**
     * @param $id
     * @return string
     */
    public function getSmsStatus($id)
    {
        $response = Http::retry(3, 200)->get(env('SMSBARATO_URL') . '/status', [
            'chave' => env('SMSBARATO_KEY'),
            'id' => $id,
        ]);

        if ($response->body() === 'ERRO') {
            return '(ERRO) ID invalido';
        } elseif ($response->body() === 'ERRO2') {
            return '(ERRO2) ID especificado nao existe';
        } elseif ($response->body() === 'N') {
            return '(N) Mensagem nova, aguardando envio.';
        } elseif ($response->body() === 'R') {
            return '(R) Mensagem sendo enviada.';
        } elseif ($response->body() === 'S') {
            return '(S) Mensagem foi enviada com Sucesso.';
        } elseif ($response->body() === 'F') {
            return '(F) Envio falhou. Nao sera tentado novamente.';
        }
        return $response->body();
    }

    /**
     * @return string
     */
    public function getSmsBalance()
    {
        $response = Http::retry(3, 200)->get(env('SMSBARATO_URL') . '/saldo', [
            'chave' => env('SMSBARATO_KEY'),
        ]);

        echo $response->body();
        return $response->body();
    }
}
