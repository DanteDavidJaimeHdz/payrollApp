<template>
    <div>
  	    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="">
                    Payroll | Home
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="'Toggle navigation'">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            <a class="nav-link" href="login">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="register">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        name: 'header-pos',
        data() {
            return {
                logged: false, 
                secondUserInfo: "dante",
                userName: "Dante"
            };
        },
        props: {
            userInfo: {
                type: Array,
                default() {
                    return [];
                }
            },
            login: {
                type: String,
                default: '#',
            },
            logout: {
                type: String,
                default: '#',
            },
            register: {
                type: String,
                default: '#',
            }
        },
        watch: {
            'logged': function (v) {
                console.log(v);
            }
        },
        mounted() {
            if (Object.keys(this.userInfo).length === 0) {
                this.logged = false;
            }
            else {
                this.logged = true;
            }
        },
        methods:{
            logoutMethod() {
                axios.get("/logout")
				.then(response=>{
					// cargar datos
					
				})
				.catch(response=>{
					this.$message({
					message: response.message,
					type: 'danger'
				});
				})
            }
        }
		
    }
</script>