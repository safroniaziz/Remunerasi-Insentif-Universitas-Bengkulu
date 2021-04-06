<li>
    <a href=" {{ route('verifikator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>
<li >
    <a href=" {{ route('verifikator.dataremun') }} "><i class="fa fa-book"></i>Data Remunisasi</a>
</li>

<li style="padding-left:2px;">
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off text-danger"></i>{{__('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</li>
