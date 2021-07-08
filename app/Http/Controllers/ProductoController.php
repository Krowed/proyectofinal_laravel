<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoModel;
use App\Models\TipoProductoModel;
use App\Models\ProveedorModel;

class ProductoController extends Controller
{
    public function index()
    {
        return view('productos');
    }

    public function getProductos()
    {
        $productos  = DB::select("SELECT
                                p.ID_Prod AS idproducto,
                                p.Nombre_Prod as producto,
                                p.Codigo AS codigo,
                                tp.Nombre_TProd AS tipo_producto,
                                proveedor.Nombre_Prov AS proveedor,
                                p.PrecioVent_Prod AS precio_venta,
                                p.PrecioComp_Prod AS precio_compra,
                                p.StockInicial_Prod AS stock_inicial,
                                p.StockActual_Prod AS stock_actual 
                                FROM
                                    producto AS p
                                JOIN proveedor ON proveedor.ID_Prov = p.ID_Prov
                                JOIN tipo_producto as tp ON tp.ID_TProd = p.ID_TProd
                                WHERE p.estado = 1");

        return Datatables()
                ->of($productos)
                ->addIndexColumn()
                ->addColumn('action' , function($productos){
                    $idproducto = $productos->idproducto;
                    $btn        = '<a href="'. route("editarproducto" , $idproducto) .'" class="btn btn-sm btn-warning" style="font-size: 10px"><i class="fas fa-edit"></i></a>
                                    <a href="" class="btn btn-sm btn-danger btn_eliminarproducto" data-idproducto="'. $idproducto .'" style="font-size: 10px"><i class="fas fa-trash-alt"></i></a>';

                    return $btn;
                })->rawColumns(['action'])
                ->make(true);
    }


    public function nuevoproducto()
    {
        $data['tipo_productos']     = TipoProductoModel::get();
        $data['proveedores']        = ProveedorModel::get();
        return view('nuevoproducto' , $data);
    }


    public function editarproducto($idproducto)
    {

        $data['producto']  = DB::select("SELECT
                            p.ID_Prod AS idproducto,
                            p.Nombre_Prod as producto,
                            p.Codigo AS codigo,
                            p.ID_TProd as idtipoproducto,
                            tp.Nombre_TProd AS tipo_producto,
                            proveedor.Nombre_Prov AS proveedor,
                            p.PrecioVent_Prod AS precio_venta,
                            p.PrecioComp_Prod AS precio_compra,
                            p.StockInicial_Prod AS stock_inicial,
                            p.StockActual_Prod AS stock_actual,
                            p.ID_Prov as idproveedor 
                            FROM
                                producto AS p
                            JOIN proveedor ON proveedor.ID_Prov = p.ID_Prov
                            JOIN tipo_producto as tp ON tp.ID_TProd = p.ID_TProd
                            WHERE p.ID_Prod = $idproducto");


        $data['tipo_productos']     = TipoProductoModel::get();
        $data['proveedores']        = ProveedorModel::get();

        return view('editarproducto' , $data);
    }


    public function agregarproducto(Request $request)
    {
        $nombre_producto    = $request->input('nombre_producto');
        $codigo_producto    = $request->input('tipo_producto');
        $tipo_producto      = $request->input('tipo_producto');
        $proveedor          = $request->input('proveedor');
        $precio_venta       = $request->input('precio_venta');
        $precio_compra      = $request->input('precio_compra');
        $stock_actual       = $request->input('stock_actual');
        $stock_minimo       = $request->input('stock_minimo');

        $data_producto      =
        [
            'Nombre_Prod'       => $nombre_producto,
            'Codigo'            => $codigo_producto,
            'ID_TProd'          => $tipo_producto,
            'ID_Prov'           => $proveedor,
            'PrecioVent_Prod'   => $precio_venta,
            'PrecioComp_Prod'   => $precio_compra,
            'StockInicial_Prod' => $stock_actual,
            'StockActual_Prod'  => $stock_minimo
        ];

        ProductoModel::insert($data_producto);
        return redirect(url('productos'))->with('mensaje' , 'Producto agregado');
    }


    public function storeproducto(Request $request)
    {
        $idproducto         = $request->input('idproducto');
        $nombre_producto    = $request->input('nombre_producto');
        $codigo_producto    = $request->input('tipo_producto');
        $tipo_producto      = $request->input('tipo_producto');
        $proveedor          = $request->input('proveedor');
        $precio_venta       = $request->input('precio_venta');
        $precio_compra      = $request->input('precio_compra');
        $stock_actual       = $request->input('stock_actual');
        $stock_minimo       = $request->input('stock_minimo');

        $data_producto      =
        [
            'Nombre_Prod'       => $nombre_producto,
            'Codigo'            => $codigo_producto,
            'ID_TProd'          => $tipo_producto,
            'ID_Prov'           => $proveedor,
            'PrecioVent_Prod'   => $precio_venta,
            'PrecioComp_Prod'   => $precio_compra,
            'StockInicial_Prod' => $stock_actual,
            'StockActual_Prod'  => $stock_minimo
        ];      

        ProductoModel::where('ID_Prod' , $idproducto)->update($data_producto);
        return redirect(url('productos'))->with('mensaje' , 'Registro actualizado');
    }


    public function eliminarproducto(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['estado' => false, 'mensaje' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $idproducto     = $request->input('idproducto');
        
        ProductoModel::where('ID_Prod' , $idproducto)->update(['estado' => 0]);
        echo json_encode(['estado' => true, 'mensaje' => 'Registro eliminado']);
    }


    public function buscarproducto(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['estado' => false, 'mensaje' => 'Algo pasó, intente de nuevo']);
            return;
        }

        $producto   = $request->input('producto');
        $resultado  = ProductoModel::where('Nombre_Prod' , 'LIKE' , "%$producto%")
                                    ->get();

        $response    = [];
        foreach($resultado as $row){
            $response[] = [
                'label'         =>  $row['Nombre_Prod'],
                'precio'        =>  $row['PrecioVent_Prod'],
                'idproducto'    =>  $row['ID_Prod']
            ];
        }
   
        echo json_encode($response);
    }


    public function agregardetalle(Request $request)
    {
        if(!$request->ajax())
        {
            echo json_encode(['estado'  => false, 'mensaje' => 'Algo falló, intente de nuevo']);
            return;
        }

        $idproducto         = $request->input('idproducto');
        $producto           = $request->input('producto');
        $cantidad           = (int) $request->input('cantidad');
        $precio_unitario    = (float) $request->input('precio_unitario');
        $subtotal           = (float) $request->input('subtotal');
        $detalles           = [];

        $detalles[]         = 
        [
            'idproducto'        => $idproducto,
            'producto'          => $producto,
            'cantidad'          => $cantidad,
            'precio_unitario'   => $precio_unitario,
            'subtotal'          => $subtotal
        ];
            
        $request->session()->put('detalles' , $detalles);

        foreach($request->session()->get('detalles') as $index => $detalle)
        {
            if($idproducto == $detalle['idproducto'])
            {
                $detalle['cantidad']    = $detalle['cantidad'] + $cantidad;
                $request->session()->put('detalles.' . $index , $detalle);
                dd($request->session()->get('detalles'));
            }
        }


        $request->session()->push('detalles' , $detalles);
        dd($request->session()->get('detalles'));
        return;
    }   


}
