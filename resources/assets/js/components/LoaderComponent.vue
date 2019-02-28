<template>
    <div class="loader"></div>
</template>
<script>
export default {
    name: 'Loader'
}
</script>
<style lang="scss" scoped>
.loader {
  border: 16px solid #d0d6d8; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>


