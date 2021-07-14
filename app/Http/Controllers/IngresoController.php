<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompraModel;
use App\Models\IngresoModel;
use App\Models\DetalleIngresoModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class IngresoController extends Controller
{
    public function index()
    {
        return view('ingresos');
    }

    public function nuevoingreso()
    {
        return view('nuevoingreso');
    }

    public function comprobarorden(Request $request)
    {
        if(!$request)
        {
            echo json_encode(['estado' => false, 'mensaje'  => 'Algo pasó, intente de nuevo']);
            return;
        }

        $num_ordencompra    = (int) $request->input('num_ordencompra');
        $orden_compra       = OrdenCompraModel::where('Numero_orden_compra' , $num_ordencompra)->first();


        if(!is_integer($num_ordencompra))
        {
            echo json_encode(['estado' => false, 'mensaje'  => 'Solo se aceptan números']);
            return;
        }

        if($orden_compra == NULL)
        {
            echo json_encode(['estado' => false, 'mensaje'  => 'No se encuentra un numero de órden con el valor ingresado']);
            return;
        }
        echo json_encode(['estado' => true, 'id_ordencompra' => $orden_compra->ID_Ordc]);
    }



    public function registraringreso(Request $request)
    {
        if(!$request)
        {
            echo json_encode(['estado' => false, 'mensaje'  => 'Algo pasó, intente de nuevo']);
            return;
        }

        $numero_serie       = $request->input('numero_serie');
        $fecha_ingreso      = $request->input('fecha_ingreso');
        $id_ordencompra     = $request->input('id_ordencompra');
        $detalle            = $request->input('detalle');

        $data_ingreso       = 
        [
            'Serie'             => $numero_serie,
            'Fecha'             => date('Y-m-d' , strtotime($fecha_ingreso)),
            'Reporte_ingreso'   => ''
        ];

        // Agregamos ingreso
        IngresoModel::insert($data_ingreso);


        // Obtenemos el ultimo ID insertado
        $id_ingreso     = IngresoModel::latest('ID_Ingres')->first()['ID_Ingres'];

        // Agregar detalle
        foreach($detalle as $producto)
        {
            $data_detalle   = 
            [
                'ID_Prod'           => $producto['idproducto'],
                'Cantidad'          => $producto['cantidad'],
                'ID_Ingres'         => $id_ingreso,
                'ID_Ordc'           => $id_ordencompra,
            ];

            DetalleIngresoModel::insert($data_detalle);
        }


        $data['detalles']   = $request->input('detalle');
        $pdf                = PDF::loadView('reporte_ingresos' , $data);
        $nombre_pdf         = date('Y-m-d-H-i-s') . '.pdf';
        $pdf->save( 'uploads/ingresos/' .  $nombre_pdf);


        //Actualizamos el nombre del pdf
        IngresoModel::where('ID_Ingres' , $id_ingreso)->update(['Reporte_ingreso' => $nombre_pdf]);
        echo json_encode(['estado'  => true, 'mensaje' => 'Órden registrada con éxito']);
    }


    public function getIngresos()
    {
        $ingresos   = DB::select("SELECT ingreso.ID_Ingres as id_ingreso, ingreso.Serie as serie,
                                detalle_ingreso.ID_Ordc as orden_compra,
                                ingreso.Reporte_ingreso as reporte,
                                DATE_FORMAT(ingreso.Fecha, '%d-%m-%Y') as fecha_ingreso
                                FROM ingreso
                                JOIN detalle_ingreso on detalle_ingreso.ID_Ingres = ingreso.ID_Ingres");



        return Datatables()
                ->of($ingresos)
                ->addIndexColumn()
                ->addColumn('action' , function($ingresos){
                    $id_ingreso  = $ingresos->id_ingreso;
                    $pdf         = $ingresos->reporte;
                    $btn         = '<a href="'. url('/uploads/ingresos/') . '/' . $pdf .'" target="_blank" class="text-info" data-toggle="tooltip" title="Ver resumen" style="font-size: 20px"><i class="fas fa-file-pdf"></i></a>';

                    return $btn;
                })->rawColumns(['action'])
                ->make(true);
    }

}
