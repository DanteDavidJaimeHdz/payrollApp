<template>
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <!-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> -->
                <div class="sidebar-brand-text mx-3">Payroll Admin<sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <router-link class="nav-link" :to="{name: 'dashboard'}" @click.native="changePageName('Dashboard')">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    Dashboard
                </router-link>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Reportes</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Reportes:</h6>
                        <router-link class="collapse-item" :to="{name: 'empoloyees'}" @click.native="changePageName('Empleados')">
                            Empleados
                        </router-link>
                        <router-link class="collapse-item" :to="{name: 'movementReport'}" @click.native="changePageName('Reporte de Movimentos')">
                            Reporte de Movimientos
                        </router-link>
                        <router-link class="collapse-item" :to="{name: 'roles'}" @click.native="changePageName('Roles')">
                            Roles
                        </router-link>
                        <!-- <router-link class="collapse-item" :to="{name: 'customers'}" @click.native="changePageName('Customers')">
                            Customers
                        </router-link> -->
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Programas</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Programas</h6>
                        <router-link class="collapse-item" :to="{name: 'movements'}" @click.native="changePageName('Crear Movimiento')">
                            Crear Movimiento
                        </router-link>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <router-link class="nav-link" :to="{name: 'config'}" @click.native="changePageName('Config')">
                    <i class="fas fa-fw fa-wrench"></i>
                    Config
                </router-link>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ userInfo.name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">{{ pageName }}</h1>
                    </div>
                    <!-- Start page -->
                    <!--<transition name="slide-fade" mode="out-in">-->
                        <router-view></router-view>
                    <!-- </transition> -->
                    <!-- end page-->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Payroll Admin 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
</template>

<script>
import axios from 'axios';

    export default {
        name: 'side-bar',
        data() {
            return {
                pageName:'Dashboard'
            };
        },
        props: {
            userInfo: {
                type: Object,
                default: []
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
            },
        },
        watch: {
            'pageName': function(v) {
                console.log(v);
            }
        },
        mounted() {
            console.log(this.pageName);
            console.log(this.userInfo);
        },
        methods:{
            changePageName(name) {
                this.pageName = name;
            }
        }
		
    }
</script>