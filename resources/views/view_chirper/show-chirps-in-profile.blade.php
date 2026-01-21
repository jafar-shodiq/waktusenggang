<x-layout>
    <div class="max-w-2xl mx-auto mt-8">

        <!-- User info -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
            <p class="text-gray-500 text-sm">User ID: {{ $user->id }}</p>
        </div>
        
        <x-component-search-bar :action="route('route_chirper.route_profile.route_show', $user)" placeholder="Search this user's chirps..." />

        <!-- Chirps -->
        <div class="space-y-4">
            <div class="mt-8">
                {{ $chirps->links() }}
            </div>
            
            @forelse ($chirps as $chirp)
                <x-component-chirp :passed_var_chirp="$chirp" />
            @empty
                <p class="text-gray-500">This user has not chirped yet.</p>
            @endforelse

            <div class="mt-8">
                {{ $chirps->links() }}
            </div>
        </div>

    </div>
</x-layout>
