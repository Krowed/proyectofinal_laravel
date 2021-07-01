@extends('layouts.plantilla')

@section('title' , 'Home')

@section('content_tituloprincipal')
    <h1 class="m-0">Nueva orden de compra</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="form-group col-md-3">
                            <label for="">Num. órden de compra</label>
                            <input type="text" class="form-control form-control-sm" name="numero_orden_compra">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Fecha de órden</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fecha_orden">

                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Fecha de entrega</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fecha_entrega">
                                
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Estado</label>
                            <select name="" id="" class="form-control form-control-sm" name="estado">
                                <option value="">Pendiente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-md-3">
                            <label for="">Producto</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="text" class="form-control form-control-sm" placeholder="Buscar producto...">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                              </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Cantidad</label>
                            <input type="text" class="form-control form-control-sm" name="cantidad">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Precio unit.</label>
                            <input type="text" class="form-control form-control-sm" name="precio_unitario">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-primary btn-block btn-sm">Agregar</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>



      <div class="row card">
        <div class="col-12 card-body">
            <h3 class="m-0">Detalle de órden de compra</h3>
            <table class="table table-bordered table-striped table-sm">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio unit.</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    <tr>
                        <td>01</td>
                        <td>Producto01</td>
                        <td>2</td>
                        <td>133</td>
                        <td>200</td>
                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-2">
            <button class="btn btn-sm btn-success btn-block"><i class="fas fa-save"></i> Registrar</button>
        </div> 

        <div class="form-group col-md-2">
            <button class="btn btn-sm btn-danger btn-block"><i class="fas fa-times-circle"></i> Cancelar</button>
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