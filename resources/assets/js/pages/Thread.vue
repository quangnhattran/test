<script>
import Replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton'
export default {
  props: ['thread'],

  components: {Replies,SubscribeButton},

  data() {
      return {
          replies_count: this.thread.replies_count,
          locked:this.thread.locked,
          editing: false,
          title: this.thread.title,
          body: this.thread.body,
          form: {}
      }
  },
  created() {
      this.resetForm();
  },
  methods: {
      toggleLock() {
          let uri = `/locked-thread/${this.thread.slug}`;
          axios[this.locked ? 'delete' : 'post'](uri);
          this.locked = ! this.locked;
      },
      update() {
          let uri = location.pathname;
          axios.patch(uri,this.form)
                .then(()=> {
                    this.title = this.form.title;
                    this.body = this.form.body;
                    this.editing = false;
                    flash('Thread Updated');
                });
      },
      resetForm() {
          this.editing = false;
          this.form.title = this.title;
          this.form.body = this.body;
      }
  }
}
</script>
