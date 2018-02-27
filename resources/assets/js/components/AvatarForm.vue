<template>
<div>
   <div class="level mb-2">
        <img :src="avatar" 
                width="50px" height="50px" class="mr-2">
        <h2>{{ this.user.name }}</h2>
    </div>    
    <image-upload name="avatar" @loaded="onLoad" v-if="canUpdate"></image-upload>
    <hr>
</div>
</template>

<script>
import ImageUpload from './ImageUpload'
export default {
  props: ['user'],
  components: {ImageUpload},
  data() {
      return {
          avatar: this.user.avatar
      }
  },
  computed: {
      canUpdate() {
        return  this.authorize(user => user.id===this.user.id);
      }
  },
  methods: {
      onLoad(avatar) {
          this.avatar = avatar.src;
          this.persist(avatar.file);
      },
      persist(avatar) {
          let data = new FormData;
          data.append('avatar',avatar);
          axios.post('/api/users/'+this.user.name+'/avatar',data)
                .then(({data}) => flash(data));
      }
  }
}
</script>
