<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class UserController extends Controller
{
    public function index(): View|Factory|Application
    {
        $users = User::with(['orders'])->get();

        return view('user.index', ['users' => $users]);
    }
}
