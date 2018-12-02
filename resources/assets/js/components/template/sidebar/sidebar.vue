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

                    <router-link class="nav-item" v-for="route in listMenu" v-if="route.options.length == 0" tag="li" :to="{ name: route.name_router}" :key="route.id">
                        <a href="#"><i :class="[route.icono]"></i> <p>{{ route.name_template }}</p></a>
                    </router-link>
<!--                     <li class="nav-item active">
                        <a href="/dashboard">
                            <i class="flaticon-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li> -->
<!--                     <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="la la-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Components</h4>
                    </li> -->
                    <li v-for="route in listMenu" v-if="route.options.length > 0" :key="route.id" class="nav-item">
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
<!--                     <li class="nav-item">
                        <a data-toggle="collapse" href="#base">
                            <i class="flaticon-layers"></i>
                            <p>Configuración</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base">
                            <ul class="nav nav-collapse">

                                <li>
                                    <a href="/empresaadministradoras">
                                        <span class="sub-item">Empresas Administradoras</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/sedes">
                                        <span class="sub-item">Sedes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/cargos">
                                        <span class="sub-item">Cargos</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/servicios">
                                        <span class="sub-item">Servicios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/gruposervicios">
                                        <span class="sub-item">Grupo de Servicios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/laboratorios">
                                        <span class="sub-item">Laboratorios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/materiales">
                                        <span class="sub-item">Materiales</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/tarifarios">
                                        <span class="sub-item">Tarifarios</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#forms">
                            <i class="flaticon-agenda-1"></i>
                            <p>Entidades</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="forms">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="forms/forms.html">
                                        <span class="sub-item">Pacientes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="forms/formvalidation.html">
                                        <span class="sub-item">Doctores</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="forms/formwidget.html">
                                        <span class="sub-item">Personal</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#tables">
                            <i class="flaticon-box"></i>
                            <p>Seguridad</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="/usuarios">
                                        <span class="sub-item">Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/perfiles">
                                        <span class="sub-item">Perfiles</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/modulos">
                                        <span class="sub-item">Modulos</span>
                                    </a>
                                </li>                                
                            </ul>
                        </div>
                    </li> -->
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
    data () {
      return {
        listMenu : []
      }
    },
    computed: {
        ...mapState(['perfil_user','user_system']),
    },   
    created() {
      this.$store.dispatch('LOAD_PERFIL_USER')      
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