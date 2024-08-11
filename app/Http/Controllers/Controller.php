<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     /**
     * Load a specific view with the provided data.
     *
     * @param string $page
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function viewPage(string $page = 'landing_page.login', array $data = []): View
    {
        if (Session::has('sess_id')) {
            return view($page, $data);
        } else {
            return view('landing_page.login');
        }
    }
}
