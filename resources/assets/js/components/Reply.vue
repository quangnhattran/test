<template>
  <div>
      <div :id="`reply-`+reply.id" class="card-header level" :class="isBest ? 'alert-success' : null ">
            <span><a :href="`/profiles`+reply.owner.name">
                {{reply.owner.name}} ({{reply.owner.reputation}} XP)</a>
                replied {{ago(reply.updated_at)}}...</span>
            
        </div>

        <div class="card-body trix-content" v-if="! editing" v-html="reply.body"></div>
        <div class="card-body" v-if="editing">
            <!-- <textarea rows="3" class="form-control mb-1" v-model="body"></textarea> -->
            <wysiwyg v-model="body" class="mb-2" name="body" v-if="isWysiwyg"></wysiwyg>
            <button class="btn btn-outline-default btn-sm" @click="editing=false">Cancel</button>
            <button class="btn btn-primary btn-sm" @click="update">Save</button>
        </div>

        <div class="card-footer level" v-if="authorize('owns',reply) || authorize('owns',reply.thread)" v-show="! editing">
            
            <button class="btn btn-outline-primary btn-sm mr-2" @click="edit">Edit</button>
            <button class="btn btn-outline-danger btn-sm" @click="remove">Delete</button>

            <button class="btn btn-outline-default btn-sm ml-auto" @click="markBestReply" v-if="authorize('owns',reply.thread)">Best Reply?</button>
        </div>
  </div>
</template>
<script>
import moment from 'moment';
import FavoriteButton from './FavoriteButton'
export default {
  props: ['reply'],
  components: {FavoriteButton},
  data() {
      return {
          editing:false,
          id:this.reply.id,
          body: this.reply.body,
          isBest:this.reply.isBest,
          isWysiwyg: false
      }
  },
  created() {
      window.Events.$on('reply_is_best',id => {
          return this.isBest = (this.id===id);
      });
      window.Events.$on('wysiwyg-on',id => {
           this.isWysiwyg = (this.id===id);
           if(! this.isWysiwyg) this.editing = false;
      });
  },
  methods: {
      edit() {
          this.editing = true;
          window.Events.$emit('wysiwyg-on',this.id);
      },
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

