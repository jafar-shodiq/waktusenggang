<?php

namespace App\Http\Controllers\Chirper;

use App\Http\Controllers\Controller;
use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chirps = Chirp::with(['user', 'likes']) // Added 'likes' here to eager load relationship
            ->withCount('likes') // Adds a 'likes_count' attribute to each chirp automatically
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) { // Grouped where for cleaner SQL
                    $q->where('message', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($innerQ) use ($search) {
                        $innerQ->where('name', 'like', '%' . $search . '%');
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->onEachSide(1)
            ->withQueryString();

        return view('view_chirper.view-home-chirper', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        auth()->user()->chirps()->create($validated);

        return redirect()->route('route_chirper.route_home')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $url_chirp_id)
    {
        if ($url_chirp_id->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    
        return view('view_chirper.edit-one-chirp', compact('url_chirp_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $url_chirp_id)
    {
        if ($url_chirp_id->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);
    
        // Update
        $url_chirp_id->update($validated);

        return redirect()->route('route_chirper.route_home')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $url_chirp_id)
    {
        if ($url_chirp_id->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $url_chirp_id->delete();

        return redirect()->route('route_chirper.route_home')->with('success', 'Chirp deleted!');
    }
}
