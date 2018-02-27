<template>
    <input type="file" accept="image/*" @change="onChange">
</template>

<script>
export default {
  methods: {
      onChange(e) {
                if (! e.target.files.length) return;

                let file = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(file); //Convert image to string 

                reader.onload = e => {
                    let src = e.target.result;

                    this.$emit('loaded', { src, file });
                };
            }
  }
}
</script>

