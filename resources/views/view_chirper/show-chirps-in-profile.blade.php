<x-layout>
    <div class="max-w-2xl mx-auto mt-8 px-4">

        {{-- Top Navigation & Title --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-black tracking-tighter">Chirper</h1>
            
            <a href="{{ route('route_chirper.route_home') }}" class="btn btn-ghost btn-sm gap-2 rounded-full border border-base-300 hover:border-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Home
            </a>
        </div>

        {{-- Profile Header Container --}}
        <div class="flex items-start justify-between mb-8 p-6 bg-base-100 rounded-2xl shadow-sm border border-base-200">
            <div class="flex items-center gap-6">
                <div class="avatar placeholder">
                    <div class="w-20 rounded-full bg-neutral text-neutral-content flex items-center justify-center">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" />
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 opacity-50">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h1 class="text-3xl font-black tracking-tight text-base-content">{{ $user->name }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="badge badge-ghost font-mono text-xs opacity-70">ID: {{ $user->id }}</span>
                        <span class="text-base-content/50 text-xs">·</span>
                        {{-- Added Dynamic Chirp Count --}}
                        <span class="text-base-content/50 text-xs font-bold uppercase tracking-tighter">
                            {{ $user->chirps()->count() }} {{ Str::plural('Chirp', $user->chirps()->count()) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- The Edit Button --}}
            @if (auth()->id() === $user->id)
                <a href="{{ route('route_chirper.route_profile.route_edit', $user) }}" class="btn btn-ghost btn-xs border-base-300 gap-2 hover:border-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                    Edit Profile
                </a>
            @endif
        </div>

        <div class="flex gap-8 border-b border-base-300 mb-6">
            {{-- Chirps Tab --}}
            <a href="{{ route('route_chirper.route_profile.route_show', $user) }}" 
            class="pb-4 text-sm font-bold transition-colors hover:text-primary {{ !isset($showingLikes) ? 'border-b-2 border-primary text-primary' : 'text-base-content/50' }}">
                Chirps
            </a>

            {{-- Likes Tab --}}
            <a href="{{ route('route_chirper.route_profile.route_show_likes', $user) }}" 
            class="pb-4 text-sm font-bold transition-colors hover:text-primary {{ isset($showingLikes) ? 'border-b-2 border-primary text-primary' : 'text-base-content/50' }}">
                Likes
            </a>
        </div>
        
        <x-component-search-bar :action="route('route_chirper.route_profile.route_show', $user)" placeholder="Search {{ $user->name }}'s chirps..." />

        {{-- Feed Section --}}
        <div class="space-y-4 mt-8">
            @if($chirps->hasPages())
                <div class="flex justify-center mb-4 scale-90 opacity-80">
                    {{ $chirps->onEachSide(1)->links() }}
                </div>
            @endif
            
            @forelse ($chirps as $chirp)
                <x-component-chirp :passed_var_chirp="$chirp" />
            @empty
                <div class="text-center py-12 bg-base-200/30 rounded-xl border border-dashed border-base-300">
                    <p class="text-base-content/50 italic text-sm">No chirps match the current filter.</p>
                </div>
            @endforelse

            <div class="mt-8 flex justify-center">
                {{ $chirps->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</x-layout>