@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('historial') }}">Historial</a></li>
    <li class="breadcrumb-item active">Ver Personal</li>
@endsection


@section('name')
Ver Personal
@endsection

@section('content')
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



@endsection

@section('js')
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

@endsection

@section('css')
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
@endsection
