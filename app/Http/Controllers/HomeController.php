<?php

namespace App\Http\Controllers;

use App\Models\MenuAkses;
use App\Models\MenuMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $akses = DB::table('vi_menu_akses_mains')->get();
        $sub = MenuMain::join('sub_menus', 'sub_menus.menu_id', '=', 'menu_mains.menu')->select('sub_menus.*', 'menu_mains.judul', 'menu_mains.menu')->get();
        return view('home', [
            'akses' => $akses,
            'sub' => $sub
        ]);
        // return view('home');
    }
}
