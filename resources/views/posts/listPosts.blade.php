@extends('layouts.appDash')
@section('breadcrumb')
	@include('layouts.partials._breadcrumbs')
@endsection

@section('content')
@include('users.mdls')

<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 d-none">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">
                <i class="far fa-clipboard-list"></i> Usuarios
            </h3>
        </div>
    </div>
    <div class="card-body pt-4 pb-0">
        <form action="post" class="form-search" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="row g-3">
                <div class="col-lg-1 col-md-1 col-sm-2 col-2">
                    <button id="btn-limit" class="btn btn-default dropdown-toggle btn-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-list"></i> <span class="d-none d-md-inline-block">10</span>
                    </button>
                    <ul class="dropdown-menu select-dropdown dropdown-limit">
                        <li>
                            <a class="dropdown-item" href="#" data-desc="10" data-icon="bi bi-list" data-edo="10" data-btn="btn-limit">10</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-desc="20" data-icon="bi bi-list" data-edo="20" data-btn="btn-limit">20</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-desc="30" data-icon="bi bi-list" data-edo="30" data-btn="btn-limit">30</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-desc="40" data-icon="bi bi-list" data-edo="40" data-btn="btn-limit">40</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-desc="50" data-icon="bi bi-list" data-edo="50" data-btn="btn-limit">50</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                    <div class="input-group mb-3">
                        <button id="btn-filter" class="btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-lines-fill"></i> <span class="d-none d-md-inline-block">Todos</span>
                        </button>
                        <ul class="dropdown-menu select-dropdown dropdown-edo">
                            <li>
                                <a class="dropdown-item" href="#" data-desc="Todos" data-icon="bi bi-person-lines-fill" data-edo="0" data-btn="btn-filter">
                                    <i class="bi bi-person-lines-fill"></i> Todos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-desc="Activos" data-icon="bi bi-person-check" data-edo="1" data-btn="btn-filter">
                                    <i class="bi bi-person-check"></i> Activos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-desc="Bloqueados" data-icon="bi bi-person-x" data-edo="2" data-btn="btn-filter">
                                    <i class="bi bi-person-x"></i> Bloqueados
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-desc="Baneados" data-icon="bi bi-person-dash" data-edo="3" data-btn="btn-filter">
                                    <i class="bi bi-person-dash"></i> Baneados
                                </a>
                            </li>
                        </ul>

                        <button class="btn btn-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <div class="no-cerrar dropdown-menu w-20">
                            <div class="form-row row g-3 p-2 m-0">
                                <div class="col-md-12 mb-2 mt-1">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="chk-act-fc" id="chk-act-fc">
                                        <label class="form-check-label small" for="chk-act-fc">Utilizar fechas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">Inicio</span>
                                        <input type="date" class="form-control date-range" name="dt-ini" id="dt-ini" value="{{todayMasD(0)}}" title="Fecha final" max="{{todayMasD(0)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">Fin</span>
                                        <input type="date" class="form-control" name="dt-fin" id="dt-fin" value="{{todayMasD(0)}}" title="Fecha final" max="{{todayMasD(0)}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="txt-search" type="text" class="form-control pb-1 pt-1 border rounded-0 border-end-0 border-secondary" aria-label="Text" autocomplete="off">
                        <button type="submit" class="btn border border-secondary border-start-0 border-top border-end border-bottom btn-search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-3 align-items-end">
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <div class="input-group justify-content-end desplegable">
                                <a href="{{route('addUser')}}" class="btn btn-primary" title="Agregar registro">
                                    <i class="bi bi-plus-circle"></i> Agregar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12 mb-2">
                <span id="h5-cnt-total" class="float-end"></span>
            </div>
        </div>
        <div class="row">
            <div id="div-cnt-load" class="col-md-12 mb-3"></div>
        </div>
    </div>
</div>

@endsection
@section('script')
	<script src="{{asset('public/assets/custom/ajx/ajxpost.js')}}"></script>
	<script>
		$(document).ready(function() {
            load(1);

            
            setInterval(getLastPosts,5000);
		});
	</script>
@endsection