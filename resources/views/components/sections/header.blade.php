
<header class="text-white bg-black shadow">
  <x-container>
    <nav class="flex items-center justify-between py-4">
      <a
        wire:navigate
        href="/"
        class="flex items-center flex-shrink-0 mr-auto"
        aria-label="{{ config('app.name') }}"
      >
        <x-logo />
      </a>

      <div>
       
          @if(Auth::user())
            @foreach(Auth::user()->roles->pluck('name')->toArray() AS $key => $val)
              <x-button
                :icon="Auth::check() ? 'heroicon-o-cog' : 'heroicon-s-user'"
                size="xs"
                url="/{{$val}}"
              >
                {{ Auth::check() ? $val : 'Login' }}
              </x-button>
            @endforeach
          @else
              <x-button
                :icon="Auth::check() ? 'heroicon-o-cog' : 'heroicon-s-user'"
                size="xs"
                url="{{ url('/admin') }}"
              >
                Admin Login
              </x-button>
              <x-button
                :icon="Auth::check() ? 'heroicon-o-cog' : 'heroicon-s-user'"
                size="xs"
                url="{{ url('/coach') }}"
              >
                Coach Login
              </x-button>
              <x-button
                :icon="Auth::check() ? 'heroicon-o-cog' : 'heroicon-s-user'"
                size="xs"
                url="{{ url('/rider') }}"
              >
                Rider Login
              </x-button>

          @endif
      </div>
    </nav>
  </x-container>
</header>
