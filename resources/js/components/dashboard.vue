<template>
    <div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <label>Seleccione un mes:</label>
                <el-select
                    v-model="month"
                    filterable
                    placeholder="Seleccione un mes..."
                    :loading="loading">
                    <el-option
                    v-for="item in months"
                    :key="item.id"
                    :label="item.name"
                    :value="item.name">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Horas Trabajadas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ workedHours }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pago Total Por Entregas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ totalPayFromDeliveries }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pago Total Por Bonos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ totalPayFromBonus }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Retenciones</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ retentions }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Vales</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ foodBonus }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Sueldo Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{ totalSalary }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Deliveries</h6>
                        
                    </div>
                    <div class="card-body">
                        
                        <div class="chart-area">
                            <column-chart :data="employeeDeliveries"></column-chart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Totals</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            <pie-chart :data="totals" width="100%" height="100%"></pie-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'dashboard',
        data(){
          return{
            loading:false,
			pageName: "Dashboard",
            months: [
                    {id:1 ,name:'Enero'},{id:2 ,name:'Febrero'}, {id:3 ,name:'Marzo'}, {id:4 ,name:'Abril'},
                    {id:5 ,name:'Mayo'}, {id:6 ,name:'Junio'}, {id:7,name:'Julio'}, {id:8 ,name:'Agosto'} ,
                    {id:9 ,name:'Septiembre'}, {id:10 ,name:'Octubre'}, {id:11 ,name:'Noviembre'}, {id:12 ,name:'Diciembre'}
            ],
            workedHours: null,
            totalPayFromDeliveries: null,
            totalPayFromBonus: null,
            retentions:null,
            foodBonus: null,
            totalSalary: null,
            month: null,
            employeeDeliveries: [],
            totals: []
          }
        },
        mounted() {
            //this.createChart();
            //this.createPieChart();
        },
        watch: {
            'month': function(v) {
                this.getData(v);
                this.getEmployeeData(v);
            }
        },
        methods:{
            getData(month) {
                var filter = {
                    month: month
                }
                axios.post("dashboards/dashboard/getData", filter)
                    .then(response => {
                    // limpiar campo
                    this.workedHours =  response.data.workedHours;
                    this.totalPayFromDeliveries =  response.data.totalPayFromDeliveries;
                    this.totalPayFromBonus =  response.data.totalPayFromBonus;
                    this.retentions =  response.data.retentions;
                    this.foodBonus =  response.data.foodBonus;
                    this.totalSalary = response.data.totalSalary;
                    this.totals = [['Retentions', response.data.retentions], ['Salary', response.data.totalSalary]];
                })
                    .catch(error => {
                    //alert(error);
                });
            },
            getEmployeeData(month) {
                var filter = {
                    month: month
                }
                axios.post("dashboards/dashboard/getEmployeeData", filter)
                    .then(response => {
                    // limpiar campo
                    var chartData = [];
                    response.data.forEach(element => {
                        chartData.push([element.name, element.deliveries]);
                    });
                    console.log(chartData);
                    console.log([['Dante', 32], ['Iván', 46], ['José', 28]])
                    this.employeeDeliveries = chartData;
                })
                    .catch(error => {
                    //alert(error);
                });
            }
        }
    }
</script>