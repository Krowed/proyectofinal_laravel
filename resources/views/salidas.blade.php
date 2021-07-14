@extends('layouts.plantilla')

@section('title' , 'Salidas')

@section('content_tituloprincipal')
    <h1 class="m-0">Salidas</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <a href="{{ route('nuevasalida') }}" class="btn btn-primary mb-3"><i class="fas fa-file-alt"></i> Nuevo</a>
                  <table id="table_salidas" class="table table-bordered table-striped table-sm">
                    <thead class="text-center">
                    <tr>
                      <th>ID</th>
                      <th>Num. serie</th>
                      <th>Usuario</th>
                      <th>Fecha salida</th>
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
        $(document).ready(function() {

            function cargar_datatables()
          {
            let datatable = $('#table_salidas').DataTable({
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
                "ajax":"{{ route('getSalidas') }}",
                "columns":[
                        { data          : "idsalida", className : 'text-center' },
                        { data          : "numero_serie", className : 'text-center' },
                        { data          : "usuario", className : 'text-center' },
                        { data          : "fecha_salida", className : 'text-center' },
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

        });
    </script>
@endsection