@extends('layouts.adminlte')

@section('route')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Parametros</li>
@endsection

@section('name')
    Parametros
@endsection

@section('content')
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Dificultad</h3>

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
                <div class="row">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nivel de dificultad:</label>
                        </div>
                        <!-- /.form group -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <select name="roomSettings_id " data-live-search="true" id="roomSettinf_id"
                                    class="form-control selectpicker">
                                    @foreach ($defaultSettings as $defaultSetting)
                                        <option value="{{ $defaultSetting->room_setting_id }}">
                                            {{ $defaultSetting->name }}
                                        </option>
                                    @endforeach
                                    <option value="-1">Personalizado</option>
                                </select>
                            </div>
                        </div>
                        <!-- /.form group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
                                <select data-live-search="true" id="frm_user_id"
                                    class="form-control">
                                    <option value="-1">Seleccione un tanquista</option>
                                    @foreach ($tanquistas as $tanquista)
                                        <option value="{{ $tanquista->id }}">
                                            {{ $tanquista->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.form group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Configuracion</h3>

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
                <form action="{{ route('startSimulator') }}" method="POST" class="row" id="startRoom">
                    @csrf
                    <input type="hidden" id="ss_room_setting" name="ss_room_setting" value="1">
                    <input type="hidden" id="ss_user_id" name="ss_user_id" value="-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Color del tanque objetivo:</label>
                            <div class="cont">
                                <input name="tankColor" id="tankColor" value="#FF0000" type="text" class="form-control startRoom my-colorpicker1">
                                <div class="color-change" id="color-change"><input class="child" type="text">
                                </div>
                                <style>
                                    .form-control.startRoom.my-colorpicker1 {

                                        border-top-right-radius: 0;
                                        border-bottom-right-radius: 0;
                                    }

                                    .color-change {
                                        background-color: #FF0000;
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
                                <input name="tankSize" id="tankSize" type="number" class="form-control startRoom" value="8">
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <br>
                        <div class="form-check">
                            <input name="isRandomPositions" type="checkbox" class="form-check-input startRoom"
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
                                    value="3">
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
                                    class="form-control startRoom" value="1000">
                                <div class="input-group-append">
                                    <span class="input-group-text">mts</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <div class="form-group">
                            <label>Tiempó limite:</label>
                            <div class="input-group mb-3">
                                <input name="TimeSimulator" id="TimeSimulator" type="text" class="form-control startRoom"
                                    value="00:00">
                            </div>
                        </div>
                        <!-- /.form group -->
                    </div>
                    <!-- /.col -->
                </form>
                <!-- /.row -->

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{route('simulator')}}" class="btn btn-sm btn-secondary float-left">Continuar simulacion</a>
                <a onclick="sendForm()" class="btn btn-sm btn-secondary float-right">Iniciar simulacion</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection


@section('js')
    <!-- bootstrap color picker -->
    <script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

    <script>
        //Colorpicker
        $('.my-colorpicker1').colorpicker()
    </script>

    <script type="text/javascript">
        function disableform(formId) {
            var f = document.getElementsByClassName('startRoom');
            //console.log(f);
            for (var i = 0; i < f.length; i++) {
                f[i].disabled = true;
            }
            console.log("disableForm")
        }

        function enableform(formId) {
            var f = document.getElementsByClassName('startRoom');
            // console.log(f);
            for (var i = 0; i < f.length; i++)
                f[i].disabled = false
            console.log("enableForm")
        }

        $('#roomSettinf_id').on('change', function() {
            console.log(this.value);
            document.getElementById("ss_room_setting").setAttribute('value', this.value);
            if (this.value == -1)
                enableform('startRoom');
            else {
                disableform('startRoom');
                getRoomSetting(this.value);
            }
        });
        $('#frm_user_id').on('change', function() {
            console.log(this.value);
            $("#users_errors" ).html("");
            document.getElementById("ss_user_id").setAttribute('value', this.value);
        });

        $('#tankColor').on('change', function() {
            // console.log( this.value );
            $("#color-change").css("background-color", this.value);
        });

        function getRoomSetting(id) {
            $.post("http://localhost:8000/api/getRoomSetting/" + id, {},
                function(data, status) {
                    // console.log(data)
                    fillRoomForm(data);
                });
        }

        function fillRoomForm(data) {
            // enableform('startRoom');
            console.log(data.tankColor)
            document.getElementById("TimeSimulator").setAttribute('value', parseInt(data.TimeSimulator));
            document.getElementById("ammountBullet").setAttribute('value', parseInt(data.ammountBullet));
            // document.getElementById("isRandomPosition").setAttribute('value', data.isRandomPosition));
            $("#color-change").css("background-color", data.tankColor);
            $("#tankColor").val(data.tankColor);
            document.getElementById("tankSize").setAttribute('value', parseInt(data.tankSize));
            document.getElementById("targetDistance").setAttribute('value', parseInt(data.targetDistance));

            // $('#ammountBullet').val = 2;
        }
        $(document).ready(function() {
            disableform('startRoom');
        });

        function sendForm() {
            if($('#frm_user_id').val() == -1){
                $( "#users_errors" ).html( '<div class="alert alert-danger" role="alert">Debe seleccionar un tanquista </div>' );
            }else{
                event.preventDefault();
                enableform('startRoom');
                document.getElementById('startRoom').submit();
            }
        }
    </script>
@endsection

@section('css')
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
@endsection
