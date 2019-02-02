<template>
    <!-- Sidebar -->
    <div class="sidebar">
        <!--
            Tip 1: You can change the background color of the sidebar using: data-background-color="black | dark | blue | purple | light-blue | green | orange | red"
            Tip 2: you can also add an image using data-image attribute
        -->
        <div class="sidebar-background"></div>
        <div class="sidebar-wrapper scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="photo">
                        <img src="/img/profile.jpg" alt="image profile">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                            <span>
                                Hizrian
                                <span class="user-level">Administrador</span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <div class="clearfix"></div>

                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="#profile">
                                        <span class="link-collapse">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Menu Principal -->
                <ul class="nav">
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
      this.$store.dispatch('LOAD_PERFIL_USER')      
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
        listMenu : []
      }
    },
    computed: {
        ...mapState(['perfil_user','user_system']),
    },   

    watch:{
      perfil_user: function(newVal){
        if(newVal != 'undefined' && newVal != null){
          this.listMenu = this.perfil_user
        }
        if(newVal == null){
          this.listMenu = []
        }
      }
    },            
   
}
</script>