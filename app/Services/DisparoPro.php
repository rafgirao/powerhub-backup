<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;


class DisparoPro
{
    /**
     * @param $number
     * @param $text
     * @return mixed
     */
    public function sendSms($number, $text)
    {
        $number = (new Helper)->prepareBrPhoneNumber($number);
        $text = (new Helper)->clearSmsText($text);

        //O limite de mensagens por requisição é de 1000.
        $response = Http::retry(3, 200)->withToken(env('DISPAROPRO_KEY'))->post(env('DISPAROPRO_URL') . '/mt', [
            'numero' => $number,
            'servico' => 'short',
            'mensagem' => $text,
            'parceiro_id' => null,
            'codificacao' => '0',
        ]);

        return json_decode($response->body());
    }

    /**
     * @return mixed
     */
    public function getSmsBalance()
    {
        $response = Http::retry(3, 200)->withToken(env('DISPAROPRO_KEY'))->get(env('DISPAROPRO_URL') . '/balance', [
        ]);

        return json_decode($response->body());
    }
}
