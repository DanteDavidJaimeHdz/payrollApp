<template>
    <div class="container">
      <br>
      <div class="row">
          <div class="col-12">
            <el-form ref="form" :rules="rules" :model="payrollConfig" label-width="200px">
                <el-form-item label="Días por semana">
                    <el-input v-model="payrollConfig.semanal_days"></el-input>
                </el-form-item>
                <el-form-item label="Horas por día">
                    <el-input v-model="payrollConfig.day_hours"></el-input>
                </el-form-item>
                <el-form-item label="Salario Base Hora">
                    <el-input v-model="payrollConfig.default_hour_salary"></el-input>
                </el-form-item>
                <el-form-item label="Salario máximo con ISR normal">
                    <el-input v-model="payrollConfig.min_salary"></el-input>
                </el-form-item>
                <el-form-item label="% ISR por defecto">
                    <el-input v-model="payrollConfig.default_isr"></el-input>
                </el-form-item>
                <el-form-item label="% ISR Extra sobre el salario máximo">
                    <el-input v-model="payrollConfig.extra_isr"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="saveConfig()">Save</el-button>
                </el-form-item>
            </el-form>
          </div>
      </div>
    </div>
</template>

<script>
  import '../../../css/tableStyles.css';
import BasicTable from '../utilities/basic-table.vue';
  export default {
  name: "payroll-config",
  data() {
      return {
          dialogVisible: false,
          payrollConfig: {
            semanal_days: null,
            day_hours: null,
            default_hour_salary: null,
            min_salary: null,
            default_isr: null,
            extra_isr: null,
          },
          rules: {
              semanal_days: [
                  { type: "number", required: true, message: "Por favor, ingrese los días a la semana", trigger: "change" },
              ],
              default_hour_salary: [
                  { type: "number", required: true, message: "Por favor, ingrese el salario por hora", trigger: "change" },
              ],
              day_hours: [
                  { type: "number", required: true, message: "Por favor, ingrese las horas trabajadas al día", trigger: "change" },
              ],
              min_salary: [
                  { type: "number", required: true, message: "Por favor, ingrese el salario para el isr extra", trigger: "change" },
              ],
              default_isr: [
                  { type: "number", required: true, message: "Por favor, ingrese el % por defecto de isr", trigger: "change" }
              ],
              extra_isr: [
                  { type: "number", required: true, message: "Por favor ingrese el isr extra", trigger: "change" }
              ]
          },
      };
  },
  mounted() {
      this.getConfig();
  },
  methods: {
      saveConfig() {
          const formData = new FormData();
          formData.append("semanal_days", this.payrollConfig.semanal_days);
          formData.append("default_hour_salary", this.payrollConfig.default_hour_salary);
          formData.append("day_hours", this.payrollConfig.day_hours);
          formData.append("min_salary", parseFloat(this.payrollConfig.min_salary).toFixed(2));
          formData.append("default_isr", parseFloat(this.payrollConfig.default_isr).toFixed(2));
          formData.append("extra_isr", this.payrollConfig.extra_isr);
          axios.post("configs/config/saveConfig", formData)
              .then(response => {
              // limpiar campo
              // cargar lista de nuevo
              this.$message({
                  message: response.data.message,
                  type: typeof response.data.exception != 'undefined' ? "warning" : "success"
              });
              this.getConfig();
              this.hideDialog();
          })
              .catch(error => {
                this.$message({
                  message: response.data.message,
                  type: "warning"
              });
          });
      },
      getConfig() {
          axios.get("configs/config/getConfig")
              .then(response => {
              // cargar datos
              // console.log(response);
              this.payrollConfig = response.data;
          })
              .catch(error => {
                this.$message({
                  message: response.data.message,
                  type: "danger"
              });
          });
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