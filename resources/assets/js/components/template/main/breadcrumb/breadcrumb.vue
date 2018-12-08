<template>
    <div>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator" v-if="breadthird != null">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" v-if="breadthird != null">
                <a href="#">{{ breadthird }}</a>
            </li>            
            <li class="separator" v-if="breadsecond != null">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" v-if="breadsecond != null">
                <a href="#" v-if="breadthird == null">{{ breadsecond }}</a>
                <router-link :to="{ name : ruta_second}" v-if="breadthird != null">{{ breadsecond }}</router-link>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ breadmain }}</a>
            </li>
        </ul>        
    </div>
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'breadcrumb',
    data() {
        return {
                    
        }
    }, 
    computed: {
        ...mapState(['breadmain','breadsecond','breadthird','ruta_second']),
    },         
}
</script>