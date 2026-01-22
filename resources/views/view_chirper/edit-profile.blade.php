<x-layout>
    <div class="max-w-2xl mx-auto py-12 px-4">
        <div class="bg-base-100 rounded-3xl shadow-xl border border-base-200 overflow-hidden">
            
            <div class="bg-primary p-8 text-primary-content">
                <h2 class="text-2xl font-black italic">Edit Profile</h2>
                <p class="opacity-80 text-sm">Update your personal information and avatar</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('route_chirper.route_profile.route_update', $url_user_id) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col md:flex-row items-center gap-8 p-6 bg-base-200/50 rounded-2xl">
                        <div class="avatar placeholder">
                            <div class="w-24 rounded-full bg-neutral text-neutral-content flex items-center justify-center ring ring-primary ring-offset-base-100 ring-offset-4">
                                @if ($url_user_id->avatar_url)
                                    <img src="{{ $url_user_id->avatar_url }}" alt="{{ $url_user_id->name }}" />
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 opacity-50">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 space-y-2 text-center md:text-left">
                            <label class="block text-sm font-bold opacity-70">Profile Picture</label>
                            <input type="file" name="avatar" 
                                class="file-input file-input-bordered file-input-primary w-full max-w-xs shadow-sm" 
                                accept="image/*" />
                            <p class="text-[10px] text-base-content/50 italic">Recommended: Square JPG or PNG, max 1MB</p>
                            @error('avatar')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid gap-6">
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-bold">Display Name</span></label>
                            <input type="text" name="name" value="{{ old('name', $url_user_id->name) }}" 
                                class="input input-bordered focus:border-primary w-full shadow-sm" required />
                            @error('name')
                                <p class="text-error text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-bold">Email Address</span></label>
                            <input type="email" name="email" value="{{ old('email', $url_user_id->email) }}" 
                                class="input input-bordered opacity-70 bg-base-200 cursor-not-allowed w-full shadow-sm" readonly />
                            <p class="text-[10px] mt-1 px-1 opacity-50 italic">Email cannot be changed at this time.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-base-200">
                        <a href="{{ route('route_chirper.route_profile.route_show', $url_user_id) }}" class="btn btn-ghost btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm px-8 shadow-lg shadow-primary/20">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>