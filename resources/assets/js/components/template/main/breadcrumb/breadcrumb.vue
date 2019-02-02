<template>
    <div>
        <ul class="breadcrumbs">
            <li class="nav-home">                               <!-- home icon casa -->
                <a href="#">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator" v-if="breadthird != null">    
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" v-if="breadthird != null">     <!-- primer de izquierda a derecha -->
                <a href="#">{{ breadthird }}</a>
            </li>            
            <li class="separator" v-if="breadsecond != null">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" v-if="breadsecond != null">    <!-- segundo de izquierda a derecha -->
                <a href="#" v-if="breadthird == null">{{ breadsecond }}</a>
                <router-link :to="{ name : ruta_second}" v-if="breadthird != null">{{ breadsecond }}</router-link>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">                               <!-- ultimo de izquierda a derecha -->
                <a href="#" v-if="_breadmain == null">{{ breadmain }}</a>
                <router-link :to="{ name : ruta_main}" v-if="_breadmain != null">{{ breadmain }}</router-link>                
            </li>
            <li class="separator" v-if="_breadmain != null">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item" v-if="_breadmain != null">     <!-- ultimo de izquierda a derecha -->
                <a href="#">{{ _breadmain }}</a>
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
        ...mapState(['breadmain','_breadmain','breadsecond','breadthird','ruta_main','ruta_second']),
    },         
}
</script>