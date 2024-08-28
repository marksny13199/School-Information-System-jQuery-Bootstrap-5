<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ModelUserRights;

class DashboardController extends Controller
{
    public function index()
    {
        $page_data = [
            'content' => 'content.dashboard',
            'page_js' => [],
            'page_css' => []
        ];

        return $this->viewPage($page_data);
    }
}