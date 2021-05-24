<?php


namespace App\Webhooks;

use App\Models\Account;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;


class WebhookSignatureValidator implements SignatureValidator
{
    /**
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (!$request->has('act')) {
            return false;
        }

        if (isset($request[0])) {
            if (str_contains($request[0], 'hottok')) {
                $hottok = true;
            }
        }

        if (!$request->has('hub_challenge') and !$request->has('hottok') and !isset($hottok)) {
            return false;
        }

        $act = Account::where('uuid', $request->get('act'))->first();

        if (!$act) {
            return false;
        }

        $request->act = $act->id;

        if ($request->has('hottok')) {
            $request->name = 'Hotmart';
        }

        return true;
    }
}
