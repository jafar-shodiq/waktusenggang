<?php

namespace App\Http\Controllers\Chirper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $user_id)
    {
        $chirps = $user_id->chirps()
            ->with('user')
            ->when($request->search, function ($query, $search) {
                // Only search within THIS user's chirps
                return $query->where('message', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->onEachSide(1)
            ->withQueryString();

        return view('view_chirper.show-chirps-in-profile', [
            'user' => $user_id,
            'chirps' => $chirps
        ]);
    }
}
