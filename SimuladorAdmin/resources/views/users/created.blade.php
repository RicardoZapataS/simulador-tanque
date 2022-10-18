@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('usuario.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Nuevo usuario</li>
@endsection

@section('name')
Nuevo usuario
@endsection

@section('content')
<div class="conainer-fluid">
<!-- SELECT2 EXAMPLE -->
<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Usuario</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="" id="users_errors"></div>

        <form action="{{ route('usuario.store') }}" id="startRoom" method="POST" class="row">
            @csrf
{{--            @method('PUT')--}}
            <div class="col-md-6">

                <div class="form-group">
                    <label>Nombre:</label>
                    <div class="input-group mb-3">
                        <input name="name" id="tankSize" type="text" class="form-control">
                    </div>
                </div>
                <!-- /.form group -->

                <div class="form-group">
                    <label>Rango:</label>
                    <div class="input-group mb-3">
                        <input name="range" id="range" type="text" class="form-control" >
                    </div>
                </div>
                <!-- /.form group -->

            </div>
            <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                    <label>Correo:</label>
                    <div class="input-group mb-3">
                        <input name="email" id="email" type="email" class="form-control">
                        <input name="passw" value="unpassword" type="hidden">
                    </div>
                </div>
                <!-- /.form group -->
                <!-- /.form group -->

            </div>
            <!-- /.col -->
        </form>
        <!-- /.row -->

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {{-- <a href="{{route('simulator')}}" class="btn btn-sm btn-secondary float-left">Continuar simulacion</a> --}}
        <a onclick="event.preventDefault(); document.getElementById('startRoom').submit();" class="btn btn-sm btn-secondary float-right">Guardar</a>
    </div>
</div>
<!-- /.card -->
</div>
@endsection

@section('js')
<script>

</script>
@endsection

@section('css')

@endsection
