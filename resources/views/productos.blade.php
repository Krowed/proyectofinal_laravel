@extends('layouts.plantilla')

@section('title' , 'Productos')

@section('content_tituloprincipal')
    <h1 class="m-0">Lista de productos</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <a href="{{ route('nuevoproducto') }}" class="btn btn-primary mb-3"><i class="fas fa-file-alt"></i> Nuevo</a>
                  <table id="table_productos" class="table table-bordered table-striped table-sm">
                    <thead class="text-center">
                    <tr>
                      <th>ID</th>
                      <th>Producto</th>
                      <th>Código</th>
                      <th>Tipo</th>
                      <th>Proveedor</th>
                      <th>P. Venta</th>
                      <th>P. Compra</th>
                      <th>Stock act.</th>
                      <th>Stock min.</th>
                      <th width="8%"></th>
                    </tr>
                    </thead>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

@endsection
@section('scripts')
    <script>
        
        let mensaje     = "{{ session('mensaje') }}",
            base_url    = $('meta[name="base_url"]').attr('content');
        if(mensaje)
        {
          Swal.fire({
            icon: 'success',
            text: mensaje,
            showConfirmButton: false,
            timer: 1500
          });
        }

        $(function () {
          function cargar_datatables()
          {
            let datatable = $('#table_productos').DataTable({
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoPostFix": "",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "loadingRecords": "Cargando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Término de búsqueda",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "aria": {
                        "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    //only works for built-in buttons, not for custom buttons
                    "buttons": {
                        "create": "Nuevo",
                        "edit": "Cambiar",
                        "remove": "Borrar",
                        "copy": "Copiar",
                        "csv": "fichero CSV",
                        "excel": "tabla Excel",
                        "pdf": "documento PDF",
                        "print": "Imprimir",
                        "colvis": "Visibilidad columnas",
                        "collection": "Colección",
                        "upload": "Seleccione fichero...."
                    },
                    "select": {
                        "rows": {
                            _: '%d filas seleccionadas',
                            0: 'clic fila para seleccionar',
                            1: 'una fila seleccionada'
                        }
                    }
                },           
                processing  :true,
                serverSide  :true,
                "paging"    :true,
                "searching" :true,
                "destroy"   :true,
                responsive  :true,
                ordering    :false,
                autoWidth   :false,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "ajax":"{{ route('getProductos') }}",
                "columns":[
                        { data          : "idproducto", className : 'text-center' },
                        { data          : "producto", className : 'text-center' },
                        { data          : "codigo", className : 'text-center' },
                        { data          : "tipo_producto", className : 'text-center' },
                        { data          : "proveedor", className : 'text-center' },
                        { data          : "precio_venta", className : 'text-center' },
                        { data          : "precio_compra", className : 'text-center' },
                        { data          : "stock_actual", className : 'text-center' },
                        { data          : "stock_inicial", className : 'text-center' },
                        {
                            data        : 'action',
                            orderable   : false, 
                            searchable  : false,
                            className   : "text-center"

                        }
                    ],

                });

                return datatable;
            }

          cargar_datatables();


          $('body').on('click' , '.btn_eliminarproducto' , function(e) {
            e.preventDefault();
            let idproducto  = $(this).data('idproducto');
                $.ajax({
                    url         : "{{ route('eliminarproducto') }}",
                    method      : 'POST',
                    data        : {
                        '_token'    : "{{ csrf_token() }}",
                        idproducto  : idproducto
                    },
                    success     : function(r){
                        if(!r.estado)
                        {
                            Swal.fire({
                                icon: 'error',
                                text: r.mensaje,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }

                        else {
                            Swal.fire({
                                icon: 'success',
                                text: r.mensaje,
                                showConfirmButton: false,
                                timer: 1500
                            }).then( () => {
                                cargar_datatables();
                            });
                        }

                    },
                    dataType    : 'json'
                });
          });
        });
  </script>
@endsection