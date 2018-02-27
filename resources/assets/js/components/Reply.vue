<template>
  <div>
      <div :id="`reply-`+reply.id" class="card-header level" :class="isBest ? 'alert-success' : null ">
            <span><a :href="`/profiles`+reply.owner.name">
                {{reply.owner.name}}</a>
                replied {{ago(reply.updated_at)}}...</span>
            <favorite-button :reply="reply" v-if="signedIn"></favorite-button>
        </div>

        <div class="card-body" v-show="!editing" v-html="reply.body"></div>
        <div class="card-body" v-show="editing">
            <textarea rows="3" class="form-control mb-1" v-model="body"></textarea>
            <button class="btn btn-outline-default btn-sm" @click="editing=false">Cancel</button>
            <button class="btn btn-outline-primary btn-sm" @click="update">Save</button>
        </div>

        <div class="card-footer level" v-if="authorize('owns',reply)" v-show="!editing">
            
            <button class="btn btn-outline-primary btn-sm mr-2" @click="editing=true">Edit</button>
            <button class="btn btn-outline-danger btn-sm" @click="remove">Delete</button>

            <button class="btn btn-outline-default btn-sm ml-auto" @click="markBestReply">Best Reply?</button>
        </div>
  </div>
</template>
<script>
import moment from 'moment';
import FavoriteButton from './FavoriteButton'
export default {
  props: ['data'],
  components: {FavoriteButton},
  data() {
      return {
          reply: this.data,
          editing:false,
          id:this.data.id,
          body: this.data.body,
          isBest:this.data.isBest
      }
  },
  created() {
      window.Events.$on('reply_is_best',id => {
          return this.isBest = (this.id===id);
      });
  },
  methods: {
      markBestReply() {
          window.Events.$emit('reply_is_best',this.id);
          axios.post('/replies/'+this.id+'/best');
      },
      ago(updated_at) {
          return moment(updated_at).fromNow();
      },
      update() {
          axios.patch('/replies/'+this.id,{body:this.body});
          flash('Updated');
          this.reply.body = this.body;
          this.editing = false;
      },
      remove() {
          axios.delete('/replies/'+this.id);
          this.$emit('removed',this.id);
      }
  }
}
</script>

