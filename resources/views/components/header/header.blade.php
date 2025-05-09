<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/components/header/header.css', 'resources/js/app.js'])

</head>

<div class="home-header">
    <div class="home-header-content">
        <div class="home-header-firstcontent">
            <p class="home-header-firstcontent-text1">
                {{ $title }} @isset($details)
                    <span class="title-details"> > {{ $details }}</span>
                @endisset
            </p>

        </div>
        <div class="home-header-secondcontent">
            <span class="menu-initals">
                @php
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
            <div class="user-wrapper" style="position: relative;">
                <img class="cursor-pointer" src="{{ asset('images/dropdown.png') }}" alt="dropdown"
                    id="dropdownToggle" />

                <div id="dropdownMenu" class="dropdown-menu-custom hidden">
                    <div class="modal-arrow"></div>
                    <img class="cursor-pointer" src="{{ asset('images/button-editar.svg') }}" data-bs-toggle="modal"
                        data-bs-target="#modalUserEdit" />
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <img class="cursor-pointer" src="{{ asset('images/button-logout.svg') }}" alt="logout"
                        onclick="document.getElementById('logoutForm').submit();" />
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.modal-user-edit')
    <script>
        const toggle = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        toggle.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', function(event) {
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</div>
