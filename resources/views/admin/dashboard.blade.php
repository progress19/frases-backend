@php
    use Khill\Lavacharts\Lavacharts;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <!-- Sección de Estadísticas de Órdenes -->
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-bar-chart" aria-hidden="true"></i> Estadísticas de Órdenes<small></small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="row">
                    <!-- Total Órdenes -->
                    <div class="col-md-2">
                        <div class="widget-small primary">
                            <div class="info">
                                <h4><i class="fa fa-list" aria-hidden="true"></i> Total Órdenes</h4>
                                <h1 id="total-ordenes">{{ $basicStats['totalOrdenes'] }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Órdenes Completadas -->
                    <div class="col-md-2">
                        <div class="widget-small success">
                            <div class="info">
                                <h4><i class="fa fa-check-circle" aria-hidden="true"></i> Completadas</h4>
                                <h1 id="completadas-ordenes">{{ $basicStats['ordenesCompletadas'] }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Órdenes en Progreso -->
                    <div class="col-md-2">
                        <div class="widget-small info">
                            <div class="info">
                                <h4><i class="fa fa-spinner" aria-hidden="true"></i> En Progreso</h4>
                                <h1 id="progreso-ordenes">{{ $basicStats['ordenesEnProgreso'] }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Órdenes Pendientes -->
                    <div class="col-md-2">
                        <div class="widget-small warning">
                            <div class="info">
                                <h4><i class="fa fa-clock-o" aria-hidden="true"></i> Pendientes</h4>
                                <h1 id="pendientes-ordenes">{{ $basicStats['ordenesPendientes'] }}</h1>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Clientes Activos -->
                    <div class="col-md-2">
                        <div class="widget-small purple">
                            <div class="info">
                                <h4><i class="fa fa-users" aria-hidden="true"></i> Clientes</h4>
                                <h1 id="active-clientes">{{ $basicStats['clientes'] }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- Ingresos Totales -->
                    <div class="col-md-2">
                        <div class="widget-small danger">
                            <div class="info">
                                <h4><i class="fa fa-money" aria-hidden="true"></i> Ingresos</h4>
                                <h3 id="total-ingresos">${{ number_format($basicStats['ingresosTotal'], 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Órdenes por día -->
        <div class="x_panel animate__animated animate__fadeIn mt-3">
            <div class="x_title">
                <h2><i class="fa fa-bar-chart" aria-hidden="true"></i> Órdenes creadas por día</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <div id="orden-range-buttons" class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="7">7 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="14">14 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-range="30">30 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="all">Todos</button>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <canvas id="orden-stats-chart" height="300"></canvas>
            </div>
        </div>

        <!-- Gráfico de Importes por día -->
        <div class="x_panel animate__animated animate__fadeIn mt-3">
            <div class="x_title">
                <h2><i class="fa fa-money" aria-hidden="true"></i> Facturación diaria</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <div id="importe-range-buttons" class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="7">7 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="14">14 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-range="30">30 días</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-range="all">Todos</button>
                        </div>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <canvas id="importe-stats-chart" height="300"></canvas>
            </div>
        </div>

        <!-- Sección de Frases -->
        <div class="x_panel animate__animated animate__fadeIn mt-3 mb-4">
            <div class="x_title">
                <h2><i class="fa fa-comment" aria-hidden="true"></i> Frases<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>


            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-stats">
                            <h4>Cantidad de frases: {{ $frases }}</h4>
                            <h4>Cantidad de frases mostradas: {{ $frases_mostradas }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Total de frases</th>
                                        <th>Frases mostradas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipos as $tipo)
                                        <tr>
                                            <td>{{ $tipo->nombre }}</td>
                                            <td>{{ $tipo->total_frases }}</td>
                                            <td>{{ $tipo->frases_mostradas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- /page content -->

@endsection

@section('page-js-script')
    @if (session('flash_message'))
        <script>
            toast('{!! session('flash_message') !!}');
        </script>
    @endif
    
    <!-- Agregamos una url base oculta para las llamadas AJAX -->
    <input type="hidden" id="baseUrl" value="{{ url('/') }}">
    
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function() {
            const baseUrl = document.getElementById('baseUrl').value;
        
            function updateStats() {
                $.ajax({
                    url: baseUrl + '/admin/dashboard/stats',
                    method: 'GET',
                    success: function(response) {
                        updateCounterWithEffect('#total-ordenes', response.totalOrdenes);
                        updateCounterWithEffect('#completadas-ordenes', response.ordenesCompletadas);
                        updateCounterWithEffect('#progreso-ordenes', response.ordenesEnProgreso);
                        updateCounterWithEffect('#pendientes-ordenes', response.ordenesPendientes);
                        updateCounterWithEffect('#active-clientes', response.clientes);
                        // Formateamos el número para que se muestre como moneda
                        const ingresosFormateados = '$' + new Intl.NumberFormat('es-AR', { 
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2 
                        }).format(response.ingresosTotal);
                        $('#total-ingresos').text(ingresosFormateados);
                    },
                    error: function(xhr) {
                        console.error('Error actualizando estadísticas:', xhr);
                    }
                });
            }
        
            function updateCounterWithEffect(selector, newValue) {
                const element = $(selector);
                if (!element.length) return;
                
                const currentValue = parseInt(element.text().replace(/,/g, ''));
                if (currentValue !== newValue) {
                    element.text(newValue);
                    element.addClass('zoom-effect');
                    setTimeout(() => element.removeClass('zoom-effect'), 500);
                }
            }
        
            // Orden stats chart and filters
            let ordenChart;
            function loadOrdenStats(range) {
                const url = `${baseUrl}/admin/dashboard/orden-stats?range=${range}`;
                $.get(url, function(data) {
                    const labels = data.map(item => {
                        const [year, month, day] = item.date.split('-');
                        return `${day}/${month}/${year}`;
                    });
                    const counts = data.map(item => item.count);
                    if (ordenChart) {
                        ordenChart.data.labels = labels;
                        ordenChart.data.datasets[0].data = counts;
                        ordenChart.update();
                    } else {
                        const ctx = document.getElementById('orden-stats-chart').getContext('2d');
                        // palette of 8 semi-transparent colors
                        const bgPalette = [
                            'rgba(3,169,244,0.5)',  // #03A9F4
                            'rgba(142,36,170,0.5)', // #8e24aa
                            'rgba(255,111,0,0.5)',  // #FF6F00
                            'rgba(0,150,136,0.5)',  // #009688
                            'rgba(255,193,7,0.5)',  // #FFC107
                            'rgba(156,39,176,0.5)', // #9C27B0
                            'rgba(0,188,212,0.5)',  // #00BCD4
                            'rgba(255,82,82,0.5)'   // #FF5252
                        ];
                        const bdPalette = [
                            'rgba(3,169,244,1)',
                            'rgba(142,36,170,1)',
                            'rgba(255,111,0,1)',
                            'rgba(0,150,136,1)',
                            'rgba(255,193,7,1)',
                            'rgba(156,39,176,1)',
                            'rgba(0,188,212,1)',
                            'rgba(255,82,82,1)'
                        ];
                        const backgroundColors = labels.map((_, i) => bgPalette[i % bgPalette.length]);
                        const borderColors = labels.map((_, i) => bdPalette[i % bdPalette.length]);
                        ordenChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Órdenes creadas',
                                    data: counts,
                                    backgroundColor: backgroundColors,
                                    borderColor: borderColors,
                                    borderWidth: 2,
                                    borderRadius: 1
                                }]
                            },
                            options: {
                                plugins: { legend: { display: false } },
                                scales: { y: { beginAtZero: true } },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    }
                });
            }

            // Importe stats chart and filters
            let importeChart;
            function loadImporteStats(range) {
                const url = `${baseUrl}/admin/dashboard/importe-stats?range=${range}`;
                $.get(url, function(data) {
                    const labels = data.map(item => {
                        const [year, month, day] = item.date.split('-');
                        return `${day}/${month}/${year}`;
                    });
                    const amounts = data.map(item => item.total);
                    if (importeChart) {
                        importeChart.data.labels = labels;
                        importeChart.data.datasets[0].data = amounts;
                        importeChart.update();
                    } else {
                        const ctx = document.getElementById('importe-stats-chart').getContext('2d');
                        // palette of 8 semi-transparent colors
                        const bgPalette = [
                            'rgba(3,169,244,0.5)',  // #03A9F4
                            'rgba(142,36,170,0.5)', // #8e24aa
                            'rgba(255,111,0,0.5)',  // #FF6F00
                            'rgba(0,150,136,0.5)',  // #009688
                            'rgba(255,193,7,0.5)',  // #FFC107
                            'rgba(156,39,176,0.5)', // #9C27B0
                            'rgba(0,188,212,0.5)',  // #00BCD4
                            'rgba(255,82,82,0.5)'   // #FF5252
                        ];
                        const bdPalette = [
                            'rgba(3,169,244,1)',
                            'rgba(142,36,170,1)',
                            'rgba(255,111,0,1)',
                            'rgba(0,150,136,1)',
                            'rgba(255,193,7,1)',
                            'rgba(156,39,176,1)',
                            'rgba(0,188,212,1)',
                            'rgba(255,82,82,1)'
                        ];
                        const backgroundColors = labels.map((_, i) => bgPalette[i % bgPalette.length]);
                        const borderColors = labels.map((_, i) => bdPalette[i % bdPalette.length]);
                        importeChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Importes diarios',
                                    data: amounts,
                                    backgroundColor: backgroundColors,
                                    borderColor: borderColors,
                                    borderWidth: 2,
                                    borderRadius: 1
                                }]
                            },
                            options: {
                                plugins: { 
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                let value = context.raw;
                                                return new Intl.NumberFormat('es-AR', {
                                                    style: 'currency',
                                                    currency: 'ARS'
                                                }).format(value);
                                            }
                                        }
                                    }
                                },
                                scales: { 
                                    y: { 
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return '$' + value.toLocaleString('es-AR');
                                            }
                                        }
                                    } 
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    }
                });
            }
        
            // Handle range button clicks for orden stats
            $('#orden-range-buttons button').on('click', function() {
                $('#orden-range-buttons button').removeClass('active');
                $(this).addClass('active');
                const range = $(this).data('range');
                loadOrdenStats(range);
            });

            // Handle range button clicks for importe stats
            $('#importe-range-buttons button').on('click', function() {
                $('#importe-range-buttons button').removeClass('active');
                $(this).addClass('active');
                const range = $(this).data('range');
                loadImporteStats(range);
            });
        
            // Initialize default range - 30 días
            loadOrdenStats('30');
            loadImporteStats('30');
        
            // Inicializar
            updateStats();
        
            // Actualizar estadísticas cada minuto
            setInterval(updateStats, 60000);
        
        });
    </script>
@stop
