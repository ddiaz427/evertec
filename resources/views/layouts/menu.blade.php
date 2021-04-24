
<li class="nav-item">
    <a class="nav-link" href="{{ url('/') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Inicio</span>
    </a>
</li>
<li class="nav-item {{ Request::is('orders*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('orders.index') }}">
        <i class="nav-icon icon-cursor"></i>
        @if(Auth::user()->is_customer == 0)
            <span>Listado ordenes</span>
        @else
            <span>Mis ordenes</span>
        @endif
    </a>
</li>
