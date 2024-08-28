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
     * Load a specific view with the provided data or redirect based on session status.
     *
     * @param array $data
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */

    public function viewPage(array $data = []): View|\Illuminate\Http\RedirectResponse
    {
        if (Session::has('session_data')) {
            if(empty($data)){
                return redirect('/dashboard');
            } else {
                return view('page_structure.layout', $data);
            }
        } else {
            return view('landing_page.login');
        }
    }

    public function setSession($sess_data): void
    {
        session([ 
            'session_data' => $sess_data
        ]);
        Session::save();
    }
}
