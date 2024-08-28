<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ModelUserRights;

class LandingPageController extends Controller
{
    public function index()
    {
        return $this->viewPage();
    }

    public function CheckEmailPassword(Request $request){
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        $query = ModelUserRights::where([
            'email' => $validatedData['email'],
            'pass' => $validatedData['password']
        ])->first();

        if(!empty($query)){
            $this->setSession($validatedData);
            return redirect('/dashboard');
        } else {
            return response()->json([
                'is_success' => false,
            ], 404);
        }
    }
}