<script>
import Replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton'
export default {
  props: ['data'],

  components: {Replies,SubscribeButton},

  data() {
      return {
          replies_count: this.data.replies_count
      }
  }
}
</script>
