<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Pages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $pagesData = Pages::all();

        if(Auth::check())
        {
            Auth::id();

            $user = User::where('id', Auth::id())->first();
            $role_id = $user->role_id;
        }
        else
        {
            $role_id = 0;
        }

        return view('front.index', compact('pagesData','role_id'),['showFooter' => true]);
    }
}
