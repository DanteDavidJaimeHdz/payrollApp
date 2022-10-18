<template>
    <div class="container">
        <br>
        <div class="row">
            
        </div>
    </div> <!-- /container -->
</template>

<script>
    export default {
        mounted() {
            console.log('Component main mounted.')
        },
        data() {
            return { 
                cartMenu: [],
                products: [],
                userData: [],
            }
        },
        methods: {
            getProducts() {
                axios.get("products/getListProducts")
				.then(response=>{
					// cargar datos
					this.products = response.data
				})
				.catch(response=>{
					this.$message({
					message: response.message,
					type: 'danger'
				});
				})
            },

        }
    }
</script>