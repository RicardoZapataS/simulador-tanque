@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">usuarios</li>
@endsection

@section('name')
    Usuarios
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de usuarios Administradores</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table_admin" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre Completo</th>
                                    <th>Cargo</th>
                                    <th>Correo</th>
                                    <th>Fecha ingreso</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($admins as $key => $admin)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <a href="{{route('usuario.admin')}}" class="btn btn-sm btn-secondary float-right mt-3">Nuevo administrador</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Lista de usuarios </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table_admin" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre Completo</th>
                                    <th>Cargo</th>
                                    <th>Correo</th>
                                    <th>Fecha ingreso</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $key => $admin)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <a href="{{route('usuario.create')}}" class="btn btn-sm btn-secondary float-right mt-3">Nuevo usuario</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#table_admin").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            });
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
