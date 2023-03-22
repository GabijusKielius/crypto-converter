<script>

</script>

<template>
    <div class="loader"></div>
</template>

<style scoped>
.loader {
    border: 8px solid #f3f3f3; /* Light grey */
    border-top: 8px solid rgb(59 130 246 / 0.5); /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
