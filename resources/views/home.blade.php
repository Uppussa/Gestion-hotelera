@extends('layouts.appDash')

@section('content')
<div class="container-fluid mt-4">
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <div class="row">
        @foreach (auth()->user()->permits as $permiso)
            @php
            $idModule = $permiso->module->module_id;
            $dquery['query'] = $permiso->module->query;
            @endphp
            <div class="col-lg-3 col-6 mb-3">
                <div class="small-box text-bg-{{$permiso->module->color}}">
                    <div class="inner">
                        <h3>
                            {{countRegister($dquery)}}
                        </h3>
                        <p>
                            <a href="{{$permiso->url_module}}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                {{$permiso->module->desc}} <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </p>
                    </div>
                    <i class="small-box-icon {{$permiso->module->icon}}"></i>
                    <div class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover text-end">
                        <div class="btn-group mx-2">
                            <a href="#" class="dropdown-toggle btn btn-link text-white" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i> Acciones
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach (auth()->user()->permisosModulo($idModule) as $subModulo)
                                <li>
                                    <a class="dropdown-item" href="{{$subModulo->url_module}}">
                                        <i class="{{$subModulo->module->icon}}"></i> {{$subModulo->module->desc}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4 mb-4">
        <div class="col-md-12">
            <div id="container"></div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on("click", ".btnAlerta", function (e) {
                notifyMsg('Hola mundo', '', 'success', '')
            });
        });
    </script>
@endsection