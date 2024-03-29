<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cotizacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Diesel;
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

class CalculosController extends Controller
{
    public static function PromediosMensuales()
    {
    	//$date = '2019-05-12';
    	//return Carbon::parse($date)->format('m');
        $cotis =  Reporte_mensual::with('cfa_mensual')->with('io_mensual')->with('cfo_mensual')->with('cvm_mensual')->with('cvo_mensual')->with('diesel')->where('año', '=', '2019')->orderby('mes')->get();

        $coti_meses = collect([]);
        $coti_meses['Enero'] = collect([]);
        $coti_meses['Febrero'] = collect([]);
        $coti_meses['Marzo'] = collect([]);
        $coti_meses['Abril'] = collect([]);
        $coti_meses['Mayo'] = collect([]);
        $coti_meses['Junio'] = collect([]);
        $coti_meses['Julio'] = collect([]);
        $coti_meses['Agosto'] = collect([]);
        $coti_meses['Septiembre'] = collect([]);
        $coti_meses['Octubre'] = collect([]);
        $coti_meses['Noviembre'] = collect([]);
        $coti_meses['Diciembre'] = collect([]);

        
        foreach ($cotis as $coti) {
            $mes = $coti->mes;

            switch ($mes) {
                case 01:
                    $coti_meses['Enero']->push($coti);
                    break;
                case 02:
                    $coti_meses['Febrero']->push($coti);
                    break;
                case 03:
                    $coti_meses['Marzo']->push($coti);
                    break;
                case 04:
                    $coti_meses['Abril']->push($coti);
                    break;
                case 05:
                    $coti_meses['Mayo']->push($coti);
                    break;
                case 06:
                    $coti_meses['Junio']->push($coti);
                    break;
                case 07:
                    $coti_meses['Julio']->push($coti);
                    break;
                case '08':
                    $coti_meses['Agosto']->push($coti);
                    break;
                case '09':
                    $coti_meses['Septiembre']->push($coti);
                    break;
                case '10':
                    $coti_meses['Octubre']->push($coti);
                    break;
                case '11':
                    $coti_meses['Noviembre']->push($coti);
                    break;
                case '12':
                    $coti_meses['Diciembre']->push($coti);
                    break;
            }
        }
        unset($cotis);

        foreach ($coti_meses as $coti2) {
            foreach ($coti2 as $coti) {
                $coti->diesel = Diesel::find($coti->diesel);
                $coti->cfa_mensual =CFA_mensual::find($coti->cfa_mensual);
                $coti->cfo_mensual = CFO_mensual::find($coti->cfo_mensual);
                $coti->cvm_mensual = CVM_mensual::find($coti->cvm_mensual);
                $coti->cvo_mensual = CVO_mensual::find($coti->cvo_mensual);
                $coti->io_mensual = IO_mensual::find($coti->io_mensual);
            }
        }

        return $coti_meses;
    }

    public static function PromedioAnual($op,$año)
    {
        $cotis =  Reporte_mensual::with('cfa_mensual')->with('io_mensual')->with('cfo_mensual')->with('cvm_mensual')->with('cvo_mensual')->with('diesel')->where('año', '=', $año)->get();


        $datos = new Reporte_mensual();
        $cvo = new CVO_mensual();
        $cfa = new CFA_mensual();
        $cfo = new CFO_mensual();
        $io = new IO_mensual();
        $cvm = new CVM_mensual();
        $diesel = new Diesel();

        if ($op == 1) {
            $div = 1;
        }
        else {
            $div = $cotis->count();
        }

        /*Problema con el with()*/
        foreach ($cotis as $coti) {
            $coti->diesel = Diesel::find($coti->diesel);
            $coti->cfa_mensual =CFA_mensual::find($coti->cfa_mensual);
            $coti->cfo_mensual = CFO_mensual::find($coti->cfo_mensual);
            $coti->cvm_mensual = CVM_mensual::find($coti->cvm_mensual);
            $coti->cvo_mensual = CVO_mensual::find($coti->cvo_mensual);
            $coti->io_mensual = IO_mensual::find($coti->io_mensual);

            $datos->sueldo_km += $coti->sueldo_km/$div;
            $datos->unidades_pagadas += $coti->unidades_pagadas/$div;
            $datos->viajes_mes += $coti->viajes_mes/$div;
            $datos->kms_unidad += $coti->kms_unidad/$div;
            $datos->viajes_unidad += $coti->viajes_unidad/$div;
            $datos->distancia_viaje += $coti->distancia_viaje/$div;
            $datos->venta_viaje += $coti->ventas_viaje/$div;
            $datos->fletes += $coti->total_ingreso/$div;
            $datos->incremento_casetas += $coti->incremento_casetas/$div;
            $datos->kms_mensuales += $coti->kms_mensuales/$div; 
            $datos->unidades_operativas += $coti->unidades_operativas/$div;
            $datos->total_costos_variables += $coti->total_costos_variables/$div;
            $datos->total_fijos_administracion += $coti->total_fijos_administracion/$div;
            $datos->uafirda += $coti->uafirda/$div;
            $datos->depreciaciones += $coti->depreciaciones/$div;
            $datos->costo_financiero += $coti->costo_financiero/$div;
            $datos->total_depreciacion_financiero += $coti->total_depreciacion_financiero/$div;
            $datos->uafir += $coti->uafir/$div;
            $datos->otros_ingresos += $coti->otros_ingresos/$div;
            $datos->productos_financieros += $coti->productos_financieros/$div;
            $datos->otros_gastos += $coti->otros_gastos/$div;
            $datos->utilidades_antes_impuestos += $coti->utilidades_antes_impuestos/$div;
            $datos->estrategia_fiscal += $coti->estrategia_fiscal/$div;
            $datos->otros_ingresos_uti += $coti->otros_ingresos_uti/$div;
            $datos->utilidades_despues_reinversion += $coti->utilidades_despues_reinversion/$div;

            $cvo->casetas_peajes += $coti->cvo_mensual->casetas_peajes/$div;
            $cvo->combustibles += $coti->cvo_mensual->combustibles/$div;
            $cvo->facilidades_admin = $coti->cvo_mensual->facilidades_admin/$div;
            $cvo->gastos_viaje += $coti->cvo_mensual->gastos_viaje/$div;
            $cvo->sueldos_operadores += $coti->cvo_mensual->sueldos_operadores/$div;
            $cvo->total += $coti->cvo_mensual->total/$div;
            $cvo->margen += $coti->cvo_mensual->margen/$div;

            $cvm->accesorios += $coti->cvm_mensual->accesorios/$div;
            $cvm->alineacion_balanceo += $coti->cvm_mensual->alineacion_balanceo/$div;
            $cvm->carroceria_pintura += $coti->cvm_mensual->carroceria_pintura/$div;
            $cvm->con_mar_tor += $coti->cvm_mensual->con_mar_tor/$div;
            $cvm->facilidades_admin += $coti->cvm_mensual->facilidades_administrativas/$div;
            $cvm->filtros += $coti->cvm_mensual->filtros/$div;
            $cvm->imagen_unidades += $coti->cvm_mensual->imagen_unidades/$div;
            $cvm->insumos_taller += $coti->cvm_mensual->insumos_taller/$div;
            $cvm->lavados_equipo += $coti->cvm_mensual->lavados_equipo/$div;
            $cvm->llantas += $coti->cvm_mensual->llantas/$div;
            $cvm->lubricantes_grasa += $coti->cvm_mensual->lubricantes_grasa/$div;
            $cvm->mano_obra += $coti->cvm_mensual->mano_obra/$div;
            $cvm->mantenimiento_preventivo += $coti->cvm_mensual->mantenimiento_preventivo/$div;
            $cvm->montaje_desmontaje += $coti->cvm_mensual->montaje_desmontaje/$div;
            $cvm->refacciones += $coti->cvm_mensual->refacciones/$div;
            $cvm->aire_acondicionado += $coti->cvm_mensual->aire_acondicionado/$div;
            $cvm->sistema_enfriamiento += $coti->cvm_mensual->sistema_enfriamiento/$div;
            $cvm->sistema_sujecion += $coti->cvm_mensual->sistema_sujecion/$div;
            $cvm->direccion_hidraulica += $coti->cvm_mensual->direccion_hidraulica/$div;
            $cvm->electrico_luces += $coti->cvm_mensual->electrico_luces/$div;
            $cvm->mecanico_motor += $coti->cvm_mensual->mecanico_motor/$div;
            $cvm->neumatico_frenos += $coti->cvm_mensual->neumatico_frenos/$div;
            $cvm->sueldos_taller += $coti->cvm_mensual->sueldos_taller/$div;
            $cvm->suspension += $coti->cvm_mensual->suspension/$div;
            $cvm->taller_externo += $coti->cvm_mensual->taller_externo/$div;
            $cvm->transmision_diferencial += $coti->cvm_mensual->transmision_diferencial/$div;
            $cvm->total += $coti->cvm_mensual->total/$div;

            $io->deducibles += $coti->io_mensual->deducibles/$div;
            $io->gestoria_federales += $coti->io_mensual->gestoria_federales/$div;
            $io->gestoria_otros += $coti->io_mensual->gestoria_otros/$div;
            $io->gestoria_SCT += $coti->io_mensual->gestoria_SCT/$div;
            $io->gruas_arrastres += $coti->io_mensual->gruas_arrastres/$div;
            $io->maniobras += $coti->io_mensual->maniobras/$div;
            $io->multas_derechos_suscripciones += $coti->io_mensual->multas_derechos_suscripciones/$div;
            $io->reparacion_cristales += $coti->io_mensual->reparacion_cristales;
            $io->total += $coti->io_mensual->total/$div;


            $cfo->arrendamiento_unidades += $coti->cfo_mensual->arrendamiento_unidades/$div;
            $cfo->corralones += $coti->cfo_mensual->corralones/$div;
            $cfo->localizacion += $coti->cfo_mensual->localizacion/$div;
            $cfo->multas_derechos_suscripciones += $coti->cfo_mensual->multas_derechos_suscripciones/$div;
            $cfo->no_deducibles += $coti->cfo_mensual->no_deducibles/$div;
            $cfo->seguros += $coti->cfo_mensual->seguros/$div;
            $cfo->sueldos_salarios += $coti->cfo_mensual->sueldos_salarios/$div;
            $cfo->sueldos_salarios_cs += $coti->cfo_mensual->sueldos_salarios_cs/$div;
            $cfo->telefonia_comunicaciones += $coti->cfo_mensual->telefonia_comunicaciones/$div;
            $cfo->uniformes_equipo += $coti->cfo_mensual->uniformes_equipo/$div;
            $cfo->total += $coti->cfo_mensual->total/$div;

            $cfa->arrendamiento += $coti->cfa_mensual->arrendamiento/$div;
            $cfa->cafeteria_despensa += $coti->cfa_mensual->cafeteria_despensa/$div;
            $cfa->computo_sistemas += $coti->cfa_mensual->computo_sistemas/$div;
            $cfa->eventos_reconocimientos += $coti->cfa_mensual->eventos_reconocimientos/$div;
            $cfa->facilidades_administrativas += $coti->cfa_mensual->facilidades_administrativas/$div;
            $cfa->gastos_viaje += $coti->cfa_mensual->gastos_viaje/$div;
            $cfa->gastos_medicos += $coti->cfa_mensual->gastos_medicos/$div;
            $cfa->impuestos += $coti->cfa_mensual->impuestos/$div;
            $cfa->multas_derechos_suscripciones += $coti->cfa_mensual->multas_derechos_suscripciones/$div;
            $cfa->papeleria_oficina += $coti->cfa_mensual->papeleria_oficina/$div;
            $cfa->reclutamiento_personal += $coti->cfa_mensual->reclutamiento_personal/$div;
            $cfa->refacciones += $coti->cfa_mensual->refacciones/$div;
            $cfa->seguros += $coti->cfa_mensual->seguros/$div;
            $cfa->servicios_ordinarios += $coti->cfa_mensual->servicios_ordinarios/$div;
            $cfa->servicios_profesionales += $coti->cfa_mensual->servicios_profesionales/$div;
            $cfa->sueldos_salarios += $coti->cfa_mensual->sueldos_salarios/$div;
            $cfa->taller_externo += $coti->cfa_mensual->taller_externo/$div;
            $cfa->telefonia_comunicaciones += $coti->cfa_mensual->telefonia_comunicaciones/$div;
            $cfa->uniformes_equipos += $coti->cfa_mensual->uniformes_equipos/$div;
            $cfa->total += $coti->cfa_mensual->total/$div;

            $diesel->precio += $coti->diesel->precio/$div;
            $diesel->iva += $coti->diesel->iva/$div;
            $diesel->precio_iva += $coti->diesel->precio_iva/$div;
        }
        $datos->cvo = $cvo;
        $datos->cvm = $cvm;
        $datos->io = $io;
        $datos->cfo = $cfo;
        $datos->cfa = $cfa;
        $datos->diesel = $diesel;
        
        return $datos;
    }

    public static function PromedioDiario($fecha)
    {

    }

    public static function AcumuladoCostos($fecha)
    {
        $fecha =  explode( '-', $fecha);
        $cotis = Cotizacion::whereMonth('fecha', $fecha[1])->whereYear('fecha', $fecha[0])->with('cf')->with('cfa')->with('cfo')->with('cvm')->with('cvo')->with('io')->get();
        $cf = new CF();
        $cfa = new CFA();
        $cfo = new CFO();
        $cvm = new CVM();
        $cvo = new CVO();
        $io = new IO();

        foreach ($cotis as $coti) {
            $coti->cvo->precio_diesel = Diesel::all()->where('id', '=', $coti->cvo->precio_diesel)->first();
            $cvo->total_diesel += $coti->cvo->total_costo_diesel;
            $cvo->autopistas += $coti->cvo->costo_autopistas;
            $cvo->sueldo += $coti->cvo->sueldo;
            $cvo->otros += $coti->cvo->otros;

            $cvm->refaccion_mo += $coti->cvm->refaccion_MO;
            $cvm->llantas += $coti->cvm->llantas;

            $io->deducibles_otros += $coti->io->deducibles_otros;

            $cfo->arrendamientos += $coti->cfo->arrendamientos;
            $cfo->seguros += $coti->cfo->seguros;
            $cfo->carga_social += $coti->cfo->carga_social;
            $cfo->otros += $coti->cfo->otros;

            $cfa->sueldos_salarios += $coti->cfa->sueldos;
            $cfa->otros +=  $coti->cfa->otros;
        }

        return ['cvo' => $cvo, 'cvm'=>$cvm, 'io'=>$io, 'cfo'=>$cfo, 'cfa'=>$cfa];
    }
}
