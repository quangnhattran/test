<template>
<div>
   <div v-if="signedIn">
        <div class="form-group">
            <!-- <textarea id="rbody" v-model="body" rows="3" class="form-control" required></textarea> -->
            <wysiwyg v-model="body" placeholder="You have something to say?" :shouldClear="completed" ref="trix"></wysiwyg>
        </div>
            <button @click="submit" class="btn btn-primary">Post</button>
    </div>
    <div v-else>
        You must <a href="/login"><em>login</em></a> to leave a reply.
    </div>
 </div>  
</template>
<script>
import 'jquery.caret'
import 'at.js'
export default {
  data() {
      return {
          body: '',
          completed: false
      }
  },
  mounted() {
      $('#rbody').atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    $.getJSON("/api/users", {name: query}, function(usernames) {
                        callback(usernames)
                    });
                }
            }
        });
  },
  methods: {
      submit() {
          axios.post(location.pathname+'/replies',{body:this.body})
                .catch(error => {
                   // console.log(error.response.data.);
                    flash(error.response.data.errors.body[0],'danger');
                }).then(({data})=>{
                    this.body = '';
                    flash('Your reply posted');
                    this.$emit('created',data);
                    //this.$refs.trix.$refs.trix.value='';
                    this.completed = ! this.completed;
                });
      }
  }
}
</script>

