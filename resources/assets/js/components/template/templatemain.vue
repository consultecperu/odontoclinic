<template>
	<div  v-bind:class="{ 'wrapper' : authenticated }">
        <!-- Navbarmain -->
        <navbarmain v-show="authenticated"></navbarmain>
        <!-- Navbarmain -->
		<!-- Sidebar -->
        <sidebar v-show="authenticated"></sidebar>
		<!-- End Sidebar -->
        <!-- Main -->
        <div v-bind:class="{ 'main-panel' : authenticated }">
            <div v-bind:class="{ 'content' : authenticated }">
                <div v-bind:class="{ 'content-fluid' : authenticated }">
                    <breadcrumbmain v-show="authenticated"></breadcrumbmain>
                    <router-view></router-view>
                </div>
            </div>
        </div>
        <!-- end Main -->

	</div>    
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'templatemain',
    data() {
        return {
                    
        }
    },  
    beforeCreate() {  
        document.body.className = "";

    }, 
    mounted() {
        console.log("autentificado: ",this.authenticated)
    },
    computed: {
        ...mapState(['authenticated'])
    },          
}
</script>
<style scoped>

</style>
