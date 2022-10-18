<template>
    <div class="container">
      <br>
      <el-dialog
          title="Create Employee"
          :visible.sync="dialogVisible"
          width="30%"
          :before-close="handleClose">
          <!-- <span>Create Category</span> -->
          <el-form ref="form" :rules="rules" :model="newEmployee" label-width="120px">
                <el-form-item label="Name">
                    <el-input v-model="newEmployee.name"></el-input>
                </el-form-item>
                <el-form-item label="Lastname">
                    <el-input v-model="newEmployee.lastname"></el-input>
                </el-form-item>
                <el-form-item label="Role">
                    <el-select
                        v-model="newEmployee.rol_id"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Seleccione un rol"
                        :remote-method="getRoles"
                        :loading="loading">
                        <el-option
                        v-for="item in roles"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
          </el-form>
          <span slot="footer" class="dialog-footer">

              <el-button @click="hideDialog()">Cancel</el-button>
              <el-button type="primary" @click="createEmployee()">Save</el-button>
          </span>
      </el-dialog>
      <div class="row">
          <div class="col-12">
              <el-button type="text" @click="dialogVisible = true">Create</el-button>
              <BasicTable
                  :source-columns="sourceColumns"
                  :data-source="data"
                  :title="'Categories'"
                  :slots="slots"
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
  name: "employees",
  data() {
      return {
          loading:false,
          data: [],
          sourceColumns: [
              {
                  name: "Id",
                  columnName: "id"
              },
              {
                  name: "Name",
                  columnName: "employee_name"
              },
              {
                  name: "Lastname",
                  columnName: "lastname"
              },
              {
                  name: "rol",
                  columnName: "role_name"
              },
          ],
          dialogVisible: false,
          newEmployee: {
            name: null,
            lastname: null,
            rol_id: null,
          },
          rules: {
              name: [
                  { required: true, message: "Please input name", trigger: "change" },
              ],
              lastname: [
                  { required: true, message: "Please input lastname", trigger: "change" }
              ],
              rol_id: [
                  { type: "number", required: true, message: "Please select a role", trigger: "change" }
              ]
          },
          slots: [
                {
                  name: "Editar",
                  columnName: "id"
                },
           ],
          roles: [],
      };
  },
  mounted() {
      //this.listCatService();
      this.getEmployees();
      this.getRoles();
  },
  methods: {
      createEmployee() {
          const formData = new FormData();
          formData.append("name", this.newEmployee.name);
          formData.append("lastname", this.newEmployee.lastname);
          formData.append("rol_id", this.newEmployee.rol_id);
          axios.post("employees/employee/createEmployee", formData)
              .then(response => {
              // limpiar campo
              // cargar lista de nuevo
              this.$message({
                  message: response.data.message,
                  type: "success"
              });
              this.getEmployees();
              //this.resetMovement();
              this.hideDialog();
          })
              .catch(error => {
              alert(error);
          });
      },
      getEmployees() {
          axios.get("employees/employee/getEmployees")
              .then(response => {
              // cargar datos
              this.data = response.data;
          })
              .catch(error => {
                //console.log();
              //alert(error);
          });
      },
      getRoles(queryString ="") {
        axios.get("roles/role/getRoleForSelect")
              .then(response => {
              // cargar datos
              this.roles = response.data;
          })
              .catch(error => {
                //console.log();
              //alert(error);
          });
      },
      updateSatus(id, status) {
          const formData = new FormData();
          // parametro
          // id de categoria
          formData.append("idcat", id);
          // status de categoria
          formData.append("status", status);
          axios.post("api/category/updateCategory", formData)
              .then(response => {
              // limpiar campo
              // cargar lista de nuevo
              this.listCatService();
          })
              .catch(error => {
              alert(error);
          });
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
            employeeId: null,
            month: null,
            hours: null,
          };
      }
  },
  components: { BasicTable }
}
</script>