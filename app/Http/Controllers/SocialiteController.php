<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;


class SocialiteController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse
    {
        session()->reflash();

        if (str_contains($_SERVER['REQUEST_URI'], 'facebook')) {

            $social = 'facebook';

            $scopes = [
                'pages_show_list',
                'pages_manage_ads',
                'ads_read'
            ];
            $parameters = [];
        }

        if (str_contains($_SERVER['REQUEST_URI'], 'google')) {
            $social = 'google';

            if ($_GET["scope"] === 'sheets') {

                session()->flash('scope', 'sheets');

                $scopes = [
                    'openid',
                    'profile',
                    'email',
                    'https://www.googleapis.com/auth/spreadsheets',
                ];

                $parameters = [
                    'access_type' => 'offline',
                    'include_granted_scopes' => 'true',
                ];
            }

            if ($_GET["scope"] === 'drive') {

                session()->flash('scope', 'drive');

                $scopes = [
                    'openid',
                    'profile',
                    'email',
                    'https://www.googleapis.com/auth/drive',
                ];

                $parameters = [
                    'access_type' => 'offline',
                    'include_granted_scopes' => 'true',
                ];
            }

            if ($_GET["scope"] === 'login') {

                session()->flash('scope', 'sheets');

                $scopes = [
                    'openid',
                    'profile',
                    'email',
                    'https://www.googleapis.com/auth/spreadsheets',
                ];

                $parameters = [
                    'access_type' => 'offline',
                    'include_granted_scopes' => 'true',
                ];
            }
        }

        if (!$social or !$scopes) {
            return back()->withErrors([
                'error',
                'Não foi possível prosseguir com a solicitação. Por favor, tente novamente mais tarde!'
            ]);
        }

        return Socialite::driver($social)->setScopes($scopes)->with($parameters)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return RedirectResponse
     */
    public function handleProviderCallback(): RedirectResponse
    {
        session()->reflash();

        if (str_contains($_SERVER['REQUEST_URI'], 'facebook')) {

            $fbResponse = Socialite::driver('facebook');
            $user = $fbResponse->user();

            $fbAdAccounts = json_decode(Http::retry(3, 1000)
                ->get('https://graph.facebook.com/v10.0/me?fields=adaccounts.limit(1000){name,currency,timezone_name}&access_token=' . $user->token . '&limit=1000')
                ->body())->adaccounts->data;

            session()->flash('modal', 'Facebook Modal');
            session()->flash('fbToken', $user->token);
            session()->flash('fbAdAccounts', $fbAdAccounts);
            session()->flash('expiresIn', $user->expiresIn);

            return redirect()->route('integrations');
        }

        if (str_contains($_SERVER['REQUEST_URI'], 'google')) {

            $googleResponse = Socialite::driver('google');
            $user = $googleResponse->user();

            if (!isset($user->refreshToken)) {
                $endpoint = 'https://oauth2.googleapis.com/revoke?token='.$user->token;
                $response = Http::retry(3, 2000)->asForm()->post($endpoint);
                session()->forget('modal');

                return redirect()->route('google.start', ['scope' => session()->get('scope')]);
            }

            if (session()->get('scope') === 'drive') {

                session()->flash('googleRefreshToken', $user->refreshToken);
                return redirect()->route('integrations.google');
            }
        }
    }
}
