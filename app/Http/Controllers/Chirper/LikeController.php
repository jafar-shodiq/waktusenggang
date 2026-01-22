<?php

namespace App\Http\Controllers\Chirper;

use App\Models\Chirp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Chirp $url_chirp_id)
    {
        $user = auth()->user();

        // Check if the like already exists
        if ($user->likedChirps()->where('chirp_id', $url_chirp_id->id)->exists()) {
            $user->likedChirps()->detach($url_chirp_id->id);
        } else {
            $user->likedChirps()->attach($url_chirp_id->id);
        }

        return back();
    }
}
