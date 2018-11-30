<template>
    <!-- page-title -->
    <h4 class="page-title">{{ breadmain }}</h4>
    <!-- end page-title -->    
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
        ...mapState(['breadmain','breadsecond']),
    },

        
}
</script>
<style scoped>

</style>
