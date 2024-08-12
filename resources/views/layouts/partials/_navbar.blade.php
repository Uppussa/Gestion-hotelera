<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{route('home')}}">
        <img src="{{asset('public/assets/custom/images/logo.svg')}}" alt="" height="40"> {{env('APP_NAME')}}
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <div class="d-none d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0">
        
    </div>
    <!-- Navbar-->

    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        <li class="no-cerrar nav-item dropdown">
            <button type="button" class="btn btn-link nav-link py-2 px-0 px-lg-2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <i class="bi bi-search fs-4"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="width: 300px;">
                <div class="row p-3">
                    <div class="col-md-12">
                        <form action="post" class="form-search-global" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="input-group">
                                <input class="form-control txtSearchGlobal" type="text" placeholder="Buscar..." aria-label="Buscar..." aria-describedby="btnNavbarSearch" />
                                <button class="btn btn-primary btnSearchGlobal" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <div class="col-md-12 div-cnt-search-global max-h-32"></div>
                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <button class="nav-link py-2 px-0 px-lg-2 text-white dropdown-toggle" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (dark)">
                <i id="i-icon-them" class="bi bi-sun-fill text-white fs-4"></i>
            </button>
            <ul class="dropdown-menu text-small dropdown-menu-end" aria-labelledby="bd-theme-text">
                <li>
                    <button type="button" class="dropdown-item active" data-bs-theme-value="light" aria-pressed="true">
                        Ligth <i class="bi bi-sun-fill float-end"></i>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                        Dark <i class="bi bi-moon-stars-fill float-end"></i>
                    </button>
                </li>
            </ul>
        </li>

        <li class="no-cerrar nav-item dropdown">
            <button type="button" class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                <img src="{{(!is_null(auth()->user()->avatar) && auth()->user()->avatar!='none.png'? asset(auth()->user()->avatar) : asset('public/assets/custom/images/404.png'))}}" alt="mdo" width="32" height="32" class="rounded-circle"> {{ auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <h6 class="dropdown-header">
                        {{auth()->user()->email}} <span class="badge text-bg-{{auth()->user()->level->color}}">{{auth()->user()->level->nom}}</span>
                    </h6>
                </li>
                <li>
                    
                </li>

                <li><hr class="dropdown-divider"></li>
                @foreach (auth()->user()->menuNavbar as $permiso)
                    <li>
                        <a class="dropdown-item" href="{{route($permiso->module->url_module)}}">
                            <i class="fs-5 mt-2 {{$permiso->module->icon}}"></i> {{$permiso->module->desc}}
                        </a>
                    </li>
                @endforeach
    
                @if(auth()->user()->level_cat_id==3)
                    <li><hr class="dropdown-divider"/></li>
                    <li>
                        <a class="dropdown-item" href="{{route('myPermits')}}">
                            <i class="fs-5 bi bi-check2-circle"></i> Permisos
                        </a>
                    </li>
                @endif

                <li><hr class="dropdown-divider" /></li>
                <li>
                    <a href="{{route('logout')}}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fs-5 bi bi-power text-danger"></i> Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
