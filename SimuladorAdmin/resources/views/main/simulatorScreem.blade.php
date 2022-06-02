@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/">Configuracion de sala</a></li>
    <li class="breadcrumb-item active">Sala de Simulacion</li>
@endsection

@section('name')
Sala de Simulacion
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
                <h3 class="card-title">Configuracion / Dificutad - {{ $defaultSettings }}</h3>
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
                                <input name="roomSettings_id " disabled value="{{$user->name}}"
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
                                <input name="tankColor" id="tankColor" disabled value="{{ $room_setting->tankColor }}"
                                    type="text" class="form-control startRoom my-colorpicker1">
                                <div class="color-change" id="color-change"><input class="child" type="text">
                                </div>
                                <style>
                                    .form-control.startRoom.my-colorpicker1 {

                                        border-top-right-radius: 0;
                                        border-bottom-right-radius: 0;
                                    }

                                    .color-change {
                                        background-color: {{ $room_setting->tankColor }};
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
                                    value="{{ $room_setting->tankSize }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <br>
                        <div class="form-check">
                            <input name="isRandomPositions" type="checkbox" disabled
                                @if ($room_setting->isRandomPosition == 1) checked @endif class="form-check-input startRoom"
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
                                    disabled value="{{ $room_setting->ammountBullet }}">
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
                                    class="form-control startRoom" disabled value="{{ $room_setting->targetDistance }}">
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
                                    class="form-control startRoom" value="{{ $room_setting->TimeSimulator }}">
                            </div>
                        </div>
                        <!-- /.form group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a id="sendForm" class="btn btn-sm btn-secondary float-right">Pausar simulacion</a>
            </div>
        </div>
        <!-- /.card -->
    </div>



@endsection

@section('js')
    <script>
        $(function() {
            $("#sendForm").click(function() {
                var dataString = '';
                //alert (dataString);return false;
                $.ajax({
                    type: "GET",
                    url: "{{route('api.pause')}}",
                    data: dataString,
                    success: function() {
                        $('#loader-contain').removeClass( "hide" )
                        confirm();
                    }
                });
                return false;
            });
            function confirm() {
                $.get("{{route('api.state')}}", {},
                function(data, status) {
                    // console.log(data)
                    if(data.value == 4 || data.value == 1)
                        $('#loader-contain').addClass( "hide" )
                    else
                        setTimeout(confirm, 1000);
                });
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
