
new Vue({

    el: "#departamento",
    data: {
        lstDepartamento: []
    },
    
    mounted: function() {
        this.chart_departamento();
    },

    watch: {
        lstDepartamento: function(){
            if (this.lstDepartamento !== []) {
                this.draw_chart_departamento();
            }
        }
    },
    methods: {

        chart_departamento: function(){
            // loading_start();
            this.load_data_departamento();
            // loading_stop();
        },

        load_data_departamento: function(){

            var vm = this;

            jQuery.ajax({
                async: true, 
                url: 'ajaxRequest/jData.php', 
                type: 'POST', 
                dataType: 'json', 
                data: { 
                    metodo: 'ajax_departamento_salarios'
                }, 
                beforeSend: function() {
                    loading_start();
                }, 
                success: function(result) { 
                    if (result == 0) {
                        vm.lstDepartamento = [];
                    } else {
                        vm.lstDepartamento = result;
                    }
                }, 
                error: function (e) { 
                    console.log(e); 
                }, 
                complete: function() { 
                    loading_stop();
                } 
            });
    
        },
        
        draw_chart_departamento: function(){

            var vm = this;

            Highcharts.chart('graf-departamentos', {
                chart: {
                    zoomType: 'xy'
                },
                title: {
                    text: 'Salários e Percentuais por Departamento',
                    align: 'center'
                },
                xAxis: [{
                    categories: vm.lstDepartamento.DEPARTAMENTO,
                    crosshair: true
                }],
                yAxis: [{ // Primary yAxis
                    labels: {
                        format: '{value}%',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Percentual',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true
            
                }, { // Secondary yAxis
                    gridLineWidth: 0,
                    title: {
                        text: 'Salários',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '$ {value}',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    }
            
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'horizontal',
                    align: 'left',
                    x: 17,
                    verticalAlign: 'top',
                    y: 0,
                    floating: true,
                    reversed: false,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
                },
                series: [{
                    name: 'Salários',
                    type: 'column',
                    yAxis: 1,
                    data: vm.lstDepartamento.SALARIO,
                    tooltip: {
                        // valueSuffix: ' $'
                        valuePrefix: '$ '
                    }
            
                }, {
                    name: 'Percentual',
                    type: 'spline',
                    data: vm.lstDepartamento.PERC,
                    tooltip: {
                        valueSuffix: ' %'
                    }
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                floating: false,
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom',
                                x: 0,
                                y: 0
                            }
                        }
                    }]
                }
            });            
        }
    }
});