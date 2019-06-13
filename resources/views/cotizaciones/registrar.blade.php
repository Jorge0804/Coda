@extends('vistas.base')

@section('css')
<style type="text/css">
  .switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #EC6610;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}


table {
  font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    font-size: 12px;    
    margin: 15px;     
    width: 480px; 
    text-align: left;    
    border-collapse: collapse; 
}

th {  
  font-size: 13px;     
  font-weight: normal;     
  padding: 8px;     
  background: #b9c9fe;
    border-top: 4px solid #aabcfe;    
    border-bottom: 1px solid #fff; 
    color: #039; 
}

td {    
  padding: 8px;     
  background: #e8edff;     
  border-bottom: 1px solid #fff;
    color: #669;    
    border-top: 1px solid transparent; 
}

tr:hover td { 
  background: #d0dafd; 
  color: #339; 
}

input.input-table{
  background-color: #e3e6f0; 
  border-color: #039; 
  color: #039; 
  border: 0; 
  text-align: center; 
  width: 100px;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenido')
<form method="GET" action="{{url('/RegistrarMensual')}}">
  @csrf
	 <div class="row">
            <div class="col-lg-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                  <h6 class="m-0 font-weight-bold text-primary">Registrar mensual</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collapseCardExample">
                  <div class="card-body">
                    <div class="form-group">
                      <h2>Fecha</h2>
                      <div class="col-sm-3">
                        <input type="month" name="fecha" id="mesactual" class="form-control" value="" required="required" title="" onchange="SacarResumen($(this))">
                      </div>
                    </div>
                    <hr>


                    <h2>Diesel</h2>
                      <div class="form-group form-inline">

                        <label>Buscar precio &nbsp;</label>
                        <select name="" id="valores" class="form-control form-control-sm" onchange="ActualizarPrecio()">
                          @foreach($diesel as $d)
                          <option value='{{json_encode($d)}}' id="fechas">
                            {{date_format(date_create($d->periodo->fecha_inicio), 'M/Y')}}</option>
                          @endforeach
                        </select>
                        &nbsp;&nbsp;

                        <label>costo: &nbsp;</label>
                        <input type="number" name="precio_diesel" id="precio" class="form-control form-control-sm" value="" required="required" step="any">
                        &nbsp; &nbsp;


                        <label>&nbsp;¿Aplicar iva? &nbsp;</label>
                        <label class="switch">
                          <input type="checkbox" onclick="ApilcarIva()" value="">
                          <span class="slider round"></span>
                        </label>

                      </div>
                      <hr>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Sueldo por km &nbsp;</label>
                          <input step="any" type="number" name="sueldo_km" id="sueldo_km" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Unidades pagadas &nbsp;</label>
                          <input step="any" type="number" name="Unidades_pagadas" id="Unidades_pagadas" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Incremento casetas &nbsp;</label>
                          <input step="any" type="number" name="Incremento_casetas" id="Incremento_casetas" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Kms mensuales &nbsp;</label>
                          <input step="any" type="number" name="km_mensuales" id="km_mensuales" class="form-control form-control-sm" value="" required="required" onkeyup="CostoKilometro()">
                          <br><br>
                        </div>

                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Unidades operativas  &nbsp;</label>
                          <input step="any" type="number" name="unidades_operativas" id="unidades_operativas" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Viajes por mes &nbsp;</label>
                          <input step="any" type="number" name="viajes_mes" id="viajes_mes" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Kms por unidad &nbsp;</label>
                          <input step="any" type="number" name="kms_unidad" id="kms_unidad" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Viajes por unidad &nbsp;</label>
                          <input step="any" type="number" name="viajes_unidad" id="viajes_unidad" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Distancia por viaje &nbsp;</label>
                          <input step="any" type="number" name="distancia_viaje" id="distancia_viaje" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">Ventas por viaje &nbsp;</label>
                          <input step="any" type="number" name="" id="ventas_viaje" class="form-control form-control-sm" value="" required="required">
                          <br><br>
                        </div>

                      </div>
                      
                    </div>
                    <hr>

<!---------------------------------Costo variable de operacion------------------------------>

                    
                    <a href="#collcvo" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collcvo">
                      <h5>Costo variable de operación</h5>
                    </a>
                    <div class="collapse show" id="collcvo">
                      <div class="card-body">
                        <table class="table table-condensed" id="cvo" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Total ingresos</th>
                          <th><input type="number" name="total_ingresos" id="total_ingresos" class="form-control form-control-sm input-table" value="" required="required" onkeyup="CostoKilometro()"></th>
                          <th>100%</th>
                          <th>$ <output id="xkm" name="">0.00</output> <i>(Por kilometro)</i></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Casetas y peajes</td>
                          <td><input type="number" name="cvo_casetas_peajes" id="casetas_peajes" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Combustibles</td>
                          <td><input type="number" name="cvo_combustibles" id="combustibles" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Facilidades administrativas</td>
                          <td><input type="number" name="cvo_facilidades_admin" id="facilidades_admin" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Gastos de viajes</td>
                          <td><input type="number" name="cvo_gastos_viaje" id="gastos_viaje" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldos de operadores</td>
                          <td><input type="number" name="cvo_sueldos_operadores" id="sueldo_operadores" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Total</th>
                          <th><input type="number" name="cvo_total" id="total" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                        <tr>
                          <th>Margen de operación</th>
                          <th><input type="number" name="cvo_margen" id="cvototal" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="cvoporcentaje">---</output></th>
                          <th><output id="cvokm">---</output></th>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                    </div>
                    
                    <hr>

<!--------------------------------------CVM------------------------------------------------->

                    <a href="#collcvm" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collcvm">
                      <h5>Costo variable de mantenimiento</h5>
                    </a>
                    <div class="collapse show" id="collcvm">
                      <div class="card-body">
                        <table class="table table-condensed" width="100%" cellspacing="0"
                    id="cvm">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Accesorios</td>
                          <td><input type="number" name="cvm_accesorios" id="accesorios" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Alineación y balnceo</td>
                          <td><input type="number" name="cvm_alineacion_balanceo" id="alineacion_balanceo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        
                        <tr>
                          <td>Facilidades administrativas</td>
                          <td><input type="number" name="cvm_facilidades_admin" id="facilidades_admin_cvo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Carrocería y pintura</td>
                          <td><input type="number" name="cvm_carroceria_pintura" id="cvm_carroceria_pintura" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Conexiones, mangueras y tornillera</td>
                          <td><input type="number" name="cvm_conexiones_mangueras_tornilleras" id="cvm_conexiones_mangueras_tornilleras" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Filtros</td>
                          <td><input type="number" name="cvm_filtros" id="filtros" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output>---</output></td>
                          <td><output>---</output></td>
                        </tr>
                        <tr>
                          <td>Imagen unidades</td>
                          <td><input type="number" name="cvm_imagen_unidades" id="imagen_unidades" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Insumos del  taller</td>
                          <td><input type="number" name="cvm_insumos_taller" id="insumos_taller" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Lavados de equipo</td>
                          <td><input type="number" name="cvm_lavados_equipo" id="lavados_equipo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Llantas</td>
                          <td><input type="number" name="cvm_llantas" id="llantas" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Lubricantes y grasas</td>
                          <td><input type="number" name="cvm_lubricantes_grasa" id="lubricantes_grasa" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Mano de obra taller</td>
                          <td><input type="number" name="cvm_mano_obra" id="mano_obra" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Mantenimiento preventivo</td>
                          <td><input type="number" name="cvm_mantenimiento_preventivo" id="mantenimiento_preventivo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Montaje y desmontaje de llantas</td>
                          <td><input type="number" name="cvm_montaje_desmontaje" id="montaje_desmontaje" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Refacciones</td>
                          <td><input type="number" name="cvm_refacciones" id="refacciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema de aire acondicionado</td>
                          <td><input type="number" name="cvm_aire_acondicionado" id="aire_acondicionado" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema de enfriamiento</td>
                          <td><input type="number" name="cvm_sistema_enfriamiento" id="sistema_enfriamiento" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema de sujeción</td>
                          <td><input type="number" name="cvm_sistema_sujecion" id="sistema_sujecion" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema dirección hidraúlica</td>
                          <td><input type="number" name="cvm_direccion_hidraulica" id="direccion_hidraulica" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema eléctrico y luces</td>
                          <td><input type="number" name="cvm_electrico_luces" id="electrico_luces" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema mecánico motor</td>
                          <td><input type="number" name="cvm_mecanico_motor" id="mecanico_motor" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sistema neumático, frenos</td>
                          <td><input type="number" name="cvm_neumatico_frenos" id="neumatico_frenos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldos del taller</td>
                          <td><input type="number" name="cvm_sueldos_taller" id="sueldos_taller" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Suspensión</td>
                          <td><input type="number" name="cvm_suspension" id="suspension" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Taller externo</td>
                          <td><input type="number" name="cvm_taller_externo" id="taller_externo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Transmisión y diferencial</td>
                          <td><input type="number" name="cvm_transmision_diferencial" id="transmision_diferencial" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Total</th>
                          <th><input type="number" name="cvm_total" id="total" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Total de costos variables</th>
                          <th><output id="total_variables">---</output></th>
                          <th><output id="porcentaje_variables">---</output></th>
                          <th><output id="xkm_variables">---</output></th>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                    </div>
                    <hr>

<!------------------------------------Incidencias operativas------------------------------>

                    <a href="#collio" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collio">
                      <h5>Incidencias operativas</h5>
                    </a>
                    <div class="collapse show" id="collio">
                      <div class="card-body">
                        <table class="table table-condensed" width="100%" cellspacing="0" id="io">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Deducibles</td>
                          <td><input type="number" name="io_deducibles" id="deducibles" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Gestoría federales</td>
                          <td><input type="number" name="io_gestoria_federales" id="gestoria_federales" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Gestoría otros</td>
                          <td><input type="number" name="io_gestoria_otros" id="gestoria_otros" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Gestría SCT</td>
                          <td><input type="number" name="io_gestoria_sct" id="gestoria_sct" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Grúas y arrastres</td>
                          <td><input type="number" name="io_gruas_arrastres" id="gruas_arrastres" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Maniobras</td>
                          <td><input type="number" name="io_maniobras" id="maniobras" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Multas, derechos y suscripciones</td>
                          <td><input type="number" name="io_multas_derechos_suscripciones" id="multas_derechos_suscripciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Reparación de cristales</td>
                          <td><input type="number" name="io_reparacion_cristales" id="reparacion_cristales" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Total</th>
                          <th><input type="number" name="io_total" id="total" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                    </div>
                    <hr>

<!----------------------------------Costo fijo de operacion---------------------------------->
                    
                    <a href="#collcfo" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collcfo">
                      <h5>Costo fijo de operaciòn</h5>
                    </a>
                    <div class="collapse show" id="collcfo">
                      <div class="card-body">
                        <table class="table table-condensed" width="100%" cellspacing="0" id="cfo">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Arrendamiento de unidades</td>
                          <td><input type="number" name="cfo_arrendamiento_unidades" id="arrendamiento_unidades" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Corralones</td>
                          <td><input type="number" name="cfo_corralones" id="corralones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Locaización</td>
                          <td><input type="number" name="cfo_localizacion" id="localizacion" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Multas, derechos y suscripciones</td>
                          <td><input type="number" name="cfo_multas_derechos_suscripciones" id="cfo_multas_derechos_suscripciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>No deducibles</td>
                          <td><input type="number" name="cfo_no_deducibles" id="no_deducibles" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Seguros</td>
                          <td><input type="number" name="cfo_seguros" id="seguros" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldos y salarios</td>
                          <td><input type="number" name="cfo_sueldos_salarios" id="cfo_sueldos_salarios" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldos y salario <i>(carga social)</i></td>
                          <td><input type="number" name="cfo_sueldos_salaios_cs" id="cfo_sueldos_salaios_cs" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Telefonía y comunicaciones</td>
                          <td><input type="number" name="cfo_telefonia_comuniaciones" id="telefonia_comuniaciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Uniformes y equipo</td>
                          <td><input type="number" name="cfo_uniformes_equipo" id="uniformes_equipo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output>---</output></td>
                          <td><output>---</output></td>
                        </tr>
                        <tr>
                          <th>Total</th>
                          <th><input type="number" name="cfo_total" id="total" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                    </div>


                    
                    <hr>

<!------------------------------Costo fijo de administracion------------------------------->

                    <a href="#collcfa" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collcfa">
                      <h5>Costo fijo de administraciòn</h5>
                    </a>
                    <div class="collapse show" id="collcfa">
                      <div class="card-body">
                        <table class="table table-condensed" width="100%" cellspacing="0" id="cfa">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Arrendamiento</td>
                          <td><input type="number" name="cfa_arrendamiento" id="cfa-arrendamiento" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Cafetería y despensa</td>
                          <td><input type="number" name="cfa_cafeteria_despensa" id="cafeteria_despensa" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Equipo de cómputo y sistemas</td>
                          <td><input type="number" name="cfa_computo_sistemas" id="cfa_computo_sistemas" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Eventos y reconocimientos</td>
                          <td><input type="number" name="cfa_eventos_reconocimientos" id="cfa_eventos_reconocimientos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Facilidades administrativas</td>
                          <td><input type="number" name="cfa_facilidades_admin" id="cfa_facilidades_admin" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Gastos de viaje</td>
                          <td><input type="number" name="cfa_gastos_viaje" id="cfa_gastos_viaje" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Gastos médicos</td>
                          <td><input type="number" name="cfa_gastos_medicos" id="cfa_gastos_medicos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Impuestos</td>
                          <td><input type="number" name="cfa_impuestos" id="cfa_impuestos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Multas, derechos y suscripciones</td>
                          <td><input type="number" name="cfa_multas_derechos_suscripciones" id="cfa_multas_derechos_suscripciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Papelería y artículos de oficina</td>
                          <td><input type="number" name="cfa_papeleria_oficina" id="cfa_papeleria_oficina" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Recultamiento de personal</td>
                          <td><input type="number" name="cfa_reclutamiento_personal" id="reclutamiento_personal" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Refacciones</td>
                          <td><input type="number" name="cfa_refacciones" id="cfa_refacciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Seguros</td>
                          <td><input type="number" name="cfa_seguros" id="cfa_seguros" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Servicios ordinarios</td>
                          <td><input type="number" name="cfa_servicios_ordinarios" id="cfa_servicios_ordinarios" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Servicios profesionales</td>
                          <td><input type="number" name="cfa_servicios_profesionales" id="cfa_servicios_profesionales" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldos y salarios</td>
                          <td><input type="number" name="cfa_sueldos_salarios" id="cfa_sueldos_salarios" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Taller externo</td>
                          <td><input type="number" name="cfa_taller_externo" id="cfa_taller_externo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Telefonía y comunicaciones</td>
                          <td><input type="number" name="cfa_telefonia_comunicaciones" id="cfa_telefonia_comunicaciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Uniforme y equipo</td>
                          <td><input type="number" name="cfa_uniforme_equipo" id="cfa_uniforme_equipo" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Total</th>
                          <th><input type="number" name="cvo_total" id="total" class="form-control form-control-sm input-table" value="" readonly="readonly"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <tr>
                          <th>Total de fijos y administración</th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                        <tr>
                          <th>UAFIRDA</th>
                          <th><input type="number" name="cfa_uafirda" id="uafirda" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                        <tr>
                          <td>Depreciaciones</td>
                          <td><input type="number" name="cfa_depreciaciones" id="depreciaciones" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Costo financiero</td>
                          <td><input type="number" name="cfa_financiero" id="financiero" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Total depreciacion y costo financiero</th>
                          <th><input type="number" name="cfa_depreciacion_cfinanciero" id="depreciacion_financiero" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                        <tr>
                          <th>UAFIR</th>
                          <th><input type="number" name="cfa_uafir" id="uafir" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                    </div>    
                    <hr>

<!------------------------------Otros gastos e ingresos------------------------------------->

                    <a href="#collof" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collof">
                      <h5>Otros factores</h5>
                    </a>
                    <div class="collapse show" id="collof">
                      <div class="card-body">
                        <table class="table table-condensed" width="100%" cellspacing="0" id="ogi">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Otros ingresos</td>
                          <td><input type="number" name="ogi_otros_ingresos" id="ogi_otros_ingresos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Productos financieros</td>
                          <td><input type="number" name="ogi_productos_financieros" id="ogi_productos_financieros" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Otros gastos</td>
                          <td><input type="number" name="ogi_otros_gastos" id="ogi_otros_gastos" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Utilidades ante impuestos</th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                        <tr>
                          <td>Estrategia fiscal ante reeinversión</td>
                          <td><input type="number" name="ogi_estrategia_fiscal" id="ogi_estrategia_fiscal" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <td>Otros ingresos</td>
                          <td><input type="number" name="ogi_otros_ingresos2" id="ogi_otros_ingresos2" class="form-control form-control-sm input-table" value=""  onkeyup="CalcularPorcentaje($(this))"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="xkm">---</output></td>
                        </tr>
                        <tr>
                          <th>Utilidades despúes de reeinversión</th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                          <th><output>---</output></th>
                        </tr>
                      </tbody>
                    </table>
                      </div>
                    </div>


                    
                    <hr>

                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collresumen" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collresumen">
                  <h6 class="m-0 font-weight-bold text-primary">Resumen</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="collresumen">
                  <div class="card-body">
                    <table class="table table-condensed" id="resumen" width="100%" cellspacing="0">
                      <thead>
                      </thead>
                      <tbody>
                        <tr>
                          <th>Costo variable de operación <i>(CVO)</i></th>
                          <th><input type="number" name="cvo_total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="porcentaje">---</output></th>
                          <th><output id="km">---</output></th>
                        </tr>
                        <tr>
                          <td>Diesel</td>
                          <td><input type="number" name="cvo_general_diesel" id="general_diesel" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Autopistas</td>
                          <td><input type="number" name="cvo_general_autopista" id="general_autopista" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Sueldo</td>
                          <td><input type="number" name="cvo_general_sueldo" id="general_sueldo" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Otros</td>
                          <td><input type="number" name="cvo_general_otros" id="general_cvo_otros" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Costo variable de mantenimiento <i>(CVM)</i></th>
                          <th><input type="number" name="total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="tporcentaje">---</output></th>
                          <th><output id="tkm">---</output></th>
                        </tr>
                        <tr>
                          <td>Refacciones y M.O.</td>
                          <td><input type="number" name="cvm_general_refacciones_mo" id="general_refacciones_mo" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Llantas</td>
                          <td><input type="number" name="cvm_general_llantas" id="general_llantas" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Incidencias operativas <i>(IO)</i></th>
                          <th><input type="number" name="total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="porcentaje">---</output></th>
                          <th><output id="km">---</output></th>
                        </tr>
                        <tr>
                          <td>Deducibles y otros gastos</td>
                          <td><input type="number" name="io_general_deducibles_gastos" id="general_deducibles_gastos" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Costo fijo de operación <i>(CFO)</i></th>
                          <th><input type="number" name="total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="porcentaje">---</output></th>
                          <th><output id="km">---</output></th>
                        </tr>
                        <tr>
                          <td>Arrendamientos</td>
                          <td><input type="number" name="cfo_general_arrendamientos" id="general_arrendamientos" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Seguros</td>
                          <td><input type="number" name="cfo_general_seguros" id="general_seguros" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Carga social</td>
                          <td><input type="number" name="cfo_general_carga_social" id="general_carga_social" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Otros</td>
                          <td><input type="number" name="cfo_general_otros" id="general_cfo_otros" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Costo fijo de administración <i>(CFA)</i></th>
                          <th><input type="number" name="total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="porcentaje">---</output></th>
                          <th><output id="km">---</output></th>
                        </tr>
                        <tr>
                          <td>Sueldos y salarios</td>
                          <td><input type="number" name="cfa_general_sueldo_salarios" id="general_sueldo_salarios" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <td>Otros</td>
                          <td><input type="number" name="cfa_general_otros" id="general_cfa_otros" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                        <tr>
                          <th>Costo integro del financiamiento <i>(CIF)</i></th>
                          <th><input type="number" name="total_ingresos" id="general" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></th>
                          <th><output id="porcentaje">---</output></th>
                          <th><output id="km">---</output></th>
                        </tr>
                        <tr>
                          <td>Intereses</td>
                          <td><input type="number" name="cif_general_intereses" id="cif_general_intereses" class="form-control form-control-sm input-table" value="" step="any" onkeyup="CostoKilometro()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

          </div>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
  var coti;
  var a;

  $(document).ready(function() {
    $('#precio').val($('#valores').val());

    a = false;

    coti = JSON.parse($('#valores').val());
    $('#precio').val(coti.precio);
  });

  function SacarResumen(obj)
  {
    /*$.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });*/
        $('#general_diesel').val($('#combustibles').val());
        $('#general_autopista').val($('#casetas_peajes').val());
        $('#general_sueldo').val($('#sueldo_operadores').val());
        $('#general_cvo_otros').val(parseFloat($('#facilidades_admin').val()) + parseFloat($('#gastos_viaje').val()));
        var refacciones = $('#cvm input').not('#total').not('#llantas').not('#montaje_desmontaje');
        var sum = 0;
        refacciones.each(function(index, el) {
          if (el.value) {
            sum += parseFloat(el.value);
          }
        });
        $('#general_refacciones_mo').val(sum);
        $('#general_llantas').val(parseFloat($('#llantas').val())+parseFloat($('#montaje_desmontaje').val()));

        $('#general_deducibles_gastos').val($('#io #total').val());

        $('#general_arrendamientos').val(parseFloat($('#arrendamiento_unidades').val())+parseFloat($('#depreciacion').val()));
        $('#general_seguros').val($('#seguros').val()); 
        $('#general_carga_social').val(parseFloat($('#cfo_sueldos_salarios').val())+parseFloat($('#cfo_sueldos_salaios_cs')));
        var otros = $('#cfo input').not('#arrendamiento_unidades').not('#seguros').not('#cfo_sueldos_salaios_cs').not('#cfo_sueldos_salarios').not('#total');
        sum = 0;
        otros.each(function(index, el) {
          sum += parseFloat(el.value);
        });
        $('#general_cfo_otros').val(sum);

        $('#general_sueldo_salarios').val(parseFloat($('#cfa_sueldos_salarios').val())+parseFloat($('#cfa_servicios_profesionales').val()));
        otros = $('#cfa input').not('#cfa_sueldos_salarios').not('#cfa_servicios_profesionales');
        sum = 0;
        otros.each(function(index, el) {
          sum += parseFloat(el.value);
        });
        $('#general_cfa_otros').val(sum);         
  }

  function CalcularPorcentaje(obj)
  {
    if ($('#total_ingresos').val() && $('#km_mensuales')) {
      var id = obj.attr('id');
      var out = $('#'+id).parent('td').siblings('td').children('output');

      out[0].value = '-'+Math.ceil($('#'+id).val()*100/$('#total_ingresos').val()*100)/100+'%';
      out[1].value = '$'+Math.ceil($('#'+id).val()/$('#km_mensuales').val()*100)/100;

      SacarTotales(obj);
    }

    SacarResumen(obj);
  } 

  function SacarTotales(obj)
  {
    var outputs = $('#'+obj.parents('table').attr('id')+' td output');
    var sum = 0;
    var inputs = $('#'+obj.parents('table').attr('id')+' input').not('#total_ingresos').not('#total').not('#cvototal');
    var por = 0;
    var ckm = 0;


    inputs.each(function(index, el) {
      if (el.value) {
        sum += parseFloat(el.value); 
        por += parseFloat(Math.ceil(el.value*100/$('#total_ingresos').val()*100)/100);
        ckm += parseFloat(Math.ceil(el.value/$('#km_mensuales').val()*100)/100);
      }
    });
    $('#'+obj.parents('table').attr('id')+' #total').val(sum);
    $('#'+obj.parents('table').attr('id')+' #tporcentaje').val('- '+por+'%');
    $('#'+obj.parents('table').attr('id')+' #tkm').val('$ '+ckm);

    if ($('#cvo #total').val() && $('#cvm #total').val()) {
      $('#total_variables').val(parseFloat($('#cvo #total').val())+parseFloat($('#cvm #total').val()));
      $('#porcentaje_variables').val(parseFloat($('#cvo #tporcentaje'))+parseFloat($('#cvm #tporcentaje').val()));
      $('#xkm_variables').val(parseFloat($('#cvo #tkm').val())+parseFloat($('#cvm #tkm').val()));
    }

    if ($(obj.parents('table')).attr('id') == 'cvo') {
      CalcularMargen(sum, por, ckm);
    }
  }

  function CalcularMargen(sum, por, ckm)
  {
    $('#cvototal').val(($('#total_ingresos').val()-sum));
    $('#cvoporcentaje').val(100-por+'%');
    $('#cvokm').val('$ '+($('#xkm').val()-ckm));
  }

  function CostoKilometro()
  {
    var km_mensuales = $('#km_mensuales').val();
    var total_ingresos = $('#total_ingresos').val();
    if (km_mensuales && total_ingresos)
    {
      $('#xkm').val(Math.ceil(total_ingresos/km_mensuales*100)/100);
      Recalcular();
    }
  }

  function Recalcular()
  {
    var out = $('td').children('output');
    var i = 0;
    var input = $('td input');


    out.each(function(index, el) {
      if (el.value != '---') {
        if (el.id == 'porcentaje') {
          el.value = '-'+Math.ceil(input[i].value*100/$('#total_ingresos').val()*100)/100+'%';
        }
        else {
          el.value = '$'+Math.ceil(input[i].value/$('#km_mensuales').val()*100)/100; 
          i++;
        }
      }
    });
  }

  function ActualizarPrecio()
  {
    coti = JSON.parse($('#valores').val());
    if (a) {
      $('#precio').val(Math.ceil(coti.precio*coti.iva*100)/100);
    }
    else{
      $('#precio').val(Math.ceil(coti.precio*100)/100);
    }
  }

  function ApilcarIva()
  {
    if (a) {
      $('#precio').val(coti.precio);
      a = false;
    }
    else{
      $('#precio').val(Math.ceil(coti.precio*coti.iva*100)/100);
      a = true;
    }
  }
</script>
@endsection
