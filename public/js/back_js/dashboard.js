$(document).ready(function() {
    const baseUrl = document.getElementById('baseUrl').value;

    function updateStats() {
        $.ajax({
            url: baseUrl + '/admin/dashboard/stats',
            method: 'GET',
            success: function(response) {
                updateCounterWithEffect('#total-ordenes', response.total);
                updateCounterWithEffect('#in-workshop-orders', response.inWorkshop);
                updateCounterWithEffect('#closed-ordenes', response.closed);
                updateCounterWithEffect('#active-users', response.activeUsers);
                updateCounterWithEffect('#online-users', response.onlineUsers);
            },
            error: function(xhr) {
                console.error('Error actualizando estadísticas:', xhr);
            }
        });
    }

    function updateCounterWithEffect(selector, newValue) {
        const element = $(selector);
        if (!element.length) return;
        
        const currentValue = parseInt(element.text());
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
            const totals = data.map(item => item.total);
            if (importeChart) {
                importeChart.data.labels = labels;
                importeChart.data.datasets[0].data = totals;
                importeChart.update();
            } else {
                const ctx = document.getElementById('importe-stats-chart').getContext('2d');
                // Different palette colors for the second chart
                const bgPalette = [
                    'rgba(255,111,0,0.5)',  // #FF6F00
                    'rgba(0,150,136,0.5)',  // #009688
                    'rgba(255,193,7,0.5)',  // #FFC107
                    'rgba(156,39,176,0.5)', // #9C27B0
                    'rgba(0,188,212,0.5)',  // #00BCD4
                    'rgba(255,82,82,0.5)',  // #FF5252
                    'rgba(3,169,244,0.5)',  // #03A9F4
                    'rgba(142,36,170,0.5)'  // #8e24aa
                ];
                const bdPalette = [
                    'rgba(255,111,0,1)',
                    'rgba(0,150,136,1)',
                    'rgba(255,193,7,1)',
                    'rgba(156,39,176,1)',
                    'rgba(0,188,212,1)',
                    'rgba(255,82,82,1)',
                    'rgba(3,169,244,1)',
                    'rgba(142,36,170,1)'
                ];
                const backgroundColors = labels.map((_, i) => bgPalette[i % bgPalette.length]);
                const borderColors = labels.map((_, i) => bdPalette[i % bdPalette.length]);
                importeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Facturación diaria',
                            data: totals,
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
                                    // Formateamos los valores del eje Y como moneda
                                    callback: function(value, index, values) {
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

    // Handle range button clicks
    $('#orden-range-buttons button').on('click', function() {
        $('#orden-range-buttons button').removeClass('active');
        $(this).addClass('active');
        const range = $(this).data('range');
        loadOrdenStats(range);
    });

    // Handle range button clicks for importe chart
    $('#importe-range-buttons button').on('click', function() {
        $('#importe-range-buttons button').removeClass('active');
        $(this).addClass('active');
        const range = $(this).data('range');
        loadImporteStats(range);
    });

    // Initialize default range - cambiado de 7 a 30 días
    loadOrdenStats('30');
    
    // Initialize importe stats with the same default range
    loadImporteStats('30');

    // Inicializar
    updateStats();

    // Actualizar estadísticas cada minuto
    setInterval(updateStats, 60000);

});