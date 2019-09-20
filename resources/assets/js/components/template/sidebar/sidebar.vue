<template>
    <!-- Sidebar -->
    <div class="sidebar">
        <!--
            Tip 1: You can change the background color of the sidebar using: data-background-color="black | dark | blue | purple | light-blue | green | orange | red"
            Tip 2: you can also add an image using data-image attribute
        -->
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>         
        <div class="sidebar-background"></div>
        <div class="sidebar-wrapper scrollbar-inner">
            <div class="sidebar-content">
                <div class="user ml-0 mr-0">
                    <div class="photo">
                        <img src="/img/profile.jpg" alt="image profile">
                    </div>
                    <div class="info">
                        <span class="user_system">
                            {{ user_system == null ? '' : user_system.__empleado.nombres + ' ' + user_system.__empleado.apellido_paterno}}
                            <span class="user-level font-weight-bold" v-text="user_system == null ? '' : user_system.perfile.nombre_perfil"></span>
                        </span>
                    </div>
                    <div class="pt-10">
                        <div class="form-group form-floating-label pb-0">
                            <select class="form-control input-border-bottom" id="selectSedes" v-model="sede" @change="cambioSede">
                                <option v-for="sed in sedes_perfil" :value="sed.id" :key="sed.id">
                                    {{ sed.nombre_sede}}
                                </option>
                            </select>
                            <label for="selectSedes" class="placeholder font-weight-bold">SEDE : </label>
                        </div>                        
                    </div>
                </div>
                <!-- Menu Principal -->
                <ul class="nav mt-0">
                    <template v-for="route in listMenu">
                        <router-link class="nav-item" v-if="route.options.length == 0" tag="li" :to="{ name: route.name_router}" :key="route.id">
                            <a href="#"><i :class="[route.icono]"></i> <p>{{ route.name_template }}</p></a>
                        </router-link>
                    </template>
                    <template v-for="route in listMenu">
                        <li v-if="route.options.length > 0"  :key="route.id" class="nav-item">
                            <a data-toggle="collapse" :href="'#'+ route.name_template">
                                <i :class="[route.icono]"></i>
                                <p>{{ route.name_template }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" :id="route.name_template">
                                <ul class="nav nav-collapse">
                                    <router-link v-for="subroute in route.options" tag="li" :to="{ name: subroute.name_router}" :key="subroute.id" exact>
                                        <a><span class="sub-item">{{ subroute.name_template }}</span></a>
                                    </router-link> 
                                </ul>
                            </div>
                        </li> 
                    </template>
                   
                </ul>
                <!-- Fin Menu Principal -->
            </div>
        </div>
    </div>
    <!-- End Sidebar -->    
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'sidebar',
    created() {
        this.$store.dispatch('LOAD_SEDES_LIST')        
        this.$store.dispatch('LOAD_PERFIL_USER')   
    },  
    mounted(){
        if(this.sedes_perfil != null){  
            this.sede = this.sedes_perfil[0].id                  
            this.$store.dispatch('CAMBIO_SEDE', this.sede )  
        }
    },
    updated(){
        $(".nav-item a").on('click', (function(){
            if ( $(this).parent().find('.collapse').hasClass("show") ) { // si es show
                $(this).parent().removeClass('submenu'); // quita color plomo a todo el conjunto de opciones
            } else {        // no es show
                $(this).parent().parent().find('.collapse.show').removeClass('show');
                $(this).parent().parent().find('.nav-item.submenu').removeClass('submenu');
                $(this).parent().addClass('submenu');   //agrega color plomo a todo el conjunto de opciones
            }
        }));        
    },
    data () {
      return {
        listMenu : [],
        sede:'',
        isLoading: false,
        fullPage: true,        
      }
    },
    computed: {
        ...mapState(['perfil_user','user_system','sedes','sede_system','sedes_perfil']),
    },   

    watch:{
        perfil_user: function(newVal){
            if(newVal != 'undefined' && newVal != null){
                this.listMenu = this.perfil_user
            }
            if(newVal == null){
                this.listMenu = []
            }
        },
        sedes_perfil(newVal) {
            if(newVal != null){  
                this.sede = this.sedes_perfil[0].id                  
                this.$store.dispatch('CAMBIO_SEDE', this.sede )  
            }
        }
    }, 
    methods:{
        cambioSede(){
            this.isLoading = true
            this.$store.dispatch('CAMBIO_SEDE', this.sede).then(() => {
                this.isLoading = false
            })
        }
    }           
   
}
</script>
<style scoped>
    .info {
        color:black !important;
    }
    .user_system {
        font-weight: 400 !important;
        font-size: 10px !important;
    }
</style>
