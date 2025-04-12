<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class OrderController extends Controller
{
	public function index(): View|Factory|Application
	{
		return view('order.index');
	}
}
