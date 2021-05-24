<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Scopes\AccountScope;
use App\Services\Deeplink;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class LinkController
 * @package App\Http\Controllers
 */
class LinkController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('links.link', [
            'alert' => session()->get('alert'),
            'error' => session()->get('error'),
            'success' => session()->get('success'),
        ]);
    }

    /**
     * @param $short_link
     * @return Application|Factory|View|RedirectResponse|Redirector
     * @throws Exception
     */
    public function shortLink($short_link)
    {
        $link = Link::withoutGlobalScope(AccountScope::class)->where('short_link', $short_link)->first();
        $link->increment('clicks', 1);

        return $this->urlRedirect($link->url);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     * @throws Exception
     */
    public function urlParam(Request $request)
    {
        $link = $request->input('url');

        return $this->urlRedirect($link);
    }

    /**
     * @param $link
     * @return Application|Factory|View|RedirectResponse|Redirector
     * @throws Exception
     */
    protected function urlRedirect($link)
    {
        $social = (new Deeplink)->getSocial($link);

        if ($social === 'ig') {
            $uri = (new Deeplink)->instagramUrlPrepare($link);

            if ($uri === 'roolback') {
                return redirect($link);
            }

            return view('links.instagram', ['uri' => $uri]);
        }

        if ($social === 'yt') {
            $uri = (new Deeplink)->youtubeUrlPrepare($link);
            return view('links.youtube', ['uri' => $uri]);
        }
        return redirect($link);
    }
}
