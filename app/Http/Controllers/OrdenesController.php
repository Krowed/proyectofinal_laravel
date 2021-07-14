<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenCompraModel;
use App\Models\DetalleCompraModel;
use Barryvdh\DomPDF\Facade as PDF;

class OrdenesController extends Controller
{
    public function index()
    {
        return view('ordenes');
    }


    public function nuevaorden()
    {
        return view('nuevaorden');
    }

    public function registrarorden(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['estado'  => false, 'mensaje' => 'Ups, intente de nuevo']);
            return;
        }

        $num_ordencompra    = $request->input('num_ordencompra');
        $fecha_orden        = date('Y-m-d' , strtotime($request->input('fecha_orden')));
        $fecha_entrega      = date('Y-m-d' , strtotime($request->input('fecha_entrega')));
        $estado             = (int) $request->input('estado');
        $detalle            = $request->input('detalle');



        $data_orderncompra  = 
        [
            'Numero_orden_compra'   => $num_ordencompra,
            'FechaOrden_Ordc'       => $fecha_orden,
            'FechaEntrega_Ordc'     => $fecha_entrega,
            'Estado'                => $estado,
            'ID_Empl'               => session('usuario')['idusuario'],
            'Reporte_orden'         => ''
        ];


        // Agregar orden
        OrdenCompraModel::insert($data_orderncompra);

        // Obtenemos el ultimo ID insertado
        $id_ordencompra     = OrdenCompraModel::latest('ID_Ordc')->first()['ID_Ordc'];

       
        // Agregar detalle
        foreach($detalle as $producto)
        {
            $data_detalle   = 
            [
                'Producto'          => $producto['producto'],
                'Precio_Unitario'   => $producto['precio_unitario'],
                'Cantidad'          => $producto['cantidad'],
                'Total'             => ($producto['precio_unitario'] * $producto['cantidad']),
                'ID_Ordc'           => $id_ordencompra,
                'ID_Prod'           => $producto['idproducto']
            ];

            DetalleCompraModel::insert($data_detalle);
        }

        $data['detalles']   = $request->input('detalle');
        $pdf                = PDF::loadView('reporte_ordenes' , $data);
        $nombre_pdf         = date('Y-m-d-H-i-s') . '.pdf';
        $pdf->save( 'uploads/ordenes/' .  $nombre_pdf);

        //Actualizamos el nombre del pdf
        OrdenCompraModel::where('ID_Ordc' , $id_ordencompra)->update(['Reporte_orden' => $nombre_pdf]);
        echo json_encode(['estado'  => true, 'mensaje' => 'Órden registrada con éxito']);
    }


    public function pruebapdf()
    {
        $pdf                = PDF::loadView('pruebapdf');
        return $pdf->stream();
    }


    public function getOrdenes()
    {

        $ordenes    = DB::select("SELECT oc.ID_Ordc AS idorden,
                                    oc.Numero_orden_compra as numero_serie,
                                    usuario.Usuario AS empleado,
                                    DATE_FORMAT(oc.FechaOrden_Ordc, '%d-%m-%Y') AS fecha_emision,
                                    DATE_FORMAT(oc.FechaEntrega_Ordc, '%d-%m-%Y')  AS fecha_entrega,
                                    oc.Reporte_orden as reporte,
                                CASE
                                    oc.Estado 
                                    WHEN 0 THEN
                                    'PENDIENTE' 
                                    WHEN 1 THEN
                                    'ENTREGADO' 
                                    END AS estado,
                                    SUM( detalle_compra.Total ) AS total 
                                FROM orden_compra AS oc
                                    JOIN usuario ON usuario.ID_Usuario = oc.ID_Empl
                                    JOIN detalle_compra ON detalle_compra.ID_Ordc = oc.ID_Ordc
                                GROUP BY idorden, numero_serie, empleado, fecha_emision, fecha_entrega, estado, reporte");

        return Datatables()
                ->of($ordenes)
                ->addIndexColumn()
                ->addColumn('action' , function($ordenes){
                    $idorden    = $ordenes->idorden;
                    $estado     = $ordenes->estado;
                    $pdf        = $ordenes->reporte;
                    if($estado == 'ENTREGADO')
                    {
                        $btn        = '<a href="'. url('/uploads/ordenes/') . '/' . $pdf .'" target="_blank" class="text-info" data-toggle="tooltip" title="Ver resumen" style="font-size: 20px"><i class="fas fa-file-pdf"></i></a> <input type="checkbox" class="align-middle btn_actualizarorden" data-check="1" checked data-idorden="'. $idorden .'">';
                    } else {
                        $btn        = '<a href="'. url('/uploads/ordenes/') . '/' . $pdf .'" target="_blank" class="text-info" data-toggle="tooltip" title="Ver resumen" style="font-size: 20px"><i class="fas fa-file-pdf"></i></a> <input type="checkbox" class="align-middle btn_actualizarorden" data-check="0" data-idorden="'. $idorden .'">';
                    }

                    return $btn;
                })->rawColumns(['action'])
                ->make(true);
    }


    public function actualizarorden(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['estado'  => false, 'mensaje' => 'Ups, intente de nuevo']);
            return;
        }

        $check      = ($request->input('check') == '0') ? '1' : '0';
        $idorden    = $request->input('idorden');

        OrdenCompraModel::where('ID_Ordc' , $idorden)->update(['estado' => $check]);
        echo json_encode(['estado'  => true, 'mensaje'  => 'Órden actualizada correctamente']);
    }

}
