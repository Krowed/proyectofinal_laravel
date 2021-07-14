<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalidasModel;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleSalidasModel;
use Barryvdh\DomPDF\Facade as PDF;

class SalidaController extends Controller
{
    public function index()
    {
        return view('salidas');
    }

    public function nuevasalida()
    {
        return view('nuevasalida');
    }


    public function registrarsalida(Request $request)
    {   
        if(!$request->ajax())
        {
            echo json_encode(['estado'  => false, 'mensaje' => 'Ups, intente de nuevo']);
            return;
        }

        $numero_serie       = $request->input('numero_serie');
        $fecha_salida       = date('Y-m-d' , strtotime($request->input('fecha_salida')));
        $detalle            = $request->input('detalle');

        $data_salida        = 
        [
            'Fecha'         => $fecha_salida,
            'Serie'         => $numero_serie,
            'Usuario'       => session('usuario')['idusuario'],
            'Reporte_salida'=> ''
        ];

        // Agregar salida
        SalidasModel::insert($data_salida);

        // Obtenemos el ultimo ID insertado
        $id_salida     = SalidasModel::latest('ID_Salid')->first()['ID_Salid'];

        // Agregar detalle
        foreach($detalle as $producto)
        {
            $data_detalle   = 
            [
                'ID_Prod'           => $producto['idproducto'],
                'ID_Salid'          => $id_salida,
                'Cantidad'          => $producto['cantidad']
            ];

            DetalleSalidasModel::insert($data_detalle);
        }

        $data['detalles']   = $request->input('detalle');
        $pdf                = PDF::loadView('reporte_salidas' , $data);
        $nombre_pdf         = date('Y-m-d-H-i-s') . '.pdf';
        $pdf->save( 'uploads/salidas/' .  $nombre_pdf);


        //Actualizamos el nombre del pdf
        SalidasModel::where('ID_Salid' , $id_salida)->update(['Reporte_salida' => $nombre_pdf]);
        echo json_encode(['estado'  => true, 'mensaje' => 'Órden registrada con éxito']);
    }


    public function getSalidas()
    {
        $salidas    = DB::select("SELECT 
                                salida.ID_Salid as idsalida,
                                salida.Serie as numero_serie,
                                usuario.Usuario as usuario,
                                salida.Reporte_salida as reporte,
                                DATE_FORMAT(salida.Fecha, '%d-%m-%Y') AS fecha_salida
                                FROM salida
                                JOIN usuario on usuario.ID_Usuario = salida.Usuario");

        return Datatables()
                ->of($salidas)
                ->addIndexColumn()
                ->addColumn('action' , function($salidas){
                    $idsalida    = $salidas->idsalida;
                    $pdf         = $salidas->reporte;
                    $btn         = '<a href="'. url('/uploads/salidas/') . '/' . $pdf .'" target="_blank" class="text-info" data-toggle="tooltip" title="Ver resumen" style="font-size: 20px"><i class="fas fa-file-pdf"></i></a>';

                    return $btn;
                })->rawColumns(['action'])
                ->make(true);
    }


}
