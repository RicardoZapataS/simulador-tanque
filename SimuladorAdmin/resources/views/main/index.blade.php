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
                <form action="{{ route('startRoom') }}" method="POST" class="row" id="startRoom">
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
                                <select name="roomSettings_id" id="roomSettinf_id" class="form-control">
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
                </form>
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
                <form action="{{ route('startRoom') }}" method="POST" class="row" id="startRoom">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Color del tanque objetivo:</label>
                            <input name="tankColor" id="tankColor" value="#FFFFFF" type="text"
                                class="form-control startRoom my-colorpicker1">
                        </div>
                        <!-- /.form group -->

                        <div class="form-group">
                            <label>Tamaño del tanque objetivo:</label>
                            <div class="input-group mb-3">
                                <input name="tankSize" id="tankSize" type="number" class="form-control startRoom" value="4">
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <br>
                        <div class="form-check">
                            <input name="isRandomPositions" type="checkbox" class="form-check-input startRoom" id="isRandomPositions">
                            <label class="form-check-label" for="exampleCheck1">¿Posicionar aleatoriamente?</label>
                        </div>

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cantidad de granadas:</label>
                            <div class="input-group mb-3">
                                <input name="ammountBullet" id="ammountBullet" type="number" class="form-control startRoom" value="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">granadas</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <div class="form-group">
                            <label>Distancia de objetivos:</label>
                            <div class="input-group mb-3">
                                <input name="targetDistance" id="targetDistance" type="number" class="form-control startRoom" value="1000">
                                <div class="input-group-append">
                                    <span class="input-group-text">mts</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.form group -->

                        <div class="form-group">
                            <label>Tiempó limite:</label>
                            <div class="input-group mb-3">
                                <input name="TimeSimulator" id="TimeSimulator" type="text" class="form-control startRoom" value="00:00">
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
                <a onclick="document.getElementById('startRoom').submit();"
                    class="btn btn-sm btn-secondary float-right">Iniciar simulacion</a>
            </div>
        </div>
        <!-- /.card -->
        <button onclick="disableform('startRoom');">Cerrar</button>
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
            console.log(f);
            for (var i = 0; i < f.length; i++) {
                f[i].disabled = true
                console.log(f[i]);
            }
            var f = document.getElementsByClassName('startRoom');
            for (var i = 0; i < f.length; i++)
                f[i].disabled = true
        }

        function enableform(formId) {
            var f = document.forms[formId].getElementsByTagName('input');
            for (var i = 0; i < f.length; i++)
                f[i].disabled = false
            var f = document.forms[0].getElementsByTagName('textarea');
            for (var i = 0; i < f.length; i++)
                f[i].disabled = false
        }
        $('#roomSettinf_id').on('change', function() {
            console.log( this.value );
            getRoomSetting(this.value)
        });

        function getRoomSetting(id) {
            $.post("http://localhost:8000/api/getRoomSetting/" + id, {
                },
                function(data, status) {
                    fillRoomForm(data);
                });
        }
        //         TimeSimulator: "01:00"
        // ammountBullet: 1
        // created_at: null
        // id: 3
        // isRandomPosition: 1
        // tankColor: "#FFFFFF"
        // tankSize: 4
        // targetDistance: 1500


        function fillRoomForm(data) {

        }
    </script>

@endsection

@section('css')
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
@endsection
