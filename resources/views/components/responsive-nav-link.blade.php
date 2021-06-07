@props(['active','linkClasses'])

<a class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium focus:outline-none transition duration-150 ease-in-out {{$linkClasses}}">
    {{ $slot }}
</a>
