<template>
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue">
        <!--
            Tip 1: You can change the background color of the navbar header using: data-background-color="black | dark | blue | purple | light-blue | green | orange | red"
        -->
        <div class="container-fluid">
            <div class="navbar-minimize">
                <button class="btn btn-minimize btn-rounded">
                    <i class="la la-navicon"></i>
                </button>
            </div>
            <div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search ml-md-3 mr-md-3">
                    <div class="input-group">
                        <input type="text" placeholder="Search ..." class="form-control">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-search">
                                <i class="la la-search search-icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item toggle-nav-search hidden-caret">
                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                        <i class="flaticon-search-1"></i>
                    </a>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon-envelope-1"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon-alarm"></i>
                        <span class="notification">3</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">You have 4 new notification</div>
                        </li>
                        <li>
                            <div class="notif-center">
                                <a href="#">
                                    <div class="notif-icon notif-primary"> <i class="la la-user-plus"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            New user registered
                                        </span>
                                        <span class="time">5 minutes ago</span> 
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-success"> <i class="la la-comment"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Rahmad commented on Admin
                                        </span>
                                        <span class="time">12 minutes ago</span> 
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-img"> 
                                        <img src="/img/profile2.jpg" alt="Img Profile">
                                    </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Reza send messages to you
                                        </span>
                                        <span class="time">12 minutes ago</span> 
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="notif-icon notif-danger"> <i class="la la-heart"></i> </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Farrah liked Admin
                                        </span>
                                        <span class="time">17 minutes ago</span> 
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">See all notifications<i class="la la-angle-right"></i> </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="/img/profile.jpg" alt="image profile" width="36" class="img-circle"></a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <li>
                            <div class="user-box">
                                <div class="u-img"><img src="/img/profile.jpg" alt="image profile"></div>
                                <div class="u-text">
                                    <h4>{{user_system.perfile.nombre_perfil}}</h4>
                                    <p class="text-muted">{{ user_system.__empleado.nombres + ' ' + user_system.__empleado.apellido_paterno}}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Cambiar Clave</a>
<!--                             <a class="dropdown-item" href="#">My Balance</a>
                            <a class="dropdown-item" href="#">Inbox</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Account Setting</a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" @click.prevent="logout">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
<!--                 <li class="nav-item">
                    <a href="#" class="nav-link quick-sidebar-toggler">
                        <i class="flaticon-shapes-1"></i>
                    </a>
                </li> -->
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->    
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'navbar',
    created() {      
        this.$store.dispatch('LOAD_PERFIL_USER')   
    },    
    data() {
        return {
            dataPassword: {
                antPass:'',
                newPass:'',
                repPass:''
            }                     
        }
    },
    computed: {
        ...mapState(['perfil_user','user_system']),
    },    
    methods: {
        logout() {
            this.$store.dispatch('LOGOUT').then(() => {          
                this.$router.push({ name: 'login' })
            })
        },
        loadForm: function(){
            this.dataPassword = {
                antPass:'',
                newPass:'',
                repPass:''
            }      
            this.$modal.show('Formpassword')
        },
        changePassword: function()
        {
            var url = '/api/users/changepassword'
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            axios.post(url, this.dataPassword).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                //toastr.error(resultado);
                toastr.error("Hubo un error en el proceso: verifique los datos ingresados ");
                return;
            }
            this.$modal.hide('Formpassword');
            this.errors = [];
            toastr.success('se realizo el cambio de clave correctamente');
            }).catch(error => {
            this.errors = error.response.data.status;
            this.$modal.hide('Formpassword');
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });

        },               
    }        

}
</script>