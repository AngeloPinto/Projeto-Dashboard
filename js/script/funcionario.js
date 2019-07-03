json_genero = [
    {ID: 'M', DESC: 'Masculino'},
    {ID: 'F', DESC: 'Feminino' }
]

new Vue({

    el: "#funcionario",
    data: {

        lstGenero       : json_genero,
        lstDepartamento : [],
        lstFuncionario  : [],
        lstInicial      : [],
        lstDataChart    : false,


        genero_sel       : '',
        departamento_sel : '',
        funcionario_sel  : '',
        inicial_sel      : ''

    },

    mounted: function () {
        this.load_lista_departamento();
        this.load_lista_inicial();
    },

    watch: {
        genero_sel: function () {
            if ((this.departamento_sel != '') && (this.genero_sel != '') && (this.inicial_sel != '')) {
                this.lstDataChart = false;
                this.load_lista_funcionario();
            }
        },

        departamento_sel: function () {
            if ((this.departamento_sel != '') && (this.genero_sel != '') && (this.inicial_sel != '')) {
                this.lstDataChart = false;
                this.load_lista_funcionario();
            }
        },

        inicial_sel: function () {
            if ((this.departamento_sel != '') && (this.genero_sel != '') && (this.inicial_sel != '')) {
                this.lstDataChart = false;
                this.load_lista_funcionario();
            }
        },
        funcionario_sel: function () {
            if (this.funcionario_sel != '') {
                this.load_data_chart_funcionario();
            }
        },
        lstDataChart: function() {
            if (this.lstDataChart != false) {
                this.draw_chart_funcionario();
            }
        }
    },

    methods: {

        load_lista_departamento: function () {

            var vm = this;

            jQuery.ajax({
                async: true,
                url: 'ajaxRequest/jData.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    metodo: 'ajax_lista_departamentos'
                },
                beforeSend: function () {
                    loading_start();
                },
                success: function (result) {
                    if (result == 0) {
                        vm.lstDepartamento = [];
                    } else {
                        vm.lstDepartamento = result;
                    }
                },
                error: function (e) {
                    console.log(e);
                },
                complete: function () {
                    loading_stop();
                }
            });

        },

        load_lista_inicial: function () {

            var vm = this;

            jQuery.ajax({
                async: true,
                url: 'ajaxRequest/jData.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    metodo: 'ajax_funcionario_inicial_nome'
                },
                beforeSend: function () {
                    // loading_start();
                },
                success: function (result) {
                    if (result == 0) {
                        vm.lstInicial = [];
                    } else {
                        vm.lstInicial = result;
                    }
                },
                error: function (e) {
                    console.log(e);
                },
                complete: function () {
                    // loading_stop();
                }
            });

        },

        load_lista_funcionario: function () {

            var vm = this;

            jQuery.ajax({
                async: true,
                url: 'ajaxRequest/jData.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    metodo: 'ajax_departamento_funcionarios',
                    GENERO: vm.genero_sel,
                    DEPT_NO: vm.departamento_sel,
                    INICIAL: vm.inicial_sel
                },
                beforeSend: function () {
                    loading_start();
                },
                success: function (result) {
                    if (result == 0) {
                        vm.lstFuncionario = [];
                    } else {
                        vm.lstFuncionario = result;
                    }
                },
                error: function (e) {
                    console.log(e);
                },
                complete: function () {
                    loading_stop();
                }
            });

        },

        load_data_chart_funcionario: function () {

            var vm = this;

            jQuery.ajax({
                async: true,
                url: 'ajaxRequest/jData.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    metodo: 'ajax_funcionario_salario_anual',
                    EMP_NO: vm.funcionario_sel
                },
                beforeSend: function () {
                    loading_start();
                },
                success: function (result) {
                    if (result == 0) {
                        vm.lstDataChart = false;
                    } else {
                        vm.lstDataChart = result;
                    }
                },
                error: function (e) {
                    console.log(e);
                },
                complete: function () {
                    loading_stop();
                }
            });

        },

        draw_chart_funcionario: function () {

            var vm = this;

            Highcharts.chart('graf-funcionario', {

                title: {
                    text: ''
                },

                yAxis: {
                    title: {
                        text: 'Salários'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                xAxis: {
                    categories: vm.lstDataChart.ANO
                },

                series: [{
                    name: 'Salário',
                    data: vm.lstDataChart.SALARIO
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'top'
                            }
                        }
                    }]
                }

            });

        } // draw_chart_funcionario
    }
});