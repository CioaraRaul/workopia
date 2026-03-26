@props(['url' => '/', 'active' => false, 'icon' => null, 'mobile' => false])

<a href="{{ $url }}" class="text-white py-2 rounded transition duration-200 {{ $active ? 'text-yellow-500 font-bold' : '' }} {{ $mobile ? 'block px-4 hover:bg-blue-700' : 'hover:text-yellow-300 hover:bg-blue-800 px-2' }}">
    @if ($icon)
        <i class="fa fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</a>

