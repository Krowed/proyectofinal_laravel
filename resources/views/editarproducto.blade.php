@extends('layouts.plantilla')

@section('title' , 'Actualizar producto')

@section('content_tituloprincipal')
    <h1 class="m-0">Actualizar producto</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('storeproducto') }}" method="POST">
                @csrf
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="">Nombre de producto</label>
                            <input type="hidden" class="form-control form-control-sm" name="idproducto" value="{{ $producto[0]->idproducto }}">
                            <input type="text" class="form-control form-control-sm" name="nombre_producto" value="{{ $producto[0]->producto }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Código de producto</label>
                            <input type="text" class="form-control form-control-sm" name="codigo_producto" value="{{ $producto[0]->codigo }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Tipo de producto</label>
                            <select name="tipo_producto" id="" class="form-control form-control-sm">
                                @foreach($tipo_productos as $tipo_producto)
                                    @if($tipo_producto->ID_TProd == $producto[0]->idtipoproducto)
                                        <option value="{{ $tipo_producto->ID_TProd }}" selected>{{ $tipo_producto->Nombre_TProd }}</option>
                                    @else
                                        <option value="{{ $tipo_producto->ID_TProd }}">{{ $tipo_producto->Nombre_TProd }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Proveedor</label>
                            <select name="proveedor" id="" class="form-control form-control-sm">
                                @foreach($proveedores as $proveedor)
                                    @if($proveedor->ID_Prov == $producto[0]->idproveedor)
                                        <option value="{{ $proveedor->ID_Prov }}" selected>{{ $proveedor->Nombre_Prov }}</option>
                                    @else
                                        <option value="{{ $proveedor->ID_Prov }}">{{ $proveedor->Nombre_Prov }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Precio de venta</label>
                            <input type="text" class="form-control form-control-sm" name="precio_venta" value="{{ $producto[0]->precio_venta }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Precio de compra</label>
                            <input type="text" class="form-control form-control-sm" name="precio_compra" value="{{ $producto[0]->precio_compra }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Stock actual</label>
                            <input type="text" class="form-control form-control-sm" name="stock_actual" value="{{ $producto[0]->stock_actual }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Stock inicial</label>
                            <input type="text" class="form-control form-control-sm" name="stock_minimo" value="{{ $producto[0]->stock_inicial }}">
                        </div>
                    </div>
                </div>
            <!-- /.card -->
            
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>


      <div class="row">
        <div class="form-group col-md-2">
            <button class="btn btn-sm btn-success btn-block"><i class="fas fa-save"></i> Actualizar</button>
        </div> 

        <div class="form-group col-md-2">
            <a href="{{ route('productos') }}" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times-circle"></i> Cancelar</a>
        </div>
      </div>
    </form>
@endsection
@section('scripts')
    <script>
        $('input[name="fecha_orden"]').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        $('input[name="fecha_entrega"]').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    </script>
@endsection