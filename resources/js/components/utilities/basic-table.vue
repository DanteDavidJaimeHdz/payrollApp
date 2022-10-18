<template>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ title }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <template v-for="column in sourceColumns">
                                <th> {{column.name}} </th>
                            </template>
                            <template v-for="column in slots">
                                <th> {{column.name}} </th>
                            </template>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <template v-for="column in sourceColumns">
                                <th> {{column.name}} </th>
                            </template>
                            <template v-for="column in slots">
                                <th> {{column.name}} </th>
                            </template>
                        </tr>
                    </tfoot>
                    <tbody>
                        <template v-for="data in dataSource">
                            <tr>
                                <template v-for="value in data">
                                    <td>
                                        {{ value }}
                                    </td>
                                </template>
                                <template v-for="column in slots">
                                    <template v-if="column.name == 'Editar'">
                                        <td>
                                            <el-button type="primary" icon="el-icon-edit" circle @click="edit(data)"></el-button>
                                        </td>
                                    </template>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>
<script>
import axios from 'axios';

    export default {
        name: 'basic-table',
        data() {
            return {
                //pageName:''
            };
        },
        props: {
            sourceColumns: {
                type: Array,
                default: []
            },
            dataSource: {
                type: Array,
                default: []
            },
            title: {
                type: String,
                default: ""
            },
            slots: {
                type: Array,
                default: []
            }
        },
        watch: {
            'pageName': function(v) {
                //console.log(v);
            }
        },
        mounted() {
            //console.log(this.pageName);
        },
        methods:{
            changePageName(name) {
                this.pageName = name;
            },
            edit(data) {
                this.$emit('edit', data)
            }
        }
		
    }
</script>