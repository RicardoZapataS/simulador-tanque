<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulador SK-105</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dist/css/adminlte.min.css') }}">

    <style>
        /* #203C64 */
        .sidebar,
        .brand-link {
            background-color: #203C64 !important;
        }

        .main-header {
            background-color: #ffffff;
        }

        .card-header {
            /* background-color: #cedbee; */
            background-color: #34495ef0;

            /* background-color: #d7e5f8; */
        }

        .card-body {
            /* background-color: #aac0df; */
            background-color: #e4eaf1;
            border: #34495ef0 1px solid;
        }

        h3.card-title {
            color: #FFFFFF;
        }

    </style>

    <style>
        .loader-contain {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            z-index: 1000;
            opacity: .5;
        }

        .loader-contain .content {
            height: 100vh;
            width: 100vw;
            background-image: radial-gradient(circle farthest-corner at center, #3C4B57 0%, #1C262B 100%);
        }

        .loader {
            position: absolute;
            top: calc(50%);
            left: calc(50% + 5rem);
            width: 64px;
            height: 64px;
            border-radius: 50%;
            perspective: 800px;
        }
        .hide{
            display: none;
        }
        .inner {
            position: absolute;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .inner.one {
            left: 0%;
            top: 0%;
            animation: rotate-one 1s linear infinite;
            border-bottom: 3px solid #EFEFFA;
        }

        .inner.two {
            right: 0%;
            top: 0%;
            animation: rotate-two 1s linear infinite;
            border-right: 3px solid #EFEFFA;
        }

        .inner.three {
            right: 0%;
            bottom: 0%;
            animation: rotate-three 1s linear infinite;
            border-top: 3px solid #EFEFFA;
        }

        @keyframes rotate-one {
            0% {
                transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
            }

            100% {
                transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
            }
        }

        @keyframes rotate-two {
            0% {
                transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
            }

            100% {
                transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
            }
        }

        @keyframes rotate-three {
            0% {
                transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
            }

            100% {
                transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
            }
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('assets/img/logo-emi.png') }}" alt="Simulador SK-105"
             height="100" width="100">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                        class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="nav-link"><b>Inicio</b> </a>
            </li>
            @yield('header')
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{ asset('assets/img/logo-emi.png') }}" alt="Simulador SK-105"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Simulador SK-105</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('assets/plugins/dist/img/user2-160x160.jpg') }}"
                         class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>
            <div class=""
                 style="display: flex; flex-direction: column; height: calc(100% - 5.5rem); justify-content: space-between;">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{route('index')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('historial')}}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Historial
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('usuario.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Usuarios
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="pages/gallery.html" class="nav-link">
                                <i class="nav-icon fas fa-toolbox"></i>
                                <p>
                                    Parametros
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Cerrar sesion
                                </p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  class="d-none">
                                @csrf
                            </form>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>

        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('name')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('route')
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
                <div class="loader-contain hide" id="loader-contain">
                    <div class="content">
                        <div class="loader">
                            <div class="inner one"></div>
                            <div class="inner two"></div>
                            <div class="inner three"></div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Puntaje </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row" >

                                <canvas id="myChart" width="400" height="400"style="max-height: 70vh"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @foreach($rooms as $room)
                        <!-- SELECT2 EXAMPLE -->
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Datos / {{ $room->room_setting_id == 1 ? 'Basico' : ($room->room_setting_id == 2 ? 'Medio' : ($room->room_setting_id == 3 ? 'Avanzado' : ('P'.date('d-m-Y', strtotime($room->created_at))))) }} </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanquista:</label>
                                        </div>
                                        <!-- /.form group -->

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group mb-3">
                                                <input name="roomSettings_id " disabled value="{{$room->user->name}}"
                                                       class="form-control ">
                                            </div>
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.col -->
                                    <hr  style="width: 98%;height:2px;border-width:0;color:gray;background-color:gray; opacity: .5;">
                                </div>
                                <!-- /.row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Color del tanque objetivo:</label>
                                            <div class="cont">
                                                <input name="tankColor" id="tankColor" disabled value="{{ $room->room_setting->tankColor }}"
                                                       type="text" class="form-control startRoom my-colorpicker1">
                                                <div class="color-change" id="color-change"><input class="child" type="text">
                                                </div>
                                                <style>
                                                    .form-control.startRoom.my-colorpicker1 {

                                                        border-top-right-radius: 0;
                                                        border-bottom-right-radius: 0;
                                                    }

                                                    .color-change {
                                                        background-color: {{ $room->room_setting->tankColor }};
                                                        display: block;
                                                        height: calc(2.25rem + 2px);
                                                        width: calc(2.25rem + 2px);
                                                        border-radius: .25rem;
                                                        border-top-left-radius: 0;
                                                        border-bottom-left-radius: 0;
                                                    }

                                                    .color-change .child {
                                                        opacity: 0;
                                                    }

                                                    .cont {
                                                        display: flex;
                                                        align-items: center
                                                    }

                                                </style>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <div class="form-group">
                                            <label>Tamaño del tanque objetivo:</label>
                                            <div class="input-group mb-3">
                                                <input name="tankSize" id="tankSize" type="number" disabled class="form-control startRoom"
                                                       value="{{ $room->room_setting->tankSize }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">x</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <br>
                                        <div class="form-check">
                                            <input name="isRandomPositions" type="checkbox" disabled
                                                   @if ($room->room_setting->isRandomPosition == 1) checked @endif class="form-check-input startRoom"
                                                   id="isRandomPositions">
                                            <label class="form-check-label" for="exampleCheck1">¿Posicionar aleatoriamente?</label>
                                        </div>

                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cantidad de granadas:</label>
                                            <div class="input-group mb-3">
                                                <input name="ammountBullet" id="ammountBullet" type="number" class="form-control startRoom"
                                                       disabled value="{{ $room->room_setting->ammountBullet }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">granadas</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <div class="form-group">
                                            <label>Distancia de objetivos:</label>
                                            <div class="input-group mb-3">
                                                <input name="targetDistance" id="targetDistance" type="number"
                                                       class="form-control startRoom" disabled value="{{ $room->room_setting->targetDistance }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">mts</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <div class="form-group">
                                            <label>Tiempó limite:</label>
                                            <div class="input-group mb-3">
                                                <input name="TimeSimulator" disabled id="TimeSimulator" type="text"
                                                       class="form-control startRoom" value="{{ $room->room_setting->TimeSimulator }}">
                                            </div>
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->


                                <div class="d-flex flex-wrap" id="shootings_cards">
                                    @foreach($room->room_shootings as $room_shooting)
                                        <div class="col-6" id="shooting-{{$room_shooting->id}}">
                                            <div class="card mx-1">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <img class="card-img" src="{{$room_shooting->tag}}" alt="target">
                                                    </div>
                                                    <div class="col-sm-7">
                                                        <div class="d-flex flex-column justify-content-center m-0 h-100">
                                                            <h1 class="card-title"> <b>Impacto a objetivo: </b> @if($room_shooting->target != -1) {{$room_shooting->tar}} @else Fallo @endif </h1><br>
                                                            <h1 class="card-title"> <b>Zona de impacto: </b> @if($room_shooting->site_shooting != -1) {{$room_shooting->tag_name}} @else Fallo @endif </h1><br>
                                                            <h1 class="card-title"> <b>Tiempo de disparo: </b> {{$room_shooting->time}} segundos</h1><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    @endforeach
                </div>




        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/plugins/dist/js/adminlte.js') }}"></script>

<!-- ChartJS -->
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/plugins/dist/js/pages/dashboard2.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<canvas id="myChart" width="200" height="200"></canvas>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Precision', 'Oruga', 'Cañon',  'Batea','Cabina', 'Reaccion'],
            datasets: [
                    @foreach($points as $point)
                {
                    label: "{{ $point['name'] }}",
                    data: [{{$point["precision"]}}, {{$point["oruga"]}}, {{$point["cañon"]}}, {{$point["batea"]}}, {{$point["cabina"]}}, {{$point["reaccion"]}} ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 3
                },
                @endforeach
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>

</html>



