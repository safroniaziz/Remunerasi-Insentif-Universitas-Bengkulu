<li>
    <a href=" {{ route('admin.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

{{-- <li><a><i class="fa fa-building-o"></i>Divisi Universitas <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href=" {{ route('operator.fakultas') }} ">Fakultas</a></li>
        <li><a href=" {{ route('operator.prodi') }} ">Program Study</a></li>
    </ul>
</li> --}}

{{-- <li>
    <a href=" {{ route('operator.skim') }} "><i class="fa fa-info-circle"></i>Skim Penelitian</a>
</li> --}}

<li><a><i class="fa fa-check-square"></i>Contoh Dropdown Menu <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu">
        <li><a href="  ">Menu 1</a></li>
        <li><a href="  ">Menu 2</a></li>
        <li><a href="  ">Menu 3</a></li>
    </ul>
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
