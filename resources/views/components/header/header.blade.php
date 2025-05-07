<div class="home-header">
    <div class="home-header-content">
        <div class="home-header-firstcontent">
            <p class="home-header-firstcontent-text1">
                {{ $title }}</p>
        </div>
        <div class="home-header-secondcontent">
            <span class="menu-initals"> @php
                if (auth()->check() && auth()->user()->name) {
                    $nameParts = explode(' ', auth()->user()->name);
                    $initials = '';
                    foreach ($nameParts as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                    echo $initials;
                } else {
                    echo 'XX';
                }
            @endphp
            </span>
            <span class="menu">
                @if (auth()->check() && auth()->user()->name)
                    {{ auth()->user()->name }}
                @else
                    Nome não disponível
                @endif
            </span>
            <img class="cursor-pointer" src="{{ asset('images/dropdown.png') }}" alt="dropdown" data-bs-toggle="modal"
                data-bs-target="#modalUserEdit">
        </div>
    </div>
    @include('components.modals.modal-user-edit')
    @vite(['resources/js/app.js'])
</div>
