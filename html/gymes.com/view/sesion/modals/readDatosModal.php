<!-- Modal para mostrar los datos de la sesión -->
<div class="modal fade" id="datosModal" tabindex="-1" aria-labelledby="datosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datosModalLabel">Datos de la Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="main-body">

                    <div class="row gutters-sm">
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="d-flex flex-column">
                                        <img src="https://animalcorner.org/wp-content/uploads/2020/04/black-pug-9138127.jpg" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3 block-datos-paciente-sesion">

                                            <div style="float:center;">
                                                <h5>
                                                    <i class="fa fa-user"></i>
                                                    <span id="profile_nombre" style="text-transform: capitalize;"></span>
                                                    <span id="profile_apellido" style="text-transform: capitalize;"></span>
                                                </h5>
                                            </div>

                                            <i class="fa fa-id-card"></i> <span id="profile_cedula"></span><br> <!-- Icono para cédula -->
                                            <i class="fa fa-envelope"></i> <span id="profile_email"></span><br> <!-- Icono para email -->
                                            <i class="fa fa-birthday-cake"></i> <span id="profile_fecha_nacimiento"></span><br> <!-- Icono para fecha de nacimiento -->
                                            <i class="fa fa-calendar-alt"></i> <span id="profile_fecha_creacion"></span><br> <!-- Icono para fecha de creación -->
                                            <i class="fa fa-home"></i> <span id="profile_direccion"></span><br> <!-- Icono para dirección -->
                                            <i class="fa fa-phone"></i> <span id="profile_telefono"></span><br> <!-- Icono para teléfono -->
                                            <i class="fa fa-briefcase"></i> <span id="profile_ocupacion"></span><br> <!-- Icono para ocupación -->
                                            <i class="fa fa-exclamation-triangle"></i> <span id="nota"></span><br> <!-- Icono para ocupación -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Medidas -->
                        <div class="col-md-9">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><b>Medidas</b></h5>
                                    <div class="row">
                                        <!-- Columna 1 -->
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Tórax:</td>
                                                        <td><span class="text-secondary" id="torax"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Axilas:</td>
                                                        <td><span class="text-secondary" id="axilas"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Busto:</td>
                                                        <td><span class="text-secondary" id="busto"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Brazo Derecho:</td>
                                                        <td><span class="text-secondary" id="brazo_der"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Brazo Izquierdo:</td>
                                                        <td><span class="text-secondary" id="brazo_izq"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Abdomen Alto:</td>
                                                        <td><span class="text-secondary" id="abd_alto"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Abdomen Bajo:</td>
                                                        <td><span class="text-secondary" id="abd_bajo"></span> cm</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Columna 2 -->
                                        <div class="col-md-6">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Cintura:</td>
                                                        <td><span class="text-secondary" id="cintura"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cadera:</td>
                                                        <td><span class="text-secondary" id="cadera"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Muslo Derecho:</td>
                                                        <td><span class="text-secondary" id="muslo_der"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Muslo Izquierdo:</td>
                                                        <td><span class="text-secondary" id="muslo_izq"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rodilla Derecha:</td>
                                                        <td><span class="text-secondary" id="rodilla_der"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rodilla Izquierda:</td>
                                                        <td><span class="text-secondary" id="rodilla_izq"></span> cm</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Glúteos:</td>
                                                        <td><span class="text-secondary" id="gluteos"></span> cm</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>






                        <!-- Datos Médicos -->
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Datos Médicos</b></h5>
                                        <table class="datos-medicos">
                                            <tr>
                                                <td style="text-align: left;"><b>Talla:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="talla"></span> cm</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;"><b>Peso:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="peso"></span> kg</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;"><b>TA:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="ta"></span> mmHg</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;"><b>Pulso:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="pulso"></span> lpm</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;"><b>FR:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="fr"></span> rpm</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;"><b>Medicamentos:</b></td>
                                                <td style="text-align: right;"><span class="text-secondary" id="medicamentos"></span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- Enfermedad y tratamiento -->
                            <div class="col-md-4 mb-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Enfermedad</b></h5>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item text-start">
                                                <b>Tipo de enfermedad:</b>
                                                <div><span class="text-secondary" id="enfermedad_tipo"></span></div>
                                            </div>
                                            <div class="list-group-item text-start mb-4">
                                                <b>Detalle de la enfermedad:</b>
                                                <div><span class="text-secondary" id="enfermedad_detalle"></span></div>
                                            </div>
                                        </div>
                                        <h5 class="card-title mt-4"><b>Tratamiento</b></h5>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item text-start">
                                                <b>Nombre de Tratamiento:</b>
                                                <div><span class="text-secondary" id="nombre"></span></div>
                                            </div>
                                            <div class="list-group-item text-start">
                                                <b>Área de Tratamiento:</b>
                                                <div><span class="text-secondary" id="area"></span></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>




                            <!-- Alimentacion -->
                            <div class="col-md-4 mb-3">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><b>Alimentación</b></h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item text-start"><b>Desayuno: </b><span class="text-secondary" id="desayuno"></span></li>
                                            <li class="list-group-item text-start"><b>Almuerzo: </b><span class="text-secondary" id="almuerzo"></span></li>
                                            <li class="list-group-item text-start"><b>Merienda: </b><span class="text-secondary" id="merienda"></span></li>
                                            <li class="list-group-item text-start"><b>Comida extra: </b><span class="text-secondary" id="extra"></span></li>
                                            <li class="list-group-item text-start"><b>Dieta recomendada: </b><span class="text-secondary" id="recomendada"></span></li>
                                            <li class="list-group-item text-start"><b>Observaciones: </b><span class="text-secondary" id="observaciones"></span></li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>