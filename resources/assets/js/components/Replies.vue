<template>
    <div>
    <div class="card mb-2" v-for="(reply,index) in replies" :key="reply.id">
        <reply :data="reply" @removed="remove(index)"></reply>
    </div>

    <paginator :dataSet="dataSet" @changed="fetch"></paginator>

    <p>There is no reply yet.</p>
    
    <hr>
    <new-reply @created="add"></new-reply>
    </div>
</template>

<script>

import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
import Paginator from './Paginator.vue'
export default {
  components: {Reply,NewReply,Paginator},
  data() {
      return {
          replies: null,
          dataSet:null
      }
  },
  created() {
      this.fetch();
  },
  methods: {
      fetch(page) {
          axios.get(this.url(page)).then(({data})=>this.refresh(data));
      },
      url(page) {
          
          if(! page) {
              let query = location.search.match(/page=(\d+)/);
              page = query ? query[1] : 1;
          }
          return `${location.pathname}/replies?page=${page}`;
      },
      refresh(data) {
          //console.log(data.data.length)
          this.replies = data.data;
          this.dataSet = data;
          window.scrollTo(0,0);
      }  ,

      add(data) {
          this.replies.push(data);
          this.$emit('added');
      },
      remove(index) {
          this.replies.splice(index,1);
          flash('Your reply removed');
          this.$emit('removed');
      }
  }
}
</script>

