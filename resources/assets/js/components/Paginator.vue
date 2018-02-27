<template>
  <ul class="pagination" v-if="shouldPaginate">
       <li class="page-item" :class="prevUrl ? null: 'disabled'"><span>
           <a href="" class="page-link" @click.prevent="page--">
           &laquo; Previous
           </a></span>
        </li>

        <li class="page-item" :class="nextUrl ? null: 'disabled'"><span>
           <a href="" class="page-link" @click.prevent="page++">
            Next &raquo;
           </a></span>
        </li>
    
        
    </ul>
</template>

<script>
export default {
    props: ['dataSet'],
    data() {
        return {
            page:1,
            prevUrl:false,
            nextUrl:false
        }
    },
    computed: {
        shouldPaginate() {
            return !! this.prevUrl || !! this.nextUrl;
        }
    },
    watch: {
        dataSet() {
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
            this.page = this.dataSet.current_page;
        },
        page() {
            this.$emit('changed',this.page);
            history.pushState('','','?page='+this.page)
        }
    }
}
</script>

