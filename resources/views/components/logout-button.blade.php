@props(['label' => 'Logout', 'mobile' => false])

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-white hover:underline {{ $mobile ? 'px-4 py-2' : '' }}">
        <i class="fa fa-sign-out-alt{{ $mobile ? ' mr-1' : '' }}"></i> {{ $label }}
    </button>
</form>
