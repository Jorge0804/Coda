@extends('vistas.base')

@section('css')
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
                        <input type="date" name="fecha" id="mesactual" class="form-control" value="date_now()" required="required" title="">
                      </div>
                    </div>
                    <hr>


                    <h2>Diesel</h2>
                      <div class="form-group form-inline">

                        <label>Buscar precio &nbsp;</label>
                        <select name="" id="valores" class="form-control form-control-sm" onchange="ActualizarPrecio()">
                          @foreach($datos['diesel'] as $d)
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

                      <h2>Origen - Destino</h2>
                      <div class="form-group form-inline">
                      	<label>Origen &nbsp;</label>
                      	<select name="" id="input" class="form-control form-control-sm">
                      		@foreach($datos['estados'] as $estado)
                      			<option value="{{$estado}}">{{$estado->nombre}}</option>
                      		@endforeach
                      	</select>
                      	<select name="" id="input" class="form-control form-control-sm">
                      		@foreach($datos['estados'] as $estado)
                      			<option value="{{$estado}}">{{$estado->nombre}}</option>
                      		@endforeach
                      	</select>
                      </div>
                      <hr>

                    <div class="row">
                      <div class="form-group form-inline col-lg-12">

                        <div class="form-group form-inline col-lg-6">
                        	<label class="col-sm-5">Clientes</label>
                        	<select name="" id="input" class="form-control form-control-sm">
                        		@foreach($datos['clientes'] as $cliente)
                         			<option value="{{$cliente}}">{{$cliente->nombre}}</option>
                          		@endforeach
                        	</select>
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


                </div>
              </div>
          </div>
      </div>
  </div>
</form>
@endsection

@section('javascripts')
<script type="text/javascript">
	function CargarCiudades()
	{
		
	}
</script>
@endsection