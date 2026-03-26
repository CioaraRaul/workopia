@props(['url' => '/', 'icon' => null, 'active' => false, 'mobile' => false, 'block' => false])

<a href="{{ $url }}"
    class="{{ $bgClass ?? 'bg-yellow-500' }} {{ $hoverClass ?? 'hover:bg-yellow-600' }} {{ $textClass ?? 'text-black' }} px-4 py-2 rounded hover:shadow-md
    transition duration-300 {{ $block ? 'block' : '' }}">
    @if($icon)
    <i class="fa fa-{{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
