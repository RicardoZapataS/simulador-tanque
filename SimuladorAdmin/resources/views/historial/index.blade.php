@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Historial</li>
@endsection

@section('name')
    Hstorial
@endsection

@section('header')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('historial.general') }}" class="nav-link"><b>Informe general</b> </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a onclick="window.print();" class="nav-link"><b>Imprimir</b> </a>
    </li>
@endsection


@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Historial</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table_admin" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre Completo</th>
                                        <th>Dificultad</th>
                                        {{-- <th>Puntaje</th> --}}
                                        <th>Fecha de simulacion</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $key => $room)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $room->user->name }}</td>
                                            <td>{{ ($room->room_setting_id == 1 ? 'Basico':
                                                   ($room->room_setting_id == 2 ? 'Medio':
                                                   ($room->room_setting_id == 3 ? 'Moderado': 'Personalizado' ))) }}</td>
                                            {{-- <td>{{ $admin->email }}</td> --}}
                                            <td>{{ $room->created_at }}</td>
                                            <td><a class="btn btn-warning" href="{{ route('historial.ver', $room->id) }}"><i class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{route('usuario.create')}}" class="btn btn-sm btn-secondary float-right mt-3">Nuevo administrador</a>
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
