<template>
  <button class="btn btn-sm ml-auto" :class="classes" @click="favorite">
        <i class="fas fa-heart"></i> {{favorites_count}}
    </button>
</template>
<script>
export default {
  props: ['reply'],
  data() {
      return {
          isFavorited: this.reply.isFavorited,
          favorites_count: this.reply.favorites_count
      }
  },
  computed: {
      classes() {
          return this.isFavorited ? 'btn-primary' : 'btn-default';
      }
  },
  methods: {
      favorite() {
          this.isFavorited ? this.favorites_count-- : this.favorites_count++;
          axios[(this.isFavorited ? 'delete' : 'post')]('/replies/'+this.reply.id+'/favorite')
                        .then(({data})=>flash(data));
          this.isFavorited = ! this.isFavorited;
      }
  }
}
</script>
