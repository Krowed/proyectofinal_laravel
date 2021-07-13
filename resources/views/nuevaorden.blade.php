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
                                <input type="hidden" name="idproducto" class="form-control form-control-sm">
                                <input id="producto" type="text" class="form-control form-control-sm" name="producto" placeholder="Buscar producto...">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                              </div>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Cantidad</label>
                            <input id="cantidad" type="number" class="form-control form-control-sm" name="cantidad">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">Precio unit.</label>
                            <input type="text" class="form-control form-control-sm" name="precio_unitario">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-primary btn-block btn-sm btn_agregardetalle">Agregar</button>
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
                        <th width="8%"></th>
                    </tr>
                </thead>

                <tbody id="tbody_detalle" class="text-center"></tbody>
            </table>
        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-2">
            <button class="btn btn-sm btn-success btn-block"><i class="fas fa-save"></i> Registrar</button>
        </div> 

        <div class="form-group col-md-2">
            <a href="{{ route('ordenes') }}" class="btn btn-sm btn-danger btn-block"><i class="fas fa-times-circle"></i> Cancelar</a>
        </div>
      </div>
    </form>
@endsection
@section('scripts')
    <script>
        $('input[name="fecha_orden"]').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        $('input[name="fecha_entrega"]').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        $('input[name="producto"]').autocomplete({
            source : function(request , response)
            {
                $.ajax({
                    url         : "{{ route('buscarproducto') }}",
                    method      : 'POST',
                    data        : {
                        '_token' : "{{ csrf_token() }}",
                        producto : request.term

                    },
                    success     : function(data){
                        response(data);
                    },
                    dataType    : 'json'
                });
            },

            minLength : 1,
            select    : function(event , ui){
                $('input[name="producto"]').val(ui.item.label);
                $('input[name="cantidad"]').val(1);
                $('input[name="precio_unitario"]').val(parseFloat(ui.item.precio).toFixed(2));
                $('input[name="idproducto"]').val(ui.item.idproducto);
            }
        });


        $('input[name="cantidad"]').on('change' , function(){
            let cantidad        = parseInt($(this).val());

                if(cantidad <= 0 )
                {
                    cantidad = 1;
                    $('input[name="cantidad"]').val(cantidad);
                }
        });


        $('body').on('click' , '.btn_agregardetalle' , function(e) {
            e.preventDefault();
              let   idproducto      = $('input[name="idproducto"]').val(),
                    producto        = $('input[name="producto"]').val(),
                    cantidad        = parseInt($('input[name="cantidad"]').val()),
                    precio_unitario = parseFloat($('input[name="precio_unitario"]').val()),
                    tbody           = $('#tbody_detalle').html(),
                    subtotal        = (cantidad * precio_unitario),
                    fila            = ''; 

                    if(tbody == '')
                    {
                        fila        += `<tr><td>${idproducto}</td><td>${producto}</td><td>${cantidad}</td><td>${precio_unitario}</td><td>${subtotal}</td><td><a href="" class="text-danger"><i class="fas fa-trash-alt"></i></a</td></tr>`;
                    }

                    else {
                        $.each($('#tbody_detalle tr') , function(index, tr) {
                            let id_td           = $(this).find('td').eq(0).html(),
                                producto_table  = $(this).find('td').eq(1).html(),
                                cantidad        = $(this).find('td').eq(2).html(),
                                precio_u_table  = $(this).find('td').eq(3).html(),
                                subtotal_table  = $(this).find('td').eq(4).html();
                                
                                return;
                        });


                    }

                    fila         += `<tr><td>${idproducto}</td><td>${producto}</td><td>${cantidad}</td><td>${precio_unitario}</td><td>${subtotal}</td><td><a href="" class="text-danger"><i class="fas fa-trash-alt"></i></a</td></tr>`;

                    $('#tbody_detalle').append(fila);                   
        }); 
    </script>
@endsection