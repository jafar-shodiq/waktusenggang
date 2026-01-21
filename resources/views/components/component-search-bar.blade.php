@props(['placeholder', 'action'])

<div class="flex flex-col items-end mt-6 mb-6">
    <div class="flex items-center gap-2">
        <button type="button" class="text-black hover:opacity-70 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m9-7.5L12 13.5m0 0L7.5 9m4.5 4.5V3" />
            </svg>
        </button>

        <form method="GET" action="{{ $action }}" class="w-full sm:w-auto">
            <label class="input input-bordered flex items-center gap-2 w-full sm:w-64 md:w-80">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="black" class="h-4 w-4 min-w-[16px] flex-shrink-0 opacity-70">
                    <path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" />
                </svg>
                <input type="text" name="search" class="grow border-none focus:ring-0 p-0" placeholder="{{ $placeholder }}" value="{{ request('search') }}" />
                @if(request('search'))
                    <a href="{{ $action }}" class="hover:text-error transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
                <button type="submit" class="hidden"></button>
            </label>
        </form>
    </div>
</div>