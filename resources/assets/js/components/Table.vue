<template>
<div class="row">
    <div class="col-lg-12">
        <SearchForm v-if="paginator.data && paginator.data.length > 0"></SearchForm>
    </div>
    <div class="col-lg-12 table-responsive">
        <q-table title="Tabela" 
            :data="paginator.data" 
            :columns="columns" 
            :pagination.sync="pagination" 
            row-key="name" 
            binary-state-sort>

        </q-table> 
        <table class="table table-striped" v-if="paginator.data && paginator.data.length > 0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>nome/titulo</th>
                    <th>ações</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, i) in paginator.data" :key="i">
                    <td v-text="item.id"></td>
                    <td class="text-truncate" v-text="(item.name) ? item.name : item.title"></td>
                    <td>
                        <div>
                            <a class="btn btn-default btn-xs" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                data-container="body"
                                title="Editar">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a> 
                            <a class="btn btn-danger btn-xs" 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                data-container="body"
                                title="Apagar">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>  
        </table>
    </div>
</div>
</template>
<script>
import SearchForm from "../forms/SearchForm.vue";
import { QTable } from "quasar";

export default {
    name: "Table",
    components:{
        SearchForm, QTable
    },
    props:["paginator"],
    data(){
        return {
            pagination: {
                page: this.paginator.current_page,
                rowsPerPage: this.paginator.per_page
                // rowsNumber: xx if getting data from a server
            },
            columns: [
                { name: 'id', align: 'center', label: 'ID', field: 'id', sortable: true },
                //{ name: 'name', align: 'center', label: 'name/title', field: 'name', sortable: true },
                
            ]
        }
    }
}
</script>