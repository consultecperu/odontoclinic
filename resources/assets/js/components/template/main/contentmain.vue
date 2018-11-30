<template>
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <!-- breadcrumbmain -->
                <breadcrumbmain></breadcrumbmain>
                <!-- end breadcrumbmain-->
                <!-- rutas - contenido -->
                <router-view></router-view>                

                <!-- end rutas - contenido -->
            </div>
        </div>			
    </div>    
</template>
<script>
export default {
    name: 'contentmain',
    data() {
        return {
                    
        }
    },       
}
</script>
<style scoped>

</style>
