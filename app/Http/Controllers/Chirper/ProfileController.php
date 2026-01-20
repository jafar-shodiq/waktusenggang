<?php

namespace App\Http\Controllers\Chirper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load('chirps.user');
        return view('chirper.profile.show', ['user' => $user]);
    }
}
