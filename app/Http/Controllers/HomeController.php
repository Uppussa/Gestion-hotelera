<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = 'Inicio';
        $data['tab'] = 'main';
        $data['url'] = '';
        return view('home', $data);
    }

    public function dashboard()
    {
        $data['title'] = 'Inicio';
        $data['tab'] = 'main';
        $data['url'] = '';

        /*$data['datag'] = User::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');*/

        return view('home', $data);
    }
}
