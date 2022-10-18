<template>
    <div class="container">
      <br>
      <el-dialog
          title="Create Movement"
          :visible.sync="dialogVisible"
          width="30%"
          :before-close="handleClose">
          <!-- <span>Create Category</span> -->
          <el-form ref="form" :rules="rules" :model="newMovement" label-width="120px">
                <el-form-item label="Empleado">
                    <el-select
                        v-model="newMovement.employeeId"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Seleccione un empleado"
                        :remote-method="getEmployees"
                        :loading="loading">
                        <el-option
                        v-for="item in employees"
                        :key="item.id"
                        :label="item.name + ' ' + item.lastname"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="Mes">
                    <el-select
                        v-model="newMovement.month"
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
                </el-form-item>
                <el-form-item label="Entregas">
                    <el-input type="number" v-model="newMovement.deliveries"></el-input>
                </el-form-item>
          </el-form>
          <span slot="footer" class="dialog-footer">

              <el-button @click="hideDialog()">Cancel</el-button>
              <el-button type="primary" @click="createMovement()">Save</el-button>
          </span>
      </el-dialog>
      <div class="row">
          <div class="col-12">
              <el-button type="text" @click="dialogVisible = true">Nuevo movimiento</el-button>
              <BasicTable
                  :source-columns="sourceColumns"
                  :data-source="data"
                  :title="'Categories'"
                  :slots="slots"
                  @edit="edit"
              >
              <template slot="edit">
                <el-button @click="hideDialog()">Cancel</el-button>
              </template>
              </BasicTable>
          </div>
      </div>
    </div> <!-- /container -->
</template>

<script>
  import '../../../css/tableStyles.css';
import BasicTable from '../utilities/basic-table.vue';
  export default {
  name: "create-movement",
  data() {
      return {
          nameCat: "",
          listCat: [],
          data: [],
          months: [
                    {id:1 ,name:'Enero'},{id:2 ,name:'Febrero'}, {id:3 ,name:'Marzo'}, {id:4 ,name:'Abril'},
                    {id:5 ,name:'Mayo'}, {id:6 ,name:'Junio'}, {id:7,name:'Julio'}, {id:8 ,name:'Agosto'} ,
                    {id:9 ,name:'Septiembre'}, {id:10 ,name:'Octubre'}, {id:11 ,name:'Noviembre'}, {id:12 ,name:'Diciembre'}
                ],
          sourceColumns: [
              {
                  name: "Id",
                  columnName: "id",
              },
              {
                  name: "Name",
                  columnName: "name",
              },
              {
                  name: "Lastname",
                  columnName: "lastname",
              },
              {
                  name: "Month",
                  columnName: "month",
              },
              {
                  name: "Deliveries",
                  columnName: "deliveries",
              },
          ],
          slots: [
                {
                  name: "Editar",
                  columnName: "id"
                },
            ],
          dialogVisible: false,
          newMovement: {
            id: null,
            employeeId: null,
            month: null,
            deliveries: null,
          },
          rules: {
              employeeId: [
                  { required: true, message: "Please select an employee", trigger: "change" },
              ],
              month: [
                  { required: true, message: "Please select a month", trigger: "change" }
              ],
              hours: [
                  { type: "number", required: true, message: "Please input worked hours", trigger: "change" }
              ]
          },

          employees: [],
          loading: false
      };
  },
  mounted() {
      //this.listCatService();
      this.getEmployees();
      this.getMovements();
  },
  methods: {
      createMovement() {
          const formData = new FormData();
          formData.append("id", this.newMovement.id);
          formData.append("employeeId", this.newMovement.employeeId);
          formData.append("month", this.newMovement.month);
          formData.append("deliveries", this.newMovement.deliveries);
          axios.post("movements/movement/createMovement", formData)
              .then(response => {
              // limpiar campo
              // cargar lista de nuevo
              this.$message({
                  message: response.data.message,
                  type: "success"
              });
              this.getMovements();
              this.resetMovement();
              this.hideDialog();
          })
              .catch(error => {
              //alert(error);
          });
      },
      getMovements() {
          axios.get("movements/movement/getMovements")
              .then(response => {
              // cargar datos
              this.data = response.data;
          })
              .catch(error => {
              //alert(error);
          });
      },
      getEmployees(queryString = "") {
        let searchData = { qry: queryString }
        axios.post("employees/employee/getListForSelect", searchData)
              .then(response => {
              // cargar datos
              this.employees = response.data;
          })
              .catch(error => {
              //alert(error);
          });
      },
      edit(data){
        let searchData = { id: data.id }
        axios.post("movements/movement/searchData", searchData)
              .then(response => {
              // cargar datos
              this.newMovement = response.data;
          })
              .catch(error => {
              //alert(error);
          });
        this.dialogVisible = true;
      },
      tableRowClassName({ row, rowIndex }) {
          if (row.status === 0) {
              return "warning-row";
          }
          else if (row.status === 1) {
              return "success-row";
          }
          return "";
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
      resetMovement() {
          this.newMovement = {
            id:null,
            employeeId: null,
            month: null,
            hours: null,
          };
      }
  },
  components: { BasicTable }
}
</script>