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
                            <input type="text" class="form-control form-control-sm" name="numero_ordencompra">
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
                            <label for="estado">Estado</label>
                            <select id="estado" class="form-control form-control-sm" name="estado">
                                <option value="0">Pendiente</option>
                                <option value="1">Entregado</option>
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
            <button class="btn btn-sm btn-success btn-block btn_registrardetalle"><i class="fas fa-save"></i> Registrar</button>
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
        var arreglo         = [];

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

        /*
            Agregar elementos de la tabla
        */
        $('body').on('click' , '.btn_agregardetalle' , function(e) {
            e.preventDefault();
              let   idproducto      = $('input[name="idproducto"]').val(),
                    producto        = $('input[name="producto"]').val(),
                    cantidad        = parseInt($('input[name="cantidad"]').val()),
                    precio_unitario = parseFloat($('input[name="precio_unitario"]').val()),
                    subtotal        = (cantidad * precio_unitario),
                    subt            = 0,
                    fila            = '',
                    comprobar       = 0,
                    canti           = 0;
                    indexarray      = 0;
                    detalle         = {
                        idproducto : idproducto,
                        producto : producto,
                        cantidad : cantidad,
                        precio_unitario : precio_unitario
                    }; 

                    
                    arreglo.forEach((elemento,index) => 
                    {
                        if(elemento.idproducto == idproducto)
                        {
                            indexarray= index; 
                            comprobar=1;
                        }
                    });
                    
                    if(comprobar == 1)
                    {
                        $.each($('#tbody_detalle tr') , function(index , product) {
                            if($(this).find('td').eq(0).html() == idproducto){
                                canti = parseInt($(this).find('td').eq(2).html()) + 1;
                                subt  = parseInt($(this).find('td').eq(4).html()) * canti;
                                $(this).find('td').eq(2).html(canti);
                                $(this).find('td').eq(4).html(subt);
                            }
                        });

                        arreglo[indexarray].cantidad = parseInt(arreglo[indexarray].cantidad) + 1;
                    }
                    
                    else {
                       fila        += `<tr><td>${idproducto}</td><td>${producto}</td><td class="valor_cantidad">${cantidad}</td><td>${precio_unitario}</td><td>${subtotal}</td><td><a href="" data-idproducto="${idproducto}" class="text-danger eliminartd"><i class="fas fa-trash-alt"></i></a</td></tr>`; 

                        arreglo.push(detalle);
                    }
                    
                    $('#tbody_detalle').append(fila);                   
        }); 


        /*
            Eliminar los elementos de la tabla
        */

        $('body').on('click' , '.eliminartd' , function(e) {
            e.preventDefault();
            let idproducto  = $(this).data('idproducto');
                $.each($('#tbody_detalle tr') , function(index , product) {
                    if($(this).find('td').eq(0).html() == idproducto)
                    {
                        $('input[name="producto"]').val('');
                        $('input[name="cantidad"]').val('');
                        $('input[name="precio_unitario"]').val('');
                        $(this).remove();
                    }
                });

                arreglo.forEach((elemento,index) => 
                {
                    if(elemento.idproducto == idproducto)
                    {
                        arreglo.splice(index , 1);
                    }
                });
        });


        /*
            Procesar elementos para agregar al detalle
        */
        $('body').on('click' , '.btn_registrardetalle' , function(e) {
            e.preventDefault();
            let num_ordencompra     = $('input[name="numero_ordencompra"]').val(),
                fecha_orden         = $('input[name="fecha_orden"]').val(),
                fecha_entrega       = $('input[name="fecha_entrega"]').val(),
                estado              = $('select[name="estado"]').val(),
                detalle             = arreglo;


                $.ajax({
                    url             : "{{ route('registrarorden') }}",
                    method          : 'POST',
                    data            : {
                       '_token'         : "{{ csrf_token() }}",
                       num_ordencompra  : num_ordencompra,
                       fecha_orden      : fecha_orden,
                       fecha_entrega    : fecha_entrega,
                       estado           : estado,
                       detalle          : detalle
                    },
                    success         : function(r){
                        if(!r.mensaje)
                        {
                            Swal.fire({
                                icon: 'error',
                                text: r.mensaje,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                        Swal.fire({
                                icon: 'success',
                                text: r.mensaje,
                                showConfirmButton: false,
                                timer: 1500
                            }).then( () => {
                                window.location.href = 'ordenes';
                            });
                    },
                    dataType        : 'json'
                });
                return;
        });
    </script>
@endsection