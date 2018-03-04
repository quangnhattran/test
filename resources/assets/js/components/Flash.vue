<template>
    <div class="alert" :class="`alert-`+type" role="alert" v-show="show">
         {{message}}
    </div>
</template>
<script>
    export default {
        props: ['data'],
        data() {
            return {
                message:this.data.message,
                type:'success',
                show:false
            }
        },
        created() {
            if(this.message) this.flash(this.data);
            window.Events.$on('flash',(data)=>{
               this.flash(data);
            });
        },
        methods: {
            flash(data) {
                this.message = data.message;
                if(data.type) this.type=data.type;
                this.show=true;
                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 2500);
            }
        }
    }
</script>
<style scoped>
   div {
       position: fixed;
       right: 25px;
       bottom: 25px;
       z-index:999;
   }
</style>
