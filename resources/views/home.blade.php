@extends('layouts.plantilla')

@section('title' , 'Home')

@section('content_tituloprincipal')
    <h1 class="m-0">Sistema de inventario Global Tec</h1>
    <span class="text-muted">¡Bienvenido, {{ session('usuario')['email'] }}!</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>
                {{ $ingresos <= 0 ? 0 : $ingresos }}
            </h3>
            <p>Entradas</p>
            </div>
            <div class="icon">
            <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('ingresos') }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $productos <= 0 ? 0 : $productos }}</h3>
            <p>
                Productos
            </p>
            </div>
            <div class="icon">
            <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('productos') }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
            <h3>
                {{ $salidas <= 0 ? 0 : $salidas }}
            </h3>
            <p>
                Salidas
            </p>
            </div>
            <div class="icon">
            <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('salidas') }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
            <h3>
                {{ $ordenes <= 0 ? 0 : $ordenes }}
            </h3>
            <p>Órdenes</p>
            </div>
            <div class="icon">
            <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('ordenes') }}" class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->


    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title" style="font-weight: bold">LISTADO DE PRODUCTOS DE BAJO STOCK</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body"> 
              <table id="example2" class="table table-bordered table-hover table-sm">
                <thead class="text-center">
                <tr>
                  <th>ID</th>
                  <th>Producto</th>
                  <th>Categoría</th>
                  <th>Precio</th>
                  <th>Stock</th>
                </tr>
                </thead>

                <tbody class="text-center">
                @foreach($productos_bajostock as $producto)
                    <tr>
                        <td>{{ $producto->ID_Prod }}</td>
                        <td>{{ $producto->Nombre_Prod }}</td>
                        <td>{{ $producto->tipo_producto }}</td>
                        <td>{{ $producto->PrecioVent_Prod }}</td>
                        <td>{{ $producto->StockActual_Prod }}</td>
                    </tr>
                @endforeach
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

@endsection