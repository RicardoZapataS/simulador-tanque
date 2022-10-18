@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('historial') }}">Historial</a> </li>
    <li class="breadcrumb-item active">Historial</li>
@endsection

@section('name')
    Informe general
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
                            <h3 class="card-title">Informe general</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table_admin" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre Completo</th>
                                        <th>Nota Basico</th>
                                        <th>Nota Medio</th>
                                        <th>Nota Avanzado</th>
                                        <th>Promedio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notas as $key => $nota)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $nota['nombre'] }}</td>
                                            <td>{{ $nota['n_basico'] }}</td>
                                            <td>{{ $nota['n_medio'] }}</td>
                                            <td>{{ $nota['n_avanzado'] }}</td>
                                            <td>{{ $nota['n_promedio'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
