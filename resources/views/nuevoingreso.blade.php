@extends('layouts.plantilla')

@section('title' , 'Nuevo ingreso')

@section('content_tituloprincipal')
    <h1 class="m-0">Nuevo ingreso</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body row">
                        <div class="form-group col-md-4">
                            <label for="">Num. serie</label>
                            <input type="text" class="form-control form-control-sm" name="numero_serie">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Fecha de ingreso</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="fecha_ingreso">

                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Num. órden compra</label>
                            <div class="input-group input-group-sm mb-3">
                              <input type="hidden" class="form-control" name="id_ordencompra">
                              <input type="text" class="form-control" name="numero_ordencompra">
                              <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat btn_validar">Validar</button>
                              </span>
                              <div id="span_validar"></div>
                            </div>
                        </div>      
                    </div>
                </div>

                <div class="card">
                    <div class="card-body row">
                        <div class="form-group col-md-4">
                            <label for="">Producto</label>
                            <div class="input-group input-group-sm mb-3">
                                <input type="hidden" name="idproducto" class="form-control form-control-sm">
                                <input id="producto" type="text" class="form-control form-control-sm" name="producto" placeholder="Buscar producto...">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                              </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">Cantidad</label>
                            <input id="cantidad" type="number" class="form-control form-control-sm" name="cantidad">
                        </div>

                        <div class="form-group col-md-4">
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
            <h3 class="m-0">Detalle de salida</h3>
            <table class="table table-bordered table-striped table-sm">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
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
        $('input[name="fecha_ingreso"]').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        var arreglo         = [];
        $('.btn_agregardetalle').prop('disabled' , true);

        $('input[name="numero_ordencompra"]').on('keyup' , function() {
            let valor = $(this).val();

            if(valor == '')
            {
                $('.btn_agregardetalle').prop('disabled' , true);
                return;
            }
        });        
        //$('#input_validar').after('<span class="text-danger"><small>No se encuentra un numero de órden con el valor ingresado</small></span>');

        $('.btn_validar').on('click' , function(e) {
            e.preventDefault();
            let num_ordencompra = $('input[name="numero_ordencompra"]').val();

            if(num_ordencompra == '')
            {
                $('.btn_agregardetalle').prop('disabled' , true);
                return;
            }

                $.ajax({
                    url         :   "{{ route('comprobarorden') }}",
                    method      : 'POST',
                    data        : {
                        '_token'        : "{{ csrf_token() }}",
                        num_ordencompra : num_ordencompra
                    },
                    success     : function(r){
                        if(!r.estado)
                        {
                            $('#span_validar').html(`<span class="text-danger span_orden">${r.mensaje}<small></small></span>`);
                            $('.btn_agregardetalle').prop('disabled' , true);
                            return;
                        }

                        $('.span_orden').remove();
                        $('.btn_agregardetalle').prop('disabled' , false);
                        $('input[name="id_ordencompra"]').val(r.id_ordencompra);
                    },
                    dataType    : 'json'
                });
                return;
        });


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
                    fila            = '',
                    comprobar       = 0,
                    canti           = 0;
                    indexarray      = 0;
                    detalle         = {
                        idproducto  : idproducto,
                        producto    : producto,
                        cantidad    : cantidad
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
                                $(this).find('td').eq(2).html(canti);
                            }
                        });

                        arreglo[indexarray].cantidad = parseInt(arreglo[indexarray].cantidad) + 1;
                    }
                    
                    else {
                       fila        += `<tr><td>${idproducto}</td><td>${producto}</td><td class="valor_cantidad">${cantidad}</td><td><a href="" data-idproducto="${idproducto}" class="text-danger eliminartd"><i class="fas fa-trash-alt"></i></a</td></tr>`; 

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
            let numero_serie        = $('input[name="numero_serie"]').val(),
                id_ordencompra      = $('input[name="id_ordencompra"]').val(),
                fecha_ingreso       = $('input[name="fecha_ingreso"]').val(),
                detalle             = arreglo;


                $.ajax({
                    url             : "{{ route('registraringreso') }}",
                    method          : 'POST',
                    data            : {
                       '_token'         : "{{ csrf_token() }}",
                       numero_serie     : numero_serie,
                       id_ordencompra   : id_ordencompra,
                       fecha_ingreso    : fecha_ingreso,
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
                                window.location.href = 'ingresos';
                            });
                    },
                    dataType        : 'json'
                });
                return;
        });
    </script>
@endsection