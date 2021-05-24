<?php

namespace App\Http\Controllers;

use App\Services\Helper;

class PageController extends Controller
{
    /**
     * Display all the static old when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        (new Helper)->getAccountInfo();

        if (view()->exists("old.{$page}")) {
            return view("old.{$page}");
        }

        return abort(404);
    }

    /**
     * Display the pricing page
     *
     * @return \Illuminate\View\View
     */
    public function pricing()
    {
        return view('old.pricing');
    }

    /**
     * Display the lock page
     *
     * @return \Illuminate\View\View
     */
    public function lock()
    {
        return view('old.lock');
    }
}
