<template>
    <div class="form-group">
        <label for="palavra-chave">Palavras-Chave:*</label>
        <ul class="list-inline text-success">
            <li v-for="(tag,n) in tags" 
               v-bind:key="n"
               class="text-info"
               :style="'margin:5px;'"
               v-on:click="deleteTag(n)">
                <small class="label label-default">{{tag.name}}</small>
            </li>
        </ul>
        <input type="text" 
                class="form-control" 
                v-model="tag" 
                is-multiple 
                :options="tags">
        <ul class="list-unstyled">
            <li v-for="(item,i) in autocompleteItems" 
               v-bind:key="i"
               class="text-info"
               v-on:click="updateTag(item)">
            {{item.name}}
            </li>
        </ul>
    </div>
</template>
<script>
import Http from '../http.js';
import InputTag from 'vue-input-tag';
import debounce from 'lodash/debounce'
const http = new Http();

export default {
    name: 'TagForm',
    data(){
        return {
            tag: '',
            autocompleteItems:[],
            tags:[],
            newTags:[]
        }
    },
    created(){
        this.delayFunction = debounce(this.getTags, 500);
    },
    watch:{
        tag(novo, antigo){
            this.delayFunction();
        }
    },
    methods:{
        updateTag(newTag) {
            this.autocompleteItems = [];
            this.tag = '';
            this.tags.push(newTag);
            console.log(this.tags);
        },
        deleteTag(index){
            this.tags.splice(index, 1);
            console.log(this.tags)
        },
        async getTags(){
            if (this.tag.length === 0) return;

            let params = {token:localStorage.token};
            let resp = await http.getDataFromUrl(`/tags/search/${this.tag}`, params);

            if(resp.data.success){
                this.autocompleteItems = resp.data.paginator.data;
            }
            
        },
        onlyUnique(value, index, self) { 
            console.log(value)
            return self.indexOf(value) === index;
        }
    }
}    
</script>
<style lang="scss">

</style>
