<x-layout>
    <x-slot:title>
        Chirper
    </x-slot:title>

    <div class="max-w-2xl mx-auto px-4">
        <div class="flex items-center justify-between mt-8 mb-6">
            <h1 class="text-3xl font-black tracking-tighter">Chirper</h1>
            
            <a href="{{ route('route_chirper.route_profile.route_show', auth()->user()) }}" class="btn btn-outline btn-sm gap-2 rounded-full border-base-300 hover:bg-base-200 hover:text-base-content">
                <div class="avatar">
                    <div class="w-5 rounded-full">
                        @if (auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" />
                        @else
                            <div class="bg-neutral text-neutral-content flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                My Profile
            </a>
        </div>

        <!-- Chirp Form -->
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <form method="POST" action="{{ route('route_chirper.route_chirps.route_store') }}">
                    @csrf
                    <div class="form-control w-full">
                        <textarea
                            name="message"
                            placeholder="What's on your mind?"
                            class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror"
                            rows="4"
                        >{{ old('message') }}</textarea>

                        @error('message')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Chirp
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <x-component-search-bar :action="route('route_chirper.route_home')" placeholder="Search profiles or chirps..." />

        <!-- Feed -->
        <div class="space-y-4 mt-8">

            <div class="mt-8">
                {{ $chirps->links() }}
            </div>

            @forelse ($chirps as $chirp)
                <x-component-chirp :passed_var_chirp="$chirp" />
            @empty
                <div class="hero py-12">
                    <div class="hero-content text-center">
                        <div>
                            <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="mt-4 text-base-content/60">No chirps yet. Be the first to chirp!</p>
                        </div>
                    </div>
                </div>
            @endforelse

            <div class="mt-8">
                    {{ $chirps->links() }}
            </div>
        </div>
    </div>
</x-layout>