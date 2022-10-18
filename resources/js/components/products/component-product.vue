<template>
  	<div class="container">
        <br>
        <div class="row">
      		<div class="col-md-8 order-md-1">
        		<h4 class="mb-3">Products {{productName}}</h4>
				<template>
					<el-button type="text" @click="dialogVisible = true">Create</el-button>
					<el-dialog
						title="Create Product"
						:visible.sync="dialogVisible"
						width="30%"
						:before-close="handleClose">
						<!-- <span>Create Category</span> -->
						<el-form ref="form" :rules="rules" :model="newProduct" label-width="120px">
							<el-form-item label="Name">
								<el-input v-model="newProduct.name"></el-input>
							</el-form-item>
							<el-form-item label="Description">
								<el-input v-model="newProduct.description"></el-input>
							</el-form-item>
                            <el-form-item label="Price">
								<el-input v-model="newProduct.price"></el-input>
							</el-form-item>
							<el-form-item label="Categoría">
								<el-select v-model="newProduct.category_id" placeholder="Select Status">
									<el-option
                                        v-for="item in categories"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    </el-option>
								</el-select>
							</el-form-item>
						</el-form>
						<span slot="footer" class="dialog-footer">

							<el-button @click="hideDialog()">Cancel</el-button>
							<el-button type="primary" @click="addProduct()">Save</el-button>
						</span>
					</el-dialog>
					<el-table
						:data="dataSource"
						style="width: 100%"
						>
						<template v-for="item in sourceColumns">
							<el-table-column
							:prop="item.columnName"
							:label="item.name"
							></el-table-column>
						</template>
						<!-- <el-table-column
							prop="status"
							label="Status"
							width="100"
							:filters="[{ text: 'Enabled', value: '1' }, { text: 'Disabled', value: '0' }]"
							:filter-method="filterStatus"
							filter-placement="bottom-end">
							<template slot-scope="scope">
								<el-tag
								:type="scope.row.status === '1' ? 'primary' : 'success'"
								disable-transitions>
									<template v-if="scope.row.status === 1">
										Activo
									</template>
									<template v-else>
										Inactivo
									</template>
								</el-tag>
							</template>
						</el-table-column> Comentado para uso de ejemplo de slot-->
					</el-table>
				</template>
      		</div>
    	</div>
  	</div> <!-- /container -->
</template>

<script>
	import '../../../css/tableStyles.css';
    export default {
        name: 'component-product',
        data(){
          return{
            productName:"",
            dataSource: [],
			sourceColumns:[
				{
					name: 'Name',
					columnName: 'name'
				},
				{
					name: 'Description',
					columnName: 'description'
				},
                {
					name: 'Price',
					columnName: 'price'
				},
                {
					name: 'Category name',
					columnName: 'category_name'
				},
                {
					name: 'Img',
					columnName: 'img'
				}
                
			],
			dialogVisible: false,
			newProduct: {
				name: null,
                description: null,
				price: null,
                category_id: null,
                img: null,
			},
			rules: {
				name: [
					{ required: true, message: 'Please input product name', trigger: 'change' },
				],
				description: [
					{ required: true, message: 'Please input product description', trigger: 'change' }
				],
				price: [
					{ type: 'number', required: true, message: 'Please input product price', trigger: 'change' }
				],
                price: [
					{ type: 'number', required: true, message: 'Please select product category', trigger: 'change' }
				]
			},
            categories: []
          }
        },
        mounted() {
            this.listProducts();
            this.listCategoriesSelect();
        },
        methods:{
			addProduct(){
				const formData = new FormData()
				formData.append('name',this.newProduct.name);
				formData.append('description',this.newProduct.description);
				formData.append('price',this.newProduct.price);
                formData.append('category_id',this.newProduct.category_id);
                formData.append('img', this.newProduct.img);
				axios.post("products/createProduct",formData)
				.then(response => {
				// limpiar campo
				//console.log(response);
				// cargar lista de nuevo
				this.$message({
					message: response.data.message,
					type: 'success'
				});
				this.listProducts();
				this.resetNewProduct();
				this.hideDialog();
				})
				.catch(error => {
				alert(error)
				})

			},
			listProducts(){
				axios.get("products/getListProducts")
				.then(response=>{
					// cargar datos
					this.dataSource = response.data
				})
				.catch(error=>{
					alert(error)
				})
			},
            listCategoriesSelect(){
				axios.get("category/api/category/getListSelect")
				.then(response=>{
					// cargar datos
					this.categories = response.data
				})
				.catch(error=>{
					alert(error)
				})
            },
			updateSatus(id,status){
				const formData = new FormData()
				// parametro
				// id de categoria
				formData.append('idcat',id)
				// status de categoria
				formData.append('status',status)	
				axios.post("products/updateProduct",formData)
				.then(response => {
					// limpiar campo
					// cargar lista de nuevo
					this.listProducts()
				})
				.catch(error => {
					alert(error)
				})
			},
		  	tableRowClassName({row, rowIndex}) {
				if (row.status === 0) {
				    return 'warning-row';
				} 
                else if (row.status === 1) {
				    return 'success-row';
				}
				return '';
			},
			resetDateFilter() {
        		this.$refs.filterTable.clearFilter('date');
			},
			clearFilter() {
				this.$refs.filterTable.clearFilter();
			},
			filterStatus(value, row) {
				return row.status === value;
			},
			filterHandler(value, row, column) {
				const property = column['property'];
				return row[property] === value;
			},
			hideDialog() {
				this.dialogVisible = false;
				//reset form
			},
			handleClose(done) {
				//this.$confirm('Are you sure to close this dialog?')
				//.then(_ => {
					done();
				//})
				//.catch(_ => {});
			},
			resetNewProduct() {
				this.newProduct = {
                    name: null,
                    description: null,
                    price: null,
                    category_id: null,
                    img: null,
                }
			}
        }
		
    }
</script>