<template>
    <div class="container">
      <br>
      <div class="row">
          <div class="col-12">
              <BasicTable
                  :source-columns="sourceColumns"
                  :data-source="data"
                  :title="'Reporte'"
              >
              </BasicTable>
          </div>
      </div>
    </div> <!-- /container -->
</template>

<script>
  import '../../../css/tableStyles.css';
import BasicTable from '../utilities/basic-table.vue';
  export default {
  name: "movement-report",
  data() {
      return {
          nameCat: "",
          data: [],
          months: [
                    {id:1 ,name:'Enero'},{id:2 ,name:'Febrero'}, {id:3 ,name:'Marzo'}, {id:4 ,name:'Abril'},
                    {id:5 ,name:'Mayo'}, {id:6 ,name:'Junio'}, {id:7,name:'Julio'}, {id:8 ,name:'Agosto'} ,
                    {id:9 ,name:'Septiembre'}, {id:10 ,name:'Octubre'}, {id:11 ,name:'Noviembre'}, {id:12 ,name:'Diciembre'}
                ],
          sourceColumns: [
              {
                  name: "Id",
                  columnName: "id"
              },
              {
                  name: "Nombre",
                  columnName: "employee_name"
              },
              {
                  name: "Apellido",
                  columnName: "lastname"
              },
              {
                name:"Rol",
                columnName:"role_name"
              },
              {
                  name: "Mes",
                  columnName: "month"
              },
              {
                  name: "Entregas",
                  columnName: "deliveries"
              },
              {
                  name: "Salario base",
                  columnName: "base_salary"
              },
              {
                  name: "Bonus de entregas",
                  columnName: "extra_deliveries"
              },
              {
                name: "Bonus extra",
                columnName: "extra_bonus"
              },
              {
                name: "Bonus extra",
                columnName: "extra_bonus"
              },
              {
                name: "Subtotal",
                columnName: "subtotal"
              },
              {
                name: "Total",
                columnName: "total_payroll"
              },
          ],
          dialogVisible: false,
          loading: false
      };
  },
  mounted() {
      this.getReport();
  },
  methods: {
      getReport() {
          axios.get("movements/movement/getReport")
              .then(response => {
              // cargar datos
              this.data = response.data;
          })
              .catch(error => {
              //alert(error);
          });
      },
      resetDateFilter() {
          this.$refs.filterTable.clearFilter("date");
      },
      clearFilter() {
          this.$refs.filterTable.clearFilter();
      },
      filterStatus(value, row) {
          return row.status === value;
      },
      filterHandler(value, row, column) {
          const property = column["property"];
          return row[property] === value;
      },
      hideDialog() {
          this.dialogVisible = false;
          //reset form
      },
      handleClose(done) {
          this.$confirm("Are you sure to close this dialog?")
              .then(_ => {
              done();
          })
              .catch(_ => { });
      },
  },
  components: { BasicTable }
}
</script>