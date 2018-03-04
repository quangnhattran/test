<template>
  <div>
        <input id="trix" :value="value" type="hidden" :name="name">
        <trix-editor ref="trix"  class="trix-content" input="trix" :placeholder="placeholder"></trix-editor>
  </div>
</template>
<script>
import Trix from 'trix'
export default {
    props: ['name','value','placeholder','shouldClear'],
    mounted() {
        this.$refs.trix.addEventListener('trix-change',e => {
            //console.log('trigged');
            this.$emit('input',e.target.innerHTML);
        });
        this.$watch('shouldClear',(e)=>{
            this.$refs.trix.value='';
        });
    },
    //watch:
}
</script>

