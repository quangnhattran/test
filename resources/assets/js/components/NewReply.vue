<template>
   <div>
        <div class="form-group">
            <textarea id="rbody" v-model="body" rows="3" class="form-control" required></textarea>
        </div>
            <button @click="submit" class="btn btn-primary">Post</button>
    </div>
</template>
<script>
import 'jquery.caret'
import 'at.js'
export default {
  data() {
      return {
          body: ''
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
                });
      }
  }
}
</script>

