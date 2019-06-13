<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diesel;
use App\Cliente;
use App\Periodo;
use App\Cotizacion;
use App\Promedio;
use App\Reporte_mensual;
use App\CFA_mensual;
use App\CFO_mensual;
use App\CVM_mensual;
use App\CVO_mensual;
use App\IO_mensual;
use App\CF;
use App\CFA;
use App\CFO;    
use App\CVM;
use App\CVO;
Use App\IO;
use App\Ciudad;
use App\Estado;

class CotizacionController extends Controller
{
    function FormrRegistrarMensual()
    {
    	$diesel = Diesel::with('periodo')->get();
    	foreach ($diesel as $d) {
    		$d->periodo = Periodo::find($d->periodo);	
    	}
    	return view('cotizaciones.registrar', compact('diesel'));
    }

    function SacarResumenMensual(Request $r)
    {
        return CalculosController::AcumuladoCostos($r->fecha);
    }

    function RegistrarMensual(Request $r)
    {
        $cf = new CF();
        $cfa = new  CFA();
        $cfa_menusal = new CFA_mensual();
        $cfo = new CFO();
        $cfo_mensual = new CFO_mensual();
        $cvm = new CVM();
        $cvm_mensual = new CVM_mensual();
        $cvo = new CVO();
        $cvo_mensual = new CVO_mensual();
        $io = new IO();
        $Reporte_mensual = new Reporte_mensual();

        return $r;

          $cvm_mensual->accesorios = $r->cvm_accesorios;
          $cvm_mensual->alineacion_balanceo = $r->cvm_alineacion_balanceo;  
          $cvm_mensual->carroceria_pintura = $r->cvm_carroceria_pintura;
          $cvm_mensual->con_man_tor = $r->cvm_conexiones_mangueras_tornilleras;
          $cvm_mensual->facilidades_administrativas = $r->cvm_facilidades_admin;  
          $cvm_mensual->filtros = $r->filtros;
          $cvm_mensual->imagen_unidades = $r->cvm_imagen_unidades;  
          $cvm_mensual->insumos_taller = $r->cvm_insumos_taller;  
          $cvm_mensual->lavados_equipo = $r->cvm_lavados_equipo; 
          $cvm_mensual->llantas = $r->cvm_llantas;
          $cvm_mensual->lubricantes_grasa= $r->cvm_lubricantes_grasa;  
          $cvm_mensual->mano_obra = $r->cvm_mano_obra;
          $cvm_mensual->mantenimiento_preventivo = $r->cvm_mantenimiento_preventivo; 
          $cvm_mensual->montaje_desmontaje = $r->cvm_montaje_desmontaje;
          $cvm_mensual->refacciones = $r->cvm_refacciones;
          $cvm_mensual->aire_acondicionado = $r->cvm_aire_acondicionado;  
          $cvm_mensual->sistema_enfriamiento = $r->cvm_sistema_enfriamiento;  
          $cvm_mensual->sistema_sujecion = $r->cvm_sistema_sujecion;
          $cvm_mensual->direccion_hidraulica = $r->cvm_direccion_hidraulica;  
          $cvm_mensual->electrico_luces = $r->cvm_electrico_luces;  
          $cvm_mensual->mecanico_motor = $r->cvm_mecanico_motor;
          $cvm_mensual->neumatico_frenos = $r->cvm_neumatico_frenos;  
          $cvm_mensual->sueldos_taller = $r->cvm_sueldos_taller;
          $cvm_mensual->suspension = $r->cvm_suspension;
          $cvm_mensual->taller_externo = $r->cvm_taller_externo;  
          $cvm_mensual->transmision_diferencial = $r->cvm_transmision_diferencial;  
          $cvm_mensual->total = $r->cvm_total;  

            $cvo_mensual->casetas_peajes = $rcvo_casetas_peajes;
            $cvo_mensual->combustibles = $r->cvo_combustibles;
            $cvo_mensual->facilidades_admin = $r->cvo_facilidades_admin;
            $cvo_mensual->gastos_viajes = $r->cvo_gastos_viaje;
            $cvo_mensual->sueldos_operadores = $r->cvo_sueldos_operadores;
            $cvo_mensual->total = $r->cvo_total;
            $cvo_mensual->margen = $r->cvo_margen;

            $IO_mensual->deducibles = $r->io_deducibles;
            $IO_mensual->gestoria_federales = $r->io_gestoria_federales;
            $IO_mensual->gestoria_otros = $r->io_gestoria_otros;
            $IO_mensual->gestoria_SCT = $r->io_gestoria_sct;
            $IO_mensual->gruas_arrastres = $r->io_gruas_arrastres;
            $IO_mensual->maniobras = $r->io_maniobras;
            $IO_mensual->multas_derechos_suscripciones = $r->io_multas_derechos_suscripciones;
            $IO_mensual->repracion_cristales = $r->io_reparacion_cristales;
            $IO_mensual->total = $r->io_total;

            $cfo_mensual->arrendamiento_unidades = $r->cfo_arrendamiento_unidades;
            $cfo_mensual->corralones = $r->cfo_corralones;
            $cfo_mensual->localizacion = $r->cfo_localizacion;
            $cfo_mensual->multas_derechos_suscripciones = $r->cfo_multas_derechos_suscripciones;
            $cfo_mensual->no_deducibles = $r->cfo_no_deducibles;
            $cfo_mensual->seguros = $r->cfo_seguros;
            $cfo_mensual->sueldos_salarios = $r->cfo_sueldos_salarios;
            $cfo_mensual->sueldos_salarios_cs = $r->cfo_sueldos_salaios_cs;
            $cfo_mensual->telefonia_comunicaciones = $r->cfo_telefonia_comuniaciones;
            $cfo_mensual->uniformes_equipo = $r->cfo_uniformes_equipo;
            $cfo_mensual->total = $r->cfo_total;

            $cfa_menusal->arrendamieto = $r->cfa_arrendamiento;
            $cfa_menusal->cefeteria_despensa = $r->cfa_cafeteria_despensa;
            $cfa_menusal->computo_sistemas = $r->cfa_computo_sistemas;
            $cfa_menusal->eventos_reconocimientos = $r->cfa_eventos_reconocimientos;
            $cfa_menusal->facilidades_administrativas = $r->cfa_facilidades_admin;
            $cfa_menusal->gastos_viajes = $r->cfa_gastos_viaje;
            $cfa_menusal->gastos_medicos = $r->cfa_gastos_medicos;
            $cfa_menusal->impuestos = $r->cfa_impuestos;
            $cfa_menusala->multas_derechos_suscripciones = $r->cfa_multas_derechos_suscripciones;
            $cfa_menusal->papeleria_oficina = $r->cfa_papeleria_oficina;
            $cfa_menusal->reclutamiento_personal = $r->cfa_reclutamiento_personal;
            $cfa_menusal->refacciones = $r->cfa_refacciones;
            $cfa_menusal->seguros = $r->cfa_seguros;
            $cfa_menusal->servicios_ordinarios = $r->cfa_servicios_ordinarios;
            $cfa_menusal->servicios_profesionales = $r->cfa_servicios_profesionales;
            $cfa_menusal->sueldos_salarios = $r->cfa_sueldos_salarios;
            $cfa_menusal->taller_externo = $r->cfa_taller_externo;
            $cfa_menusal->telefonia_comunicaciones = $r->cfa_telefonia_comunicaciones;
            $cfa_menusal->uniformes_equipo = $r->cfa_uniforme_equipo;
            $cfa_menusal->total = $r->cfa_total;

            $cvo->costo;
            $cvo->diesel_final;
            $cvo->precio_diesel;
            $cvo->total_costo_diesel;
            $cvo->costo_autopistas;
            $cvo->sueldos;
            $cvo->otros;

            $cvm->costo;
            $cvm->refaccion_MO;
            $cvm->llantas;

            $io->costo;
            $io->deducibles_otros;

            $cfo->costo;
            $cfo->arrendamietos;
            $cfo->seguros;
            $cfo->carga_social;
            $cfo->otros;

            $cfa->costo;
            $cfa->sueldos;
            $cfa->otros;

            $cf->costo;
            $cf->intereses;
    }

    function FormCotizar()
    {
      $diesel = Diesel::with('periodo')->get();
      foreach ($diesel as $d) {
        $d->periodo = Periodo::find($d->periodo); 
      }
      $clientes = Cliente::all();
      $ciudades = Ciudad::with('estado')->get();
      $estados = Estado::with('ciudades')->get();

      $datos = [
        'diesel'=>$diesel, 
        'clientes'=>$clientes,
        'estados'=>$estados
      ];
      return view('cotizaciones.cotizar', compact('datos'));
    }
}	
