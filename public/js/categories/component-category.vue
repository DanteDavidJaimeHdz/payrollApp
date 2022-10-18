<template>
  	<div class="container">
        <br>
        <el-dialog
            title="Create Category"
            :visible.sync="dialogVisible"
            width="30%"
            :before-close="handleClose">
            <!-- <span>Create Category</span> -->
            <el-form ref="form" :rules="rules" :model="newCategory" label-width="120px">
                <el-form-item label="Name">
                    <el-input v-model="newCategory.name"></el-input>
                </el-form-item>
                <el-form-item label="Code">
                    <el-input v-model="newCategory.code"></el-input>
                </el-form-item>
                <el-form-item label="Status">
                    <el-select v-model="newCategory.status" placeholder="Select Status">
                        <el-option
                            key="1"
                            label="Enabled"
                            value="1">
                        </el-option>
                        <el-option
                            key="0"
                            label="Disabled"
                            value="0">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">

                <el-button @click="hideDialog()">Cancel</el-button>
                <el-button type="primary" @click="addCategory()">Save</el-button>
            </span>
        </el-dialog>
		<div class="row">
			<div class="col-12">
                <el-button type="text" @click="dialogVisible = true">Create</el-button>
				<BasicTable
					:source-columns="sourceColumns"
					:data-source="data"
					:title="'Categories'"
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
    name: "component-category",
    data() {
        return {
            nameCat: "",
            listCat: [],
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
                    name: "Code",
                    columnName: "code"
                },
				{
                    name: "Status",
                    columnName: "status"
                },
				{
                    name: "Created",
                    columnName: "created"
                },
				{
                    name: "Updated",
                    columnName: "updated"
                },
				{
                    name: "Deleted",
                    columnName: "deleted"
                },
            ],
            dialogVisible: false,
            newCategory: {
                name: "",
                code: "",
                status: null,
            },
            rules: {
                name: [
                    { required: true, message: "Please input Category name", trigger: "change" },
                ],
                code: [
                    { required: true, message: "Please select Category code", trigger: "change" }
                ],
                status: [
                    { type: "number", required: true, message: "Please select an option", trigger: "change" }
                ]
            }
        };
    },
    mounted() {
        this.listCatService();
    },
    methods: {
        addCategory() {
            const formData = new FormData();
            formData.append("name", this.newCategory.name);
            formData.append("code", this.newCategory.code);
            formData.append("status", this.newCategory.status);
            axios.post("api/category/createCategory", formData)
                .then(response => {
                // limpiar campo
                //console.log(response);
                // cargar lista de nuevo
                this.$message({
                    message: response.data.message,
                    type: "success"
                });
                this.listCatService();
                this.resetNewCategory();
                this.hideDialog();
            })
                .catch(error => {
                alert(error);
            });
        },
        listCatService() {
            axios.get("api/category/getList")
                .then(response => {
                // cargar datos
                this.data = response.data;
            })
                .catch(error => {
                alert(error);
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
        resetNewCategory() {
            this.newCategory = {
                name: "",
                code: "",
                status: null,
            };
        }
    },
    components: { BasicTable }
}
</script>