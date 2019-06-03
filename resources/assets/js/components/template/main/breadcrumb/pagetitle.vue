<template>
    <div>
        <!-- page-title -->
        <h4 class="page-title" v-text="_breadmain == null ? breadmain : _breadmain"></h4>
        <!-- end page-title --> 
    </div>   
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'pagetitle',
    data() {
        return {
  
        }
    },  
    computed: {
        ...mapState(['breadmain','_breadmain']),
    },

        
}
</script>