<?php


namespace App\Services;

use Illuminate\Support\Facades\Validator;


class EmailVerifier
{
    public function singleEmailValidator($email): bool
    {
        $validated = Validator::make(
            [
                'email' => $email
            ],
            [
                'email' => 'email:rfc,strict,dns,spoof,filter'
            ],
            [
                'email' => 'Invalid',
            ]
        );

        return !$validated->fails();
    }
}
