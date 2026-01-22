
@props(['passed_var_chirp'])

{{-- Added dynamic ID so the browser can scroll to this specific chirps --}}
<div id="chirp-{{ $passed_var_chirp->id }}" class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex space-x-3">
            <div class="avatar {{ !$passed_var_chirp->user ? 'placeholder' : '' }}">
                <div class="size-10 rounded-full bg-neutral text-neutral-content flex items-center justify-center">
                    @if ($passed_var_chirp->user && isset($passed_var_chirp->user->avatar_path))
                        <img src="{{ $passed_var_chirp->user->avatar_url }}" alt="{{ $passed_var_chirp->user->name }}" />
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 opacity-50">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    @endif
                </div>
            </div>

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        @if ($passed_var_chirp->user)
                            <a href="{{ route('route_chirper.route_profile.route_show', $passed_var_chirp->user) }}" class="text-sm font-semibold hover:underline">{{ $passed_var_chirp->user->name }}</a>
                        @else
                            <span class="text-sm font-semibold">Anonymous</span>
                        @endif
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $passed_var_chirp->created_at->diffForHumans() }}</span>
                        @if ($passed_var_chirp->updated_at->gt($passed_var_chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>

                    <!-- Replace the temporary @php block and $canEdit check with: -->
                    @can('update', $passed_var_chirp)
                        <div class="flex gap-1">
                            <a href="{{ route('route_chirper.route_chirps.route_edit', $passed_var_chirp) }}"
                            class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('route_chirper.route_chirps.route_destroy', $passed_var_chirp) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>

                <p class="mt-1">{{ $passed_var_chirp->message }}</p>

                <div class="flex items-center mt-4">
                    {{-- Use a form because "Like" is a data-changing (POST) action --}}
                    {{-- Added the #anchor to the end of the route --}}
                    <form method="POST" action="{{ route('route_chirper.route_chirps.route_like_toggle', $passed_var_chirp) }}#chirp-{{ $passed_var_chirp->id }}">
                        @csrf
                        <button type="submit" 
                            class="group flex items-center gap-1.5 text-sm transition-colors {{ $passed_var_chirp->likes->contains(auth()->id()) ? 'text-error' : 'text-base-content/50 hover:text-error' }}">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                fill="{{ $passed_var_chirp->likes->contains(auth()->id()) ? 'currentColor' : 'none' }}" 
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                class="size-5 transition-transform group-hover:scale-110">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            
                            <span>{{ $passed_var_chirp->likes_count ?? $passed_var_chirp->likes()->count() }}</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>