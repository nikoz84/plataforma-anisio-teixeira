<template>
<div v-if="parent && parent.length">
  <p class="text-center q-mt-lg">
   {{ label }}:  <i>{{ selectText  }} </i>
  </p>
  <q-scroll-area style="height: 200px;border: solid 1px" visible>
    <div v-for="(item, i) in parent" :key="i" >
      <div :class="{'cursor-pointer': hasChildrens(item), 'highlight': item.id == selectItemId }"
        @click="select(item, $event)">
        <b v-text="item.name"></b>
        <div class="cursor-pointer" :class="{'highlight': sub.id == selectItemId}"
          v-for="(sub, e) in childrens(item)" :key="e" @click="select(sub, $event)">
          <b class="q-pl-sm q-my-md" v-text="`- ${sub.name}`"></b>
        </div>
      </div>
    </div>
  </q-scroll-area>
</div>
</template>

<script>
export default {
  name: 'ParentAndChildSelect',
  props: ['parent', 'label', 'selectedId'],
  data(){
    return { 
      selectText: ''
    }
  },
  computed: {
    selectItemId: {
      get() {
        return this.selectedId;
      },
      set(val) {
        this.$emit('click', val);
      }
    }
  },
  methods: {
    childrens(item) {
      if(item.hasOwnProperty('sub_categories')){
        return item.sub_categories;
      } else if(item.hasOwnProperty('childs')){
        return item.childs;
      }
    },
    hasChildrens(item) {
      let length = 0;
      if(item.hasOwnProperty('sub_categories')){
        length = item.sub_categories.length;
      } else if(item.hasOwnProperty('childs')){
        length = item.childs.length;
      }

      return length > 0 ? false : true;
    },
    select(item, event) {
      if(this.hasChildrens(item)) {
        this.selectItemId = item.id
        this.selectText = item.name
      }
    }
  }
}
</script>
<style lang="stylus" scoped>
.highlight {
  background: yellow;
}
</style>