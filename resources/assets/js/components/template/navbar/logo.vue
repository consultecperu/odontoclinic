<template>
    <!-- Logo Header -->
    <div class="logo-header">
        <!--
            Tip 1: You can change the background color of the logo header using: data-background-color="black | dark | blue | purple | light-blue | green | orange | red"
        -->
        <a href="index.html" class="big-logo">
            <img src="/img/logoresponsive.png" alt="logo img" class="logo-img">
        </a>
        <a href="index.html" class="logo">
            <img src="/img/logoheader.png" alt="navbar brand" class="navbar-brand">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="la la-bars"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>
    </div>
    <!-- End Logo Header -->    
</template>
<script>
export default {
    name: 'logo',
    data() {
        return {
                    
        }
    },    
}
</script>
<style scoped>

</style>


