<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', $user->id)->orWhereHas('members', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('home', compact('projects'));
    }
}
