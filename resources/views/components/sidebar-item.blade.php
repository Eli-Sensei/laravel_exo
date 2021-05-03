@props(["route", 'sub', "icon"])

<li class="nav-item">
    <a href="{{ route($route) }}" class="nav-link {{ currentRouteActive($route) }}">
        <li calss="
            @isset($sub)
                far fa-circle
            @endisset

            nav-icon

            @isset($icon)
                far fa-{{$icon}}
            @endisset
        "></li>
        <p>{{ $slot }}</p>
    </a>
</li>