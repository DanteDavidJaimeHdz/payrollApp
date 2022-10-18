<template>
    <div class="container">
      <br>
      <el-dialog
          title="Create Role"
          :visible.sync="dialogVisible"
          width="30%"
          :before-close="handleClose">
          <!-- <span>Create Category</span> -->
          <el-form ref="form" :rules="rules" :model="newRole" label-width="120px">
                <el-form-item label="Name">
                    <el-input v-model="newRole.name"></el-input>
                </el-form-item>
                <el-form-item label="bonus">
                    <el-input v-model="newRole.bonus"></el-input>
                </el-form-item>
          </el-form>
          <span slot="footer" class="dialog-footer">

              <el-button @click="hideDialog()">Cancel</el-button>
              <el-button type="primary" @click="createRole()">Save</el-button>
          </span>
      </el-dialog>
      <div class="row">
          <div class="col-12">
              <el-button type="text" @click="dialogVisible = true">Nuevo Rol</el-button>
              <BasicTable
                  :source-columns="sourceColumns"
                  :data-source="data"
                  :title="'Roles'"
                  :slots="slots"
                  @edit="edit"
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
          data: [],
          sourceColumns: [
              {
                  name: "Id",
                  columnName: "id"
              },
              {
                  name: "Name",
                  columnName: "name"
              },
              {
                  name: "Bonus config",
                  columnName: "bonus"
              },
          ],
          dialogVisible: false,
          newRole: {
            id: null,
            name: null,
            bonus: null,
          },
          rules: {
              name: [
                  { required: true, message: "Please input name", trigger: "change" },
              ],
              lastname: [
                  { required: true, message: "Please input lastname", trigger: "change" }
              ],
              role_id: [
                  { type: "number", required: true, message: "Please select a role", trigger: "change" }
              ]
          },
          slots: [
                {
                    name: "Editar",
                    columnName: "id"
                },
            ],
      };
  },
  mounted() {
      //this.listCatService();
      this.getRoles();
  },
  methods: {
      createRole() {
          const formData = new FormData();
          formData.append("name", this.newRole.name);
          formData.append("bonus", this.newRole.bonus);
          axios.post("roles/rol/createRole", formData)
              .then(response => {
              // limpiar campo
              // cargar lista de nuevo
              this.$message({
                  message: response.data.message,
                  type: "success"
              });
              this.getRoles();
              //this.resetMovement();
              this.hideDialog();
          })
              .catch(error => {
              alert(error);
          });
      },
      getRoles() {
          axios.get("roles/rol/getRoles")
              .then(response => {
              // cargar datos
              this.data = response.data;
          })
              .catch(error => {
                console.log();
              //alert(error);
          });
      },
      edit(data){
        let searchData = { id: data.id }
        axios.post("roles/rol/searchData", searchData)
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
            employeeId: null,
            month: null,
            hours: null,
          };
      }
  },
  components: { BasicTable }
}
</script>