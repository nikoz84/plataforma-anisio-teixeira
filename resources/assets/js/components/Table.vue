<template>
<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-default btn-xs pull-left"
            data-toggle="tooltip" 
            data-placement="top" 
            title="Adicionar"
        ><i class="glyphicon glyphicon-plus"></i></a>
        <search-form></search-form>
    </div>
    <div class="col-lg-12 table-responsive"> 
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

export default {
    name: "Table",
    components:{
        "search-form":SearchForm
    },
    props:["paginator"]
}
</script>