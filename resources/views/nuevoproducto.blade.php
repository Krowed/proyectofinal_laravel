@extends('layouts.plantilla')

@section('title' , 'Nuevo producto')

@section('content_tituloprincipal')
    <h1 class="m-0">Registrar nuevo producto</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('agregarproducto') }}" method="POST">
                @csrf
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label for="">Nombre de producto</label>
                            <input type="text" class="form-control form-control-sm" name="nombre_producto">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Código de producto</label>
                            <input type="text" class="form-control form-control-sm" name="codigo_producto">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Tipo de producto</label>
                            <select name="tipo_producto" id="" class="form-control form-control-sm">
                                <option value="">[SELECCIONE]</option>
                                @foreach($tipo_productos as $tipo_producto)
                                    <option value="{{ $tipo_producto->ID_TProd }}">{{ $tipo_producto->Nombre_TProd }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Proveedor</label>
                            <select name="proveedor" id="" class="form-control form-control-sm">
                                <option value="">[SELECCIONE]</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->ID_TProv }}">{{ $proveedor->Nombre_Prov }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Precio de venta</label>
                            <input type="text" class="form-control form-control-sm" name="precio_venta">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Precio de compra</label>
                            <input type="text" class="form-control form-control-sm" name="precio_compra">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Stock actual</label>
                            <input type="text" class="form-control form-control-sm" name="stock_actual">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="">Stock mínimo</label>
                            <input type="text" class="form-control form-control-sm" name="stock_minimo">
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
            <button class="btn btn-sm btn-success btn-block"><i class="fas fa-save"></i> Registrar</button>
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