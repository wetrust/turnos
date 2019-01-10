<div class="card">
    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-4">
                <div class="form-group m-0">
                    <label for="departamentos.header">Elegir departamento o unidad</label>
                    <select id="departamentos.header" class="form-control"></select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group m-0">
                    <label for="fecha.mes">Mes</label>
                    <select id="fecha.mes" class="form-control">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group m-0">
                    <label for="fecha.ano">Año</label>
                    <select id="fecha.ano" class="form-control">
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2019">2020</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<
<div class="row">
    <div class="col mt-2">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-td table-hover table-bordered" id="table">
                            <thead>
                                <tr class="bg-light">
                                    <th scope="col" rowspan="2" class="text-center" style="font-size:1.2rem">Días / Fecha</th>
                                    <th scope="col" rowspan="2" class="text-center" style="font-size:1.2rem">Turnos<br>programados</th>
                                    <th scope="col" colspan="2" class="text-center" style="font-size:1.2rem">Turno realizados</th>
                                    <th scope="col" rowspan="2" class="text-center" style="font-size:1.2rem">Comentarios</th>
                                </tr>
                                <tr class="bg-light">
                                    <th scope="col" class="text-center" style="font-size:1.2rem">Diurno</th>
                                    <th scope="col" class="text-center" style="font-size:1.2rem">Nocturno</th>
                                </tr>
                            </thead>
                            <tbody id="table.calendario">
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="dialog.view">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="dialog.title"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body" id="dialog.body">
               </div>
               <div class="modal-footer" id="dialog.footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
               </div>
            </div>
         </div>
      </div>
      <style>
            body{
                -webkit-touch-callout: none;                /* prevent callout to copy image, etc when tap to hold */
                -webkit-text-size-adjust: none;             /* prevent webkit from resizing text to fit */
                -webkit-user-select: none;                  /* prevent copy paste, to allow, change 'none' to 'text' */
            }
          .table-td tbody td:hover{
              background-color:rgba(0,0,0,.075);
          }
      </style>
        <script>
            var JEFEA = "";
            $(document).ready(function() {

            let now = new Date();
            let month = ("0" + (now.getMonth() + 1)).slice(-2);
            
            $("#fecha\\.mes").val(month);
            $("#fecha\\.mes").on("change", function(){
                makeCalendario();
            });

            $("#fecha\\.ano").val(now.getFullYear());
            $("#fecha\\.ano").on("change", function(){
                makeCalendario();
            });
            $("#departamentos\\.header").on("change", function(){
                makeCalendario();
                let datos = {
                    accion: "departamento",
                    departamento_id: $("#departamentos\\.header option:selected").val()
                }

                $.post("turnos/api", datos).done(function(response){
                    JEFEA = response.user_nombre;
                });
            });

            let data = {
                accion : "departamentos",
            }

            $.post("turnos/api", data).done(function(response){
                $("#departamentos\\.header").empty();

                if (Object.keys(data).length > 0) {
                    $.each(response, function(i, item) {
                        let option = '<option value="' + item.departamento_id + '">' + item.departamento_name + '</option>';
                        $("#departamentos\\.header").append(option);
                    });
                    $("#departamentos\\.header").trigger("change");
                }
            });

            <?php if (Session::get("user_account_type") < 3) : ?>
                $("#boton\\.listado\\.profesionales").on("click", function(){
                    let filtrar = $("#departamentos\\.header option:selected").val();
                    let data = "";
                    if (filtrar == "null"){
                        data = {
                            accion : "profesionalesDepartamento",
                        }
                    }
                    else{
                        data = {
                            accion : "profesionalesFiltrados",
                            departamento_id: filtrar
                        }
                    }

                    $.post("turnos/api", data).done(function(response){
                        $("#dialog\\.title").html("Profesionales en el departamento o unidad");
                        $("#dialog\\.body").html('<button type="button" class="btn btn-outline-primary" id="boton.turnos.imprimir">Imprimir</button><table class="table" id="tabla.listado.profesionales"><thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Departamento</th><th scope="col">Nombre profesional</th><th scope="col">Telefono</th><th scope="col">Correo</th></tr></thead><tbody id="usuarios.tabla"></tbody></table>');
                        $("#dialog\\.view").modal("show");
                        if (Object.keys(data).length > 0) {
                            $.each(response, function(i, item) {
                                let fila = '<tr><td data-id="'+item.user_id+'">' + item.user_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>' + item.user_telefono + '</td><td>' + item.user_email + '</td></tr>';
                                $("#usuarios\\.tabla").append(fila);
                            });
                        }

                        $("#boton\\.turnos\\.imprimir").on("click", function(){
                            var documento =  '<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="user-scalable=no,maximum-scale=1, minimum-scale=1, width=device-width, initial-scale=1, shrink-to-fit=no"><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"><link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous"><title>Turnos</title></head><body><h3 class="text-center">Profesionales en departamento: :DEPARTAMENTO</h3><p>&nbsp;</p>:TABLA</body><script>document.addEventListener("DOMContentLoaded",function(event){var ventimp=window; ventimp.print();ventimp.close();});<\/script></html>';
                            documento = documento.replace(':DEPARTAMENTO', $("#departamentos\\.header option:selected").text());
                            var element = document.getElementById("tabla.listado.profesionales");
                            var calendario = element.outerHTML;
                            documento = documento.replace(':TABLA', calendario);
                            var ventimp = window.open(' ', 'popimpr');
                            ventimp.document.write(documento);
                            ventimp.document.close();
                        });
                    });
                });
            <?php endif; ?>

            <?php if (Session::get("user_account_type") == 6) : ?>
            $("#boton\\.turno").on("click", function(){
                $("#dialog\\.title").html("INGRESAR DATOS<br>(Departamento, fecha de turno, horario y profesional asignado)");
                $("#dialog\\.body").html('<div class="row"> <div class="form-group col-6"><label for="turnos.departamento">Departamento</label><input class="form-control" type="text" id="turnos.departamento" disabled></div><div class="form-group col-6"><label for="turnos.fecha.in">Fecha de turno</label><input class="form-control" type="date" id="turnos.fecha.in"></div><div class="form-group col-6"> <label for="turnos.hora.in">Horario de turno (12 o 24 hrs)</label> <select class="form-control" id="turnos.turno"> <option value="0">Diurno</option> <option value="1">Nocturno</option> <option value="2">Completo</option> </select> </div><div class="form-group col-6"><label for="turnos.profesionales">Profesional asignado</label><select class="form-control" id="turnos.profesionales"></select></div></div>');
                $("#dialog\\.view").modal("show");

                $("#turnos\\.departamento").val($("#departamentos\\.header option:selected").text());

                let data = {
                    accion : "profesionalesFiltrados",
                    departamento_id: $("#departamentos\\.header option:selected").val()
                }

                $.post("turnos/api", data).done(function(response){
                    $("#turnos\\.profesionales").empty();
                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                            $("#turnos\\.profesionales").append(option);
                        });
                    }
                });

                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    let datos = {
                        accion: "turnosNuevo",
                        profesional: $("#turnos\\.profesionales").val(),
                        profesional_nombre: $("#turnos\\.profesionales option:selected").text(), 
                        fechainic: $("#turnos\\.fecha\\.in").val(),
                        turno: $("#turnos\\.turno").val(),
                        departamento_id: $("#departamentos\\.header option:selected").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        if (response.resultado == false){
                            $("#dialog\\.title").html("Error");
                            $("#dialog\\.body").html('<p class="text-center">No puede asignar un médico a un turno ya ocupado, si desea cambiar, debe hacer click sobre el turno.</p>');
                            $("#dialog\\.delete").remove();
                        }
                        else{
                            $("#dialog\\.view").modal("hide");
                            makeCalendario();
                        }
                    });
                });
            });

            $("#boton\\.default").on("click", function(){
                $("#dialog\\.title").html("INGRESAR PROFESIONAL PREDETERMINADO<br>(Departamento, fecha de turno y profesional asignado)");
                $("#dialog\\.body").html('<div class="row"> <div class="form-group col-6"><label for="turnos.departamento">Departamento</label><input class="form-control" type="text" id="turnos.departamento" disabled></div><div class="form-group col-6"><label for="turnos.fecha.in">Fecha de turno</label><input class="form-control" type="date" id="turnos.fecha.in"></div><div class="form-group col-6"><label for="turnos.profesionales">Profesional asignado</label><select class="form-control" id="turnos.profesionales"></select></div></div>');
                $("#dialog\\.view").modal("show");

                $("#turnos\\.departamento").val($("#departamentos\\.header option:selected").text());

                let data = {
                    accion : "profesionalesFiltrados",
                    departamento_id: $("#departamentos\\.header option:selected").val()
                }

                $.post("turnos/api", data).done(function(response){
                    $("#turnos\\.profesionales").empty();
                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                            $("#turnos\\.profesionales").append(option);
                        });
                    }
                });

                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    let datos = {
                        accion: "defaultNuevo",
                        profesional: $("#turnos\\.profesionales").val(),
                        default_fecha: $("#turnos\\.fecha\\.in").val(),
                        departamento_id: $("#departamentos\\.header option:selected").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        if (response.resultado == false){
                            $("#dialog\\.title").html("Error");
                            $("#dialog\\.body").html('<p class="text-center">No puede asignar un médico a un turno ya ocupado, si desea cambiar, debe hacer click sobre el turno.</p>');
                            $("#dialog\\.delete").remove();
                        }
                        else{
                            $("#dialog\\.view").modal("hide");
                            makeCalendario();
                        }
                    });
                });
            });

            $("#boton\\.configuracion").on("click", function(){
                $("#dialog\\.title").html("Configuración");
                $("#dialog\\.body").html('<ul class="nav nav-tabs" id="configuracionOption" role="tablist"><li class="nav-item"><a class="nav-link active show" data-toggle="tab" role="tab" aria-selected="false" id="departamento-tab" aria-controls="departamento" href="#a">Unidad o Departamento</a></li><li class="nav-item"><a class="nav-link" data-toggle="tab" role="tab" aria-selected="true" id="usuarios-tab" aria-controls="usuarios" href="#b">Listado de profesionales</a></li></ul><div class="tab-content" id="configuracionTab"><div class="tab-pane fade active show" role="tabpanel" aria-labelledby="departamento-tab" id="a"><div role="group" aria-label="Botones" class="btn-group my-3"><button type="button" class="btn btn-outline-primary" id="departamento.formulario.nuevo">Nuevo departamento</button><button type="button" class="btn btn-outline-primary d-none" id="departamento.formulario.guardar">Guardar</button><button type="button" class="btn btn-outline-secondary d-none" id="departamento.formulario.cancelar">Cancelar</button></div><div class="row"><div class="col-12 d-none" id="departamento.formulario"><div class="card my-2 border border-primary"><div class="card-body"><h5 class="card-title text-right"><strong>Nuevo Departamento</strong></h5><div class="form-group"><label for="departamento.formulario.texto"><strong>1.- Nombre del departamento</strong></label><input class="form-control" type="text" id="departamento.formulario.texto"></div><div class="form-group"><label for="departamento.formulario.jefe"><strong>2.- Jefe de departamento</strong></label><select class="form-control" id="departamento.formulario.jefe"></select><input type="hidden" id="departamento.formulario.departamento.id"/></div></div></div></div><div class="col-12" id="departamento.formulario.tabla.contenedor"><table class="table"><thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Nombre del departamento</th><th scope="col">Jefe de unidad</th><th scope="col">N° Integrantes</th><th scope="col">acciones</th></tr></thead><tbody id="departamentos.tabla"></tbody></table></div></div></div><div class="tab-pane fade" role="tabpanel" aria-labelledby="usuarios-tab" id="b"><div role="group" aria-label="Botones" class="btn-group my-3"><button type="button" class="btn btn-outline-primary" id="usuarios.formulario.nuevo">Asignar usuario a un departamento</button></div><div class="row"><div class="col-12 d-none" id="usuarios.formulario"><div class="card my-2 border border-primary"><div class="card-body"><h5 class="card-title text-right"><strong>Usuario a Departamento</strong></h5><div class="form-group"><label for="usuario.formulario.usuario"><strong>1.- Seleccione Profesional</strong></label><select class="form-control" id="usuario.formulario.usuario"></select></div><div class="form-group"><label for="usuario.formulario.departamento"><strong>2.- Seleccione Departamento</strong></label><select class="form-control" id="usuario.formulario.departamento"></select></div><div role="group" aria-label="Botones" class="btn-group my-3"><button type="button" class="btn btn-outline-danger d-none" id="usuarios.formulario.guardar">Guardar</button><button type="button" class="btn btn-outline-secondary d-none" id="usuarios.formulario.cancelar">Cancelar</button></div></div></div></div><div class="col-12" id="usuario.departamento.filtrar.contenedor"><div class="form-group"><label for="usuario.departamento.filtrar">Departamento</label><select class="form-control" id="usuario.departamento.filtrar"></select></div><table class="table"><thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Departamento</th><th scope="col">Nombre profesional</th><th scope="col">Telefono</th><th scope="col">Correo</th><th scope="col">acciones</th></tr></thead><tbody id="usuarios.tabla"></tbody></table></div></div></div></div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();

                let data = {
                    accion : "departamentos",
                }

                $.post("turnos/api", data).done(function(response){
                    $("#departamentos\\.tabla").empty();
                    $("#usuario\\.formulario\\.departamento").empty();
                    $("#usuario\\.departamento\\.filtrar").empty();

                    let option = '<option value="null">Todos</option>';
                    $("#usuario\\.departamento\\.filtrar").append(option);

                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let fila = '<tr><td data-id="'+item.departamento_id+'">' + item.departamento_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>'+ item.user_cantidad+'</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-outline-secondary editar-departamento" data-id="' + item.departamento_id + '">Modificar</button><button type="button" class="btn btn-outline-secondary remover-departamento" data-id="'+ item.departamento_id +'"><i class="fas fa-trash"></i></button></div></td></tr>';
                            let option = '<option value="' + item.departamento_id + '">' + item.departamento_name + '</option>';
                            $("#departamentos\\.tabla").append(fila);
                            $("#usuario\\.formulario\\.departamento").append(option);
                            $("#usuario\\.departamento\\.filtrar").append(option);
                        });


                        $(".editar-departamento").on("click", function(){

                            let data = {
                                accion : "departamento",
                                departamento_id:$(this).data("id")
                            }

                            $.post("turnos/api", data).done(function(response){
                                $("#departamento\\.formulario\\.texto").val(response.departamento_name);
                                $("#departamento\\.formulario\\.jefe").val(response.departamento_jefe);
                                $("#departamento\\.formulario\\.departamento\\.id").val(response.departamento_id);
                            });

                            $("#departamento\\.formulario\\.nuevo").addClass("d-none");
                            $("#departamento\\.formulario\\.guardar").removeClass("d-none");
                            $("#departamento\\.formulario\\.cancelar").removeClass("d-none");
                            $("#departamento\\.formulario").removeClass("d-none");
                            $("#departamento\\.formulario\\.texto").val("");
                            $("#departamento\\.formulario\\.tabla\\.contenedor").addClass("d-none");
                        });
                        $(".remover-departamento").on("click", function(){
                            let departamento_id = $(this).data("id");

                            $("#dialog\\.title").html("Eliminar");
                            $("#dialog\\.body").html('<p>¿Está seguro de eliminar el departamento y todos sus integrantes?</p><div role="group" aria-label="Botones" class="btn-group my-3" data-id="'+departamento_id+'"><button type="button" class="btn btn-outline-primary" id="mensaje.si" data-id="'+ departamento_id +'">Si</button><button type="button" class="btn btn-outline-primary" id="mensaje.no">No</button>');
                            $("#dialog\\.view").modal("show");
                            $("#dialog\\.delete").remove();
                            
                            $("#mensaje\\.no").on("click", function(){
                                $("#boton\\.configuracion").trigger("click");
                            });

                            $("#mensaje\\.si").on("click", function(){
                                let data = {
                                    accion : "departamentosEliminar",
                                    departamento_id:$(this).data("id")
                                }

                                $.post("turnos/api", data).done(function(response){
                                    $("#boton\\.configuracion").trigger("click");
                                });
                            });
                        });
                    }
                });

                data = {
                    accion : "profesionalesDepartamento",
                }

                $.post("turnos/api", data).done(function(response){
                    $("#usuarios\\.tabla").empty();
                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let fila = '<tr><td data-id="'+item.user_id+'">' + item.user_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>' + item.user_telefono + '</td><td>' + item.user_email + '</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-outline-secondary editar-udep">Modificar</button><button type="button" class="btn btn-outline-secondary remover-udep"><i class="fas fa-trash"></i></button></div></td></tr>';
                            $("#usuarios\\.tabla").append(fila);
                        });

                        $(".editar-udep").on("click", function(){

                        });
                        $(".remover-udep").on("click", function(){

                        });
                    }
                });

                data = {
                    accion : "profesionales",
                }

                $.post("turnos/api", data).done(function(response){
                    $("#departamento\\.formulario\\.jefe").empty();
                    $("#usuario\\.formulario\\.usuario").empty();
                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                            $("#departamento\\.formulario\\.jefe").append(option);
                            $("#usuario\\.formulario\\.usuario").append(option);
                        });
                    }
                });

                $("#usuario\\.departamento\\.filtrar").on("click", function(){
                    let filtrar = $("#usuario\\.departamento\\.filtrar option:selected").val();
                    let data = "";
                    if (filtrar == "null"){
                        data = {
                            accion : "profesionalesDepartamento",
                        }
                    }
                    else{
                        data = {
                            accion : "profesionalesFiltrados",
                            departamento_id: filtrar
                        }
                    }


                    $.post("turnos/api", data).done(function(response){
                        $("#usuarios\\.tabla").empty();
                        if (Object.keys(data).length > 0) {
                            $.each(response, function(i, item) {
                                let fila = '<tr><td data-id="'+item.user_id+'">' + item.user_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>' + item.user_telefono + '</td><td>' + item.user_email + '</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-outline-secondary editar-udep">Modificar</button><button type="button" class="btn btn-outline-secondary remover-udep"><i class="fas fa-trash"></i></button></div></td></tr>';
                                $("#usuarios\\.tabla").append(fila);
                            });

                            $(".editar-udep").on("click", function(){

                            });
                            $(".remover-udep").on("click", function(){

                            });
                        }
                    });
                });

                $("#departamento\\.formulario\\.nuevo").on("click", function(){
                    $("#departamento\\.formulario\\.nuevo").addClass("d-none");
                    $("#departamento\\.formulario\\.guardar").removeClass("d-none");
                    $("#departamento\\.formulario\\.cancelar").removeClass("d-none");
                    $("#departamento\\.formulario").removeClass("d-none");
                    $("#departamento\\.formulario\\.texto").val("");
                    $("#departamento\\.formulario\\.tabla\\.contenedor").addClass("d-none");
                    $("#departamento\\.formulario\\.departamento\\.id").val("");
                });

                $("#departamento\\.formulario\\.guardar").on("click", function(){
                    let data = "";

                    if ($("#departamento\\.formulario\\.departamento\\.id").val() == ""){
                        data = {
                            accion : "departamentosNuevo",
                            departamento_name: $("#departamento\\.formulario\\.texto").val(),
                            departamento_jefe: $("#departamento\\.formulario\\.jefe option:selected").val(),
                        }
                    }
                    else{
                        data = {
                            accion : "departamentosUpdate",
                            departamento_name: $("#departamento\\.formulario\\.texto").val(),
                            departamento_jefe: $("#departamento\\.formulario\\.jefe option:selected").val(),
                            departamento_id: $("#departamento\\.formulario\\.departamento\\.id").val()
                        }
                    }

                    
                    $.post("turnos/api", data).done(function(response){
                        let data = {
                            accion : "departamentos"
                        }

                        $.post("turnos/api", data).done(function(response){
                            $("#departamentos\\.tabla").empty();
                            $("#usuario\\.formulario\\.departamento").empty();
                            $("#usuario\\.departamento\\.filtrar").empty();

                            let option = '<option value="null">Todos</option>';
                            $("#usuario\\.departamento\\.filtrar").append(option);

                            if (Object.keys(data).length > 0) {
                                $.each(response, function(i, item) {
                                    let fila = '<tr><td data-id="'+item.departamento_id+'">' + item.departamento_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>'+ item.user_cantidad+'</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-outline-secondary editar-departamento" data-id="' + item.departamento_id + '">Modificar</button><button type="button" class="btn btn-outline-secondary remover-departamento" data-id="'+ item.departamento_id +'"><i class="fas fa-trash"></i></button></div></td></tr>';
                                    let option = '<option value="' + item.departamento_id + '">' + item.departamento_name + '</option>';
                                    $("#departamentos\\.tabla").append(fila);
                                    $("#usuario\\.formulario\\.departamento").append(option);
                                    $("#usuario\\.departamento\\.filtrar").append(option);
                                });

                                $(".remover-departamento").on("click", function(){
                                    let departamento_id = $(this).data("id");

                                    $("#dialog\\.title").html("Eliminar");
                                    $("#dialog\\.body").html('<p>¿Está seguro de eliminar el departamento y todos sus integrantes?</p><div role="group" aria-label="Botones" class="btn-group my-3" data-id="'+departamento_id+'"><button type="button" class="btn btn-outline-primary" id="mensaje.si" data-id="'+ departamento_id +'">Si</button><button type="button" class="btn btn-outline-primary" id="mensaje.no">No</button>');
                                    $("#dialog\\.view").modal("show");
                                    $("#dialog\\.delete").remove();
                                    
                                    $("#mensaje\\.no").on("click", function(){
                                        $("#boton\\.configuracion").trigger("click");
                                    });

                                    $("#mensaje\\.si").on("click", function(){
                                        let data = {
                                            accion : "departamentosEliminar",
                                            departamento_id:$(this).data("id")
                                        }

                                        $.post("turnos/api", data).done(function(response){
                                            $("#boton\\.configuracion").trigger("click");
                                        });
                                    });
                                });
                            }
                        });
                    });

                    $("#departamento\\.formulario\\.nuevo").removeClass("d-none");
                    $("#departamento\\.formulario\\.guardar").addClass("d-none");
                    $("#departamento\\.formulario\\.cancelar").addClass("d-none");
                    $("#departamento\\.formulario").addClass("d-none");
                    $("#departamento\\.formulario\\.texto").val("");
                    $("#departamento\\.formulario\\.tabla\\.contenedor").removeClass("d-none");
                });

                $("#departamento\\.formulario\\.cancelar").on("click", function(){
                    $("#departamento\\.formulario\\.nuevo").removeClass("d-none");
                    $("#departamento\\.formulario\\.guardar").addClass("d-none");
                    $("#departamento\\.formulario\\.cancelar").addClass("d-none");
                    $("#departamento\\.formulario").addClass("d-none");
                    $("#departamento\\.formulario\\.texto").val("");
                    $("#departamento\\.formulario\\.departamento\\.id").val("");
                    $("#departamento\\.formulario\\.tabla\\.contenedor").removeClass("d-none");
                });

                $("#usuarios\\.formulario\\.nuevo").on("click", function(){
                    $("#usuarios\\.formulario\\.nuevo").addClass("d-none");
                    $("#usuarios\\.formulario\\.guardar").removeClass("d-none");
                    $("#usuarios\\.formulario\\.cancelar").removeClass("d-none");
                    $("#usuarios\\.formulario").removeClass("d-none");
                    $("#usuario\\.departamento\\.filtrar\\.contenedor").addClass("d-none");
                });

                $("#usuarios\\.formulario\\.guardar").on("click", function(){
                    $("#usuarios\\.formulario\\.nuevo").removeClass("d-none");
                    $("#usuarios\\.formulario\\.guardar").addClass("d-none");
                    $("#usuarios\\.formulario\\.cancelar").addClass("d-none");
                    $("#usuarios\\.formulario").addClass("d-none");
                    $("#usuario\\.departamento\\.filtrar\\.contenedor").removeClass("d-none");

                    let data = {
                        accion : "userDepartamentoNew",
                        departamento_id: $("#usuario\\.formulario\\.departamento option:selected").val(),
                        user_id: $("#usuario\\.formulario\\.usuario option:selected").val(),
                    }

                    $.post("turnos/api", data).done(function(response){

                        let data = {
                            accion : "profesionalesFiltrados",
                            departamento_id: $("#usuario\\.departamento\\.filtrar option:selected").val()
                        }

                        $.post("turnos/api", data).done(function(response){
                            $("#usuarios\\.tabla").empty();
                            if (Object.keys(data).length > 0) {
                                $.each(response, function(i, item) {
                                    let fila = '<tr><td data-id="'+item.user_id+'">' + item.user_id + '</td><td>' + item.departamento_name + '</td><td>' + item.user_nombre + '</td><td>' + item.user_telefono + '</td><td>' + item.user_email + '</td><td><div class="btn-group" role="group"><button type="button" class="btn btn-outline-secondary editar-udep">Modificar</button><button type="button" class="btn btn-outline-secondary remover-udep"><i class="fas fa-trash"></i></button></div></td></tr>';
                                    $("#usuarios\\.tabla").append(fila);
                                });

                                $(".editar-udep").on("click", function(){});
                                $(".remover-udep").on("click", function(){});
                            }
                        });
                    });
                });

                $("#usuarios\\.formulario\\.cancelar").on("click", function(){
                    $("#usuarios\\.formulario\\.nuevo").removeClass("d-none");
                    $("#usuarios\\.formulario\\.guardar").addClass("d-none");
                    $("#usuarios\\.formulario\\.cancelar").addClass("d-none");
                    $("#usuarios\\.formulario").addClass("d-none");
                    $("#usuario\\.departamento\\.filtrar\\.contenedor").removeClass("d-none");
                });
            });
            <?php endif; ?>

            $("#boton\\.pormes").on("click", function(){
                $("#dialog\\.title").html("Calcular horas de turno por mes");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><label for="turnos.departamento">Departamento</label><input class="form-control" type="text" id="turnos.departamento" disabled=""></div><div class="form-group col-6"><label for="turnos.ano">Año</label><select class="form-control" id="turnos.ano"></select></div><div class="form-group col-6"><label for="turnos.mes">Mes de turno</label><select class="form-control" id="turnos.mes"></select></div><div class="form-group col-6"><label for="turnos.profesionales">Profesional</label><select class="form-control" id="turnos.profesionales"></select></div><div class="form-group col-12"><label for="turnos.conteo">Total de horas</label><input type="text" class="form-control" id="turnos.conteo" disabled></div></div>');
                $("#dialog\\.view").modal("show");
                $("#turnos\\.departamento").val($("#departamentos\\.header option:selected").text());
                
                <?php if (Session::get("user_account_type") == 6) : ?>
                let data = {
                    accion : "profesionalesFiltrados",
                    departamento_id: $("#departamentos\\.header option:selected").val()
                }

                $.post("turnos/api", data).done(function(response){
                    $("#turnos\\.profesionales").empty();
                    if (Object.keys(data).length > 0) {
                        $.each(response, function(i, item) {
                            let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                            $("#turnos\\.profesionales").append(option);
                        });
                    }
                });
                <?php endif; ?>
                <?php if (Session::get("user_account_type") == 2) : ?>
                let options = '<option value="<?php echo Session::get('user_id'); ?>"><?php echo Session::get('user_name'); ?></option>';
                $("#turnos\\.profesionales").append(options);
                <?php endif; ?>

                var mes = ['Enero','Febrero','Marzo','Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                
                let d = new Date();
                let option = '<option value="' + parseInt(d.getFullYear() - 1) + '">' + parseInt(d.getFullYear() - 1) + '</option><option value="' + d.getFullYear() + '" selected>' + d.getFullYear() + '</option><option value="' + parseInt(d.getFullYear() + 1) + '">' + parseInt(d.getFullYear() + 1) + '</option><option value="' + parseInt(d.getFullYear() + 2) + '">' + parseInt(d.getFullYear() + 2) + '</option>';
                $("#turnos\\.ano").append(option);

                $.each(mes, function(i, item) {
                    let option = '<option value="' + parseInt(i +1) + '">' + mes[i] + '</option>';
                    $("#turnos\\.mes").append(option);
                });

                $("#turnos\\.mes, #turnos\\.profesionales").on("click", function(){
                    let datos = {
                        accion: "sumaturnos",
                        mes: $("#turnos\\.mes").val(),
                        ano: $("#turnos\\.ano").val(),
                        profesional: $("#turnos\\.profesionales").val(),
                        departamento_id: $("#departamentos\\.header option:selected").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        $("#turnos\\.conteo").val(response.conteo);
                    });
                });
            });

            $("#modificar\\.nombre").on("click", function(){
                $("#dialog\\.title").html("Cambiar nombre");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><label for="cambiar.nombre">Cambiar Nombre</label><input class="form-control" type="text" id="cambiar.nombre"></div><div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    let datos = {
                        accion: "nombre",
                        user_nombre: $("#cambiar\\.nombre").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        alert( response == true ? "cambiado" : "Error al cambiar nombre, escriba un nombre");
                        if (response == true) {$("#dialog\\.view").modal("hide");}
                    });
                });
            });

            $("#modificar\\.telefono").on("click", function(){
                $("#dialog\\.title").html("Cambiar telefono");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><label for="cambiar.telefono">Cambiar Telefono</label><input class="form-control" type="number" id="cambiar.telefono"></div><div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    if ($.isNumeric($("#cambiar\\.telefono").val())){
                        let datos = {
                            accion: "telefono",
                            user_telefono: $("#cambiar\\.telefono").val()
                        }

                        $.post("turnos/api", datos).done(function(response){
                            alert( response == true ? "cambiado" : "Error al cambiar teléfono, escriba un número");
                            if (response == true) {$("#dialog\\.view").modal("hide");}
                        });
                    }
                    else{
                        alert("escriba un número, no se aceptan espacios, + y puntos");
                    }

                });
            });

            $("#modificar\\.correo").on("click", function(){
                $("#dialog\\.title").html("Cambiar correo");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><label for="cambiar.correo">Nuevo email</label><input class="form-control" type="email" id="cambiar.correo"></div><div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    let datos = {
                        accion: "email",
                        user_email: $("#cambiar\\.correo").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        alert( response == true ? "cambiado" : "Error al cambiar correo, escriba un correo válido sin espacios");
                        if (response == true) {$("#dialog\\.view").modal("hide");}
                    });
                });
            });

            $("#modificar\\.contrasena").on("click", function(){
                $("#dialog\\.title").html("Cambiar contraseña");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><label for="contrasena.actual">Contraseña actual</label><input class="form-control" type="password" id="contrasena.actual"></div><div class="col-6"></div><div class="form-group col-6"><label for="contrasena.nueva">Nueva contraseña</label><input type="password" class="form-control" id="contrasena.nueva"></div><div class="form-group col-6"><label for="contrasena.repetir">Repetir Contraseña</label><input class="form-control" type="password" id="contrasena.repetir"></div></div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Guardar</button>');

                $("#dialog\\.delete").on("click", function(){
                    let datos = {
                        accion: "contrasena",
                        user_password_current: $("#contrasena\\.actual").val(),
                        user_password_new: $("#contrasena\\.nueva").val(),
                        user_password_repeat: $("#contrasena\\.repetir").val()
                    }

                    $.post("turnos/api", datos).done(function(response){
                        alert( response == true ? "cambiado" : "Error al cambiar contraseña, vuelva a escribir las contraseñas");
                        if (response == true) {$("#dialog\\.view").modal("hide");}
                    });
                });
            });

            $("#boton\\.imprimir").on("click", function(){
                var documento = '<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="user-scalable=no,maximum-scale=1, minimum-scale=1, width=device-width, initial-scale=1, shrink-to-fit=no"><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"><link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous"><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous"><title>Turnos</title></head><body><h3 class="text-center">Calendario de Turnos Clinica Alemana Temuco, Mes :MES<br>Unidad o Departamento :DEPARTAMENTO</h3><p>&nbsp;</p>:Tabla<p>&nbsp;</p><div class="row"><div class="col px-5"><p class="mb-0 text-center">:FECHA</p><hr><p class="text-center">Fecha</p></div><div class="col px-5"><p class="mb-0 text-center">:JEFE</p><hr><p class="text-center">V° B° Jefe Unidad</p></div></body><script>document.addEventListener("DOMContentLoaded",function(event){var ventimp=window; var element = document.getElementById("table");element.classList.add("table-sm");ventimp.print();ventimp.close();});<\/script></html>'
                documento = documento.replace(':MES', $("#fecha\\.mes option:selected").text() + ' ' + $("#fecha\\.ano option:selected").text() );
                var element = document.getElementById("table");
                var calendario = element.outerHTML;
                let now = new Date();
                let day = ("0" + now.getDate()).slice(-2);
                let month = now.getMonth();
                let meses = ["Enero","Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                let today = (day)+ "-" + meses[month] + "-" + now.getFullYear();

                documento = documento.replace(':Tabla', calendario);
                documento = documento.replace(':FECHA', today);
                documento = documento.replace(':JEFE', JEFEA);
                documento = documento.replace(':DEPARTAMENTO', $("#departamentos\\.header option:selected").text())
                var ventimp = window.open(' ', 'popimpr');
                ventimp.document.write(documento);
                ventimp.document.close();
            });

            $("#boton\\.semana").on("click", function(){

                $("#dialog\\.title").html("Elegir semana de mes seleccionado previamente");
                $("#dialog\\.body").html('<div class="row"><div class="form-group col-6"><select class="form-control" id="cambiar.semanas.semana"></select></div><div>');
                $("#dialog\\.view").modal("show");
                $("#dialog\\.delete").remove();
                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete">Preparar reporte de impresion</button>');

                var year= $("#fecha\\.ano").val();
                var mes = $("#fecha\\.mes").val();
                var primerdia = ((new Date(year, mes, 1).getDay()-1)%7+7)%7;
                var dias=new Date(year, mes+1,0).getDate()-7+primerdia;
                let semanas = Math.ceil(dias/7)+1;
                let i = 1;
                for (i; i <= semanas; i++){
                    $("#cambiar\\.semanas\\.semana").append('<option value="'+ i +'">Semana '+ i +'</option>');
                }
                
                $("#dialog\\.delete").on("click", function(){
                    
                    let semana = $("#cambiar\\.semanas\\.semana").val();

                    let datos = {
                        accion: "calendarioSimple",
                        departamento: $("#departamentos\\.header").val(),
                        mes: mes,
                        ano: year,
                        semana: semana
                    }

                    $.post("turnos/api", datos).done(function(response){
                        if (Object.keys(response).length > 0) {
                            matrizProf = [];

                            $("#dialog\\.delete").attr("disabled", true);
                            $("#dialog\\.body").html('<div class="d-none" id="imprimir.semanas"></div><button type="button" class="btn btn-danger" id="dialog.finalprint">Ver Impresion</button>');
                            $("#imprimir\\.semanas").html('<table class="table table-td table-hover table-bordered"><thead class="bg-light" id="table.imprimir.semanas.head"></thead><tbody id="table.imprimir.semanas"></tbody></table>');

                            $.each(response.data, function(i, val){
                                if (matrizProf.includes(val.user_nombre) == false){
                                    matrizProf.push(val.user_nombre);
                                    let fila = '<tr><td>'+ val.user_nombre +'</td>';
                                    let fecha = parseInt(val.default_fecha.slice(-2));
                                    let h = response.semana_ini;

                                    if (response.mesAnt > 0 && h <= response.mesAnt){
                                        for (h; h <= response.mesAnt; h++){
                                            if (h == fecha){
                                                fila += '<td style="background-color:#FFFFE0 !important;"></td>'; 
                                            }
                                            else{
                                                fila += '<td></td>'; 
                                            }
                                        };
                                        h = 1;
                                    }

                                    for (h; h <= response.semana_fin; h++){
                                        if (response.mesPres > 0 && h > response.mesPres){
                                            if (h == fecha){
                                                fila += '<td style="background-color:#FFFFE0 !important;"></td>'; 
                                            }
                                            else{
                                                fila += '<td></td>'; 
                                            }
                                        }
                                        else{
                                            if (h == fecha){
                                                fila += '<td style="background-color:#FFFFE0 !important;"></td>'; 
                                            }
                                            else{
                                                fila += '<td></td>'; 
                                            }
                                        }
                                    };
                                    fila += '<td></td></tr>';
                                    $("#table\\.imprimir\\.semanas").append(fila);
                                }  
                            });

                            //añadir 5 filas más vacias
                            let vacio = '<tr><td><p>&nbsp;</p></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                            let x = 0
                            for (x; x < 5; x++){
                                $("#table\\.imprimir\\.semanas").append(vacio);
                            }
                            
                            let tableHeader = '<tr><th scope="col"><span class="h6">Profesional<br>de turno</span></th>';
                            let i = response.semana_ini;
                            let contadorDias = 0;
                            let dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

                            if (response.mesAnt > 0 && i <= response.mesAnt){
                                for (i; i <= response.mesAnt; i++){
                                    tableHeader += '<th scope="col" class="text-center">'+ dias[contadorDias]+ '<br>'+ i + '</th>';
                                    contadorDias++; 
                                };
                                i = 1;
                            }

                            for (i; i <= response.semana_fin; i++){
                                if (response.mesPres > 0 && i > response.mesPres){
                                    tableHeader += '<th scope="col" class="text-center">' + dias[contadorDias]+ '<br>'+ (i - response.mesPres) + '</th>';
                                    contadorDias++;
                                }
                                else{
                                    tableHeader += '<th scope="col" class="text-center">' + dias[contadorDias]+ '<br>'+ i + '</th>';
                                    contadorDias++;
                                }
                            };

                            tableHeader += '<th scope="col">Total Semana</th><tr>';
                            
                            $("#table\\.imprimir\\.semanas\\.head").append(tableHeader);

                            $("#dialog\\.finalprint").on("click", function(){
                                var documento = '<!doctype html><html lang="es"> <head> <meta charset="utf-8"> <meta name="viewport" content="user-scalable=no,maximum-scale=1, minimum-scale=1, width=device-width, initial-scale=1, shrink-to-fit=no"> <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"> <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous"> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/solid.css" integrity="sha384-VGP9aw4WtGH/uPAOseYxZ+Vz/vaTb1ehm1bwx92Fm8dTrE+3boLfF1SpAtB1z7HW" crossorigin="anonymous"> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/fontawesome.css" integrity="sha384-1rquJLNOM3ijoueaaeS5m+McXPJCGdr5HcA03/VHXxcp2kX2sUrQDmFc3jR5i/C7" crossorigin="anonymous"> <title>Turnos</title></head> <body> <h4 class="mt-2">Departamento o unidad: :DEPARTAMENTO , :MESANO</h4><p>&nbsp;</p>:TABLA <p>&nbsp;</p><div class="row"> <div class="col px-5"> <p class="mb-0 text-center">&nbsp;</p><hr> <p class="text-center">V° B° Coord. Unidad</p></div><div class="col px-5"> <p class="mb-0 text-center">&nbsp;</p><hr> <p class="text-center">V° B° Jefe Departamento</p></div></div><p><strong><u>Estimado Doctor(a): En la casilla correspondiente a su nombre y fecha, favor indicar horario de turno realizado y firma. En caso que no esté en nómina incorporar su nombre en las casillas vacías.</u></strong></p></body><script>document.addEventListener("DOMContentLoaded",function(event){var ventimp=window;ventimp.print();ventimp.close();});<\/script></html>';
                                var element = document.getElementById("imprimir.semanas");
                                var calendario = element.outerHTML;
                                calendario = calendario.replace('d-none', '');
                                documento = documento.replace(':MESANO', $("#fecha\\.mes option:selected").text() + " " + $("#fecha\\.ano option:selected").text());
                                documento = documento.replace(':TABLA', calendario);
                                documento = documento.replace(':DEPARTAMENTO', '&nbsp;&nbsp;&nbsp;' + $("#departamentos\\.header option:selected").text());
                                var ventimp = window.open(' ', 'popimpr');
                                ventimp.document.write(documento);
                                ventimp.document.close();
                            });
                        }
                    });
                });
            });
        });

      function makeCalendario(){
            let data = {
                accion : "calendario",
                departamento: $("#departamentos\\.header").val(),
                mes: $("#fecha\\.mes").val(),
                ano: $("#fecha\\.ano").val()
            }

            $.post("turnos/api", data).done(function(response){
                $("#table\\.calendario").empty();

                if (Object.keys(data).length > 0) {
                    let fila = "";
                    let dias = ["Lunes ", "Martes ", "Miércoles ", "Jueves ", "Viernes ", "Sábado ", "Domingo "];
                    let i = response.diaDeLaSemana;
                    let j = response.diasEnElMes;
                    let h = 1;
                    let turnos = response.turnos;
                    let comentarios = response.comentarios;
                    let defaultC = response.default;

                    for (h; h <= j; h++){
                        let rojo = "";
                        let elDia = i - 1;
                        if (elDia == 5 || elDia == 6){
                            rojo = "text-danger";
                        }

                        const turnosDia = turnos.filter(turno => {
                            let dia = data.ano + '-' + data.mes + '-' + ("0" + h).slice(-2);
                            return turno.turno_fechain === dia;
                        });

                        const comentariosDia = comentarios.filter(comentario =>{
                            let dia = data.ano + '-' + data.mes + '-' + ("0" + h).slice(-2);
                            return comentario.comentario_fecha === dia;
                        });

                        const defaultProfesional = defaultC.filter(defaultA =>{
                            let dia = data.ano + '-' + data.mes + '-' + ("0" + h).slice(-2);
                            return defaultA.default_fecha === dia;
                        });

                        let comentario = "";

                        if (comentariosDia.length > 0){
                            comentario = comentariosDia[0].comentario_text.replace(/<br \/>/g,"\n");
                            comentario = comentario.substring(0,70);
                            comentario += "...";
                        }

                        if (Object.keys(turnosDia).length > 0) {
                            let diaT = "";
                            let nocheT = "";
                            let diaP = "";
                            let diaI = "";
                            let nocheI = "";
                            let nocheP = "";

                            let defaultID = "";
                            let defaultName = "";

                            if (Object.keys(defaultProfesional).length > 0) {
                                defaultID = defaultProfesional[0].default_id;
                                defaultName = defaultProfesional[0].user_nombre;
                            }

                            const diaF = turnosDia.filter(elDia => {
                                return parseInt(elDia.turno_turno) === 0;
                            });

                            const nocheF = turnosDia.filter(laNoche => {
                                return parseInt(laNoche.turno_turno) === 1;
                            });

                            if (diaF.length > 0){
                                diaT = diaF[0].user_nombre;
                                diaI = diaF[0].turno_id;
                                diaP = diaF[0].turno_profesional;
                            }

                            if (nocheF.length > 0){
                                nocheT = nocheF[0].user_nombre;
                                nocheI = nocheF[0].turno_id;
                                nocheP = nocheF[0].turno_profesional;
                            }

                            if (diaP == <?php echo Session::get('user_id'); ?>){
                                diaP = "text-danger";
                            }
                            else{
                                diaP = "";
                            }

                            if (nocheP == <?php echo Session::get('user_id'); ?>){
                                nocheP = "text-danger";
                            }
                            else{
                                nocheP = "";
                            }

                            fila = '<tr><td class="bg-light ' + rojo +'">' + dias[elDia] + h + '</td><td class="text-center" data-id="' + defaultID +'" data-preset="1">' + defaultName + '</td><td class="text-center ' + diaP +'" data-id="' + diaI +'">' + diaT +'</td><td class="text-center ' + nocheP +'" data-id="' + nocheI +'">' + nocheT +'</td><td class="text-center" data-calendario="' + h + '">'+comentario+'</td></tr>';
                        }
                        else{
                            fila = '<tr><td class="bg-light ' + rojo +'">' + dias[elDia] + h + '</td><td></td><td class="text-center"></td><td class="text-center"></td><td class="text-center" data-calendario="' + h + '">'+comentario+'</td></tr>';    
                        }

                        if (i == 7){ 
                            i = 1;
                        }
                        else{
                            i++;
                        }

                        $("#table\\.calendario").append(fila);
                    }
                }

                <?php if (Session::get("user_account_type") > 1) : ?>
                $("#table\\.calendario tr td").on("click", function(){
                    let turno_id = $(this).data("id");
                    let preset_id = $(this).data("preset");
                    let calendario_id = $(this).data("calendario");
                    $("#dialog\\.delete").remove();

                    <?php if (Session::get("user_account_type") > 2) : ?>
                    if (typeof turno_id === 'number' && typeof preset_id === 'number'){
                        let data = {
                            accion : "defaultOne",
                            id: turno_id
                        }

                        $.post("turnos/api", data).done(function(response){
                            if (Object.keys(response).length > 0) {
                                let d = new Date(response.default_fecha.replace(/-/g, '\/'));
                                let day = ("0" + d.getDate()).slice(-2);
                                let month = ("0" + (d.getMonth() + 1)).slice(-2); 
                                let dateComplete = day + "-" + month + "-" + d.getFullYear();

                                $("#dialog\\.title").html('PROFESIONAL PROGRAMADO:');
                                $("#dialog\\.body").html('<div class="row"><div class="col"><p>' + response.user_nombre + ', fecha: ' + dateComplete +'</p></div></div><div class="row"><div class="form-group col"><label for="turnos.profesionales" class="text-danger text-center mt-3"><strong>Reemplazar por:</strong></label><select class="form-control" id="default.profesionales"></select></div></div>');
                                $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete" data-id="' + response.default_id + '">Guardar</button>');


                                let data = {
                                    accion : "profesionalesFiltrados",
                                    departamento_id: $("#departamentos\\.header option:selected").val()
                                }

                                $.post("turnos/api", data).done(function(response){
                                    $("#turnos\\.profesionales").empty();
                                    if (Object.keys(data).length > 0) {
                                        $.each(response, function(i, item) {
                                            let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                                            $("#default\\.profesionales").append(option);
                                        });
                                    }
                                });

                                $("#dialog\\.delete").on("click", function(){
                                    let id = $(this).data("id");
                                    let datos = {
                                        accion: "defaultUpdate",
                                        id: id,
                                        profesional: $("#default\\.profesionales").val()
                                    }

                                    $.post("turnos/api", datos).done(function(response){
                                        $("#dialog\\.view").modal("hide");
                                        makeCalendario();
                                    });
                                });
                                $("#dialog\\.view").modal("show");
                            }

                        });
                    }
                    else
                    <?php endif; ?>
                    if (typeof turno_id === 'number'){
                        let data = {
                            accion : "turnosUno",
                            id: turno_id
                        }
                        $.post("turnos/api", data).done(function(response){
                            if (Object.keys(response).length > 0) {
                                <?php if (Session::get("user_account_type") == 2) : ?>
                                if (<?php echo Session::get('user_id'); ?> == response.turno_profesional){
                                <?php endif; ?>
                                    let d = new Date(response.turno_fechain.replace(/-/g, '\/'));
                                    let day = ("0" + d.getDate()).slice(-2);
                                    let month = ("0" + (d.getMonth() + 1)).slice(-2); 
                                    let dateComplete = day + "-" + month + "-" + d.getFullYear();

                                    $("#dialog\\.title").html('CAMBIO PROFESIONAL DE TURNO:');
                                    $("#dialog\\.body").html('<div class="row"><div class="col"><p>' + response.user_nombre + ', fecha: ' + dateComplete +'</p></div></div><div class="row"><div class="form-group col"><label for="turnos.profesionales" class="text-danger text-center mt-3"><strong>Reemplazar por:</strong></label><select class="form-control" id="turnos.profesionales"></select></div></div>');
                                    $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete" data-id="' + response.turno_id + '">Guardar</button>');
                                    cargarProfesionales();

                                    $("#dialog\\.delete").on("click", function(){
                                        let id = $(this).data("id");
                                        let datos = {
                                            accion: "turnosCambiar",
                                            id: id,
                                            profesional: $("#turnos\\.profesionales").val(),
                                        }

                                        $.post("turnos/api", datos).done(function(response){
                                            $("#dialog\\.view").modal("hide");
                                            makeCalendario();
                                        });
                                    });
                                    $("#dialog\\.view").modal("show");
                                <?php if (Session::get("user_account_type") == 2) : ?>
                                }
                                <?php endif; ?> 
                            }
                        });
                    }
                    else if (typeof calendario_id === 'number'){
                        let mes = $("#fecha\\.mes").val();
                        let ano = $("#fecha\\.ano").val();
                        let dia = ano + '-' + mes + '-' + ("0" + calendario_id).slice(-2);
                        let data = {
                            accion : "comentario",
                            fecha: dia,
                            departamento_id: $("#departamentos\\.header option:selected").val()
                        }

                        let d = new Date(ano + '/' + mes + '/' + ("0" + calendario_id).slice(-2));
                        let day = ("0" + d.getDate()).slice(-2);
                        let month = ("0" + (d.getMonth() + 1)).slice(-2); 
                        let dateComplete = day + "-" + month + "-" + d.getFullYear();

                        $.post("turnos/api", data).done(function(response){
                            if (Object.keys(response).length > 0) {
                                if (response.autorizado == false){
                                    $("#dialog\\.title").html('No puedes comentar');
                                    $("#dialog\\.body").html('<p class="text-center">No autorizado</p>');
                                    $("#dialog\\.delete").remove();
                                    $("#dialog\\.view").modal("show");
                                }
                                else{
                                    if (typeof response.comentario === 'string'){
                                        $("#dialog\\.title").html("Crear comentario para el día " + dateComplete);
                                        $("#dialog\\.body").html('<div class="row"><div class="form-group col"><label for="comentarios.text">Comentario:</label><input class="form-control" id="comentarios.text" type="text" value=""></div></div>');
                                        $("#dialog\\.delete").remove();
                                        $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete" data-id="' + data.fecha + '">Guardar</button>');
                                        
                                        $("#dialog\\.delete").on("click", function(){
                                            let id = $(this).data("id");
                                            let datos = {
                                                accion: "comentarioGuardar",
                                                fecha: id,
                                                text: $("#comentarios\\.text").val().replace(/\r\n|\r|\n/g,"<br />"),
                                                departamento_id: $("#departamentos\\.header option:selected").val() 
                                            }

                                            $.post("turnos/api", datos).done(function(response){
                                                $("#dialog\\.view").modal("hide");
                                                makeCalendario();
                                            });
                                        });
                                        $("#dialog\\.view").modal("show");
                                    }
                                    else{
                                        $("#dialog\\.title").html('Comentario para el día ' + dateComplete);
                                        $("#dialog\\.body").html('<div class="row"><div class="form-group col"><label for="comentarios.text">Comentario:</label><input class="form-control" id="comentarios.text" type="text" value="' + response.comentario.comentario_text.replace(/<br \/>/g,"\n") +'"></div></div>');
                                        $("#dialog\\.delete").remove();
                                        $("#dialog\\.footer").append('<button type="button" class="btn btn-danger" id="dialog.delete" data-id="' + response.comentario.comentario_id + '">Guardar</button>');
                                        $("#dialog\\.delete").on("click", function(){
                                            let id = $(this).data("id");
                                            let datos = {
                                                accion: "comentarioUpdate",
                                                id: id,
                                                text: $("#comentarios\\.text").val().replace(/\r\n|\r|\n/g,"<br />"),
                                                departamento_id: $("#departamentos\\.header option:selected").val()
                                            }

                                            $.post("turnos/api", datos).done(function(response){
                                                $("#dialog\\.view").modal("hide");
                                                makeCalendario();
                                            });
                                        });
                                        $("#dialog\\.view").modal("show");
                                    }
                                }
                            }
                        });
                    }
                });
                <?php endif; ?> 
            });
      }

    function cargarProfesionales(){
        let data = {
                accion : "profesionales",
            }

            $.post("turnos/api", data).done(function(response){
                $("#tabla\\.profesionales").empty();
                $("#turnos\\.profesionales").empty();
                $("#turno\\.profesional\\.in").empty();
                $("#departamento\\.formulario\\.jefe").empty();
                if (Object.keys(data).length > 0) {
                    $.each(response, function(i, item) {
                        let fila = '<tr><td data-id="'+item.user_id+'">' + item.user_nombre + '</td><td>' + item.user_telefono + '<td>' + item.user_email + '</td></tr>';
                        let option = '<option value="' + item.user_id + '">' + item.user_nombre + '</option>';
                        $("#turnos\\.profesionales").append(option);
                        $("#tabla\\.profesional").append(fila);
                        $("#turno\\.profesional\\.in").append(fila);
                        $("#departamento\\.formulario\\.jefe").append(option);
                    });
                }
            });
    }

    function cargarDepartamentos(){
        let data = {
            accion : "departamentos",
        }

        $.post("turnos/api", data).done(function(response){
            $("#departamentos\\.tabla").empty();
            $("#departamentos\\.lista").empty();
            $("#departamento\\.lista").empty();

            let option = '<option value="null">Todos</option>';
            $("#departamento\\.lista").append(option);

            if (Object.keys(data).length > 0) {
                $.each(response, function(i, item) {
                    let fila = '<tr><td data-id="'+item.departamento_id+'">' + item.departamento_id + '</td><td>' + item.departamento_name + '</td><td>' + item.departamento_jefe + '</td></tr>';
                    let option = '<option value="' + item.departamento_id + '">' + item.departamento_name + '</option>';
                    $("#departamentos\\.tabla").append(fila);
                    $("#departamentos\\.lista").append(option);
                    $("#departamento\\.lista").append(option);
                });
            }
        });
    }
    </script>