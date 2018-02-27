<template>
  <div class="card-body">
        <button class="btn btn-sm" :class="classes" @click="subscribe" v-text="text"></button>
    </div>
</template>

<script>
export default {
  props: ['active'],
  computed: {
      classes() {
          return this.active ? 'btn-success' : 'btn-default';
      },
      text() {
          return this.active ? 'Subscribed' : 'Subscribe';
      }
  },
  methods: {
      subscribe() {
          axios[(this.active ? 'delete' : 'post')](location.pathname+'/subscriptions')
                    .then(({data})=>{
                        flash(data);
                    });
          this.active = ! this.active;
      }
  }
}
</script>

