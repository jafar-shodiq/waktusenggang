
@props(['passed_var_chirp'])

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex space-x-3">
            @if ($passed_var_chirp->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($passed_var_chirp->user->email) }}"
                            alt="{{ $passed_var_chirp->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif

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
                            <form method="POST" action="/passed_var_chirp/{{ $passed_var_chirp->id }}">
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
            </div>
        </div>
    </div>
</div>