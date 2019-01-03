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
<<<<<<< HEAD
        <input type="text"
                class="form-control"
                v-model="tag"
                is-multiple
                :options="tags">
        <ul class="list-unstyled">
            <li v-for="(item,i) in autocompleteItems"
=======
        <div :class="{ 'input-group': !tagExists }">
            <input type="text"
                    class="form-control"
                    v-model="tag">
            <span class="input-group-btn" v-if="!tagExists">
                <button class="btn btn-default" type="button" v-on:click="createTag()">Criar</button>
            </span>
        </div>
        <ul class="list-group">
            <li v-for="(item,i) in autocompleteItems" 
>>>>>>> 44626991872aee97eafa6b4f5c03bf8570a42728
               v-bind:key="i"
               class="list-group-item"
               v-on:click="updateTag(item)">
                <a>{{item.name}}</a>
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
            newTags:[],
            tagExists: true
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
            this.onlyUnique(this.tags);
        },
        deleteTag(index){
            this.tags.splice(index, 1);
        },
        async getTags(){
            if (this.tag.length === 0) return;

            let params = {token:localStorage.token};
            let resp = await http.getDataFromUrl(`/tags/search/${this.tag}`, params);

            if(resp.data.success){
                this.autocompleteItems = resp.data.paginator.data;
            }
            
        },
        onlyUnique(data) { 
            const result = [];
            const map = new Map();
            for (const item of data) {
                if(!map.has(item.id)){
                    map.set(item.id, true);    // set any value to Map
                    result.push({
                        id: item.id,
                        name: item.name
                    });
                }
            }
            this.tags = result;
        },
        createTag(){
            console.log('hola')
        }
    }
}    
</script>
<style lang="scss">
.label::after {
  content: "x";
  padding-right: 5px;
  padding-left: 7px;
}
.label:hover{
    background-color: #1e78c2;
}

</style>
