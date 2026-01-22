<?php

namespace App\Http\Controllers\Chirper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public function show(Request $request, User $url_user_id)
    {
        $chirps = $url_user_id->chirps()
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
            'user' => $url_user_id,
            'chirps' => $chirps
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
    if ($url_user_id->id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'avatar' => ['nullable', 'image', 'max:5120'], // Allow 5MB upload, we will shrink it
    ]);

    $url_user_id->name = $request->name;

    if ($request->hasFile('avatar')) {
        // 1. Delete old avatar
        if ($url_user_id->avatar_path) {
            Storage::disk('public')->delete($url_user_id->avatar_path);
        }

        // 2. Process the image with Intervention
        $file = $request->file('avatar');
        
        // This creates a square crop (400x400) and converts to WebP at 80% quality
        $processedImage = Image::read($file)
            ->cover(400, 400)
            ->toWebp(80); 

        // 3. Define the path and filename
        $filename = 'avatars/' . hexdec(uniqid()) . '.webp';

        // 4. Use Storage::put instead of store()
        // We cast the processed image to string to save the binary data
        Storage::disk('public')->put($filename, (string) $processedImage);
        
        $url_user_id->avatar_path = $filename;
    }

    $url_user_id->save();

    return redirect()->route('route_chirper.route_profile.route_show', $url_user_id)
                     ->with('status', 'Profile updated!');
}
}
