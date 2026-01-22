<?php

namespace App\Http\Controllers\Chirper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request, User $url_user_id)
    {
        $chirps = $url_user_id->chirps()
            ->with(['user', 'likes']) // Load likes to prevent N+1 queries
            ->withCount('likes')      // Add the likes_count attribute
            ->when($request->search, function ($query, $search) {
                // Only search within THIS user's chirps
                return $query->where('message', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->onEachSide(1)
            ->withQueryString();

        return view('view_chirper.show-chirps-in-profile', [
            'user' => $url_user_id,
            'chirps' => $chirps,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $url_user_id)
    {
        if ($url_user_id->id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('view_chirper.edit-profile', compact('url_user_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $url_user_id)
    {
        // Security check
        if ($url_user_id->id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old one if it exists
            if ($url_user_id->avatar_path) {
                \Storage::disk('public')->delete($url_user_id->avatar_path);
            }
            
            // Store new one
            $path = $request->file('avatar')->store('avatars', 'public');
            $url_user_id->avatar_path = $path;
        }

        $url_user_id->update(['name' => $validated['name']]);
        $url_user_id->save();

        return redirect()->route('route_chirper.route_profile.route_show', $url_user_id)
                        ->with('status', 'Profile Updated!');
    }

    public function showLikes(Request $request, User $url_user_id)
    {
        $chirps = $url_user_id->likedChirps()
            ->with(['user', 'likes']) 
            ->withCount('likes')
            ->when($request->search, function ($query, $search) {
                return $query->where('message', 'like', '%' . $search . '%');
            })
            // The relationship in User model handles the "latest" sorting
            ->paginate(10)
            ->onEachSide(1)
            ->withQueryString();

        return view('view_chirper.show-chirps-in-profile', [
            'user' => $url_user_id,
            'chirps' => $chirps,
            'showingLikes' => true, // Flag to identify which tab is active
        ]);
    }
}
