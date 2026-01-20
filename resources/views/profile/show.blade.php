<x-layout>
    <div class="max-w-2xl mx-auto mt-8">

        <!-- User info -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">
                {{ $user->name }}
            </h1>
            <p class="text-gray-500 text-sm">
                User ID: {{ $user->id }}
            </p>
        </div>

        <!-- Chirps -->
        <div class="space-y-4">
            @forelse ($user->chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                <p class="text-gray-500">
                    This user has not chirped yet.
                </p>
            @endforelse
        </div>

    </div>
</x-layout>
