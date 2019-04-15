<template>
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<!--<h3 class="text-lg-center text-primary font-weight-bold">ODONTOCLOUD</h3>-->
            <div class="border-bottom border-secondary pb-20">
                <img src="/img/logo/dental.png" class="img-fluid" alt="odontoCloud">
            </div>
			<div class="login-form mt-20">
				<div class="form-group form-floating-label">
					<input id="username" name="username" type="text" class="form-control input-border-bottom" v-model="dataLogin.name" required>
					<label for="username" class="placeholder">Usuario</label>
                    <div class="show-password">
						<i class="flaticon-user"></i>
					</div>
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" class="form-control input-border-bottom" v-model="dataLogin.password" @keyup.enter="login" required>
					<label for="password" class="placeholder">Password</label>
					<div class="show-password">
						<i class="flaticon-lock-1"></i>
					</div>
				</div>
<!-- 				<div class="row form-sub mb-20">
					<div class="col col-md-4">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="rememberme">
							<label class="custom-control-label" for="rememberme">Recordarme</label>
						</div>
					</div>
					<div class="col col-md-8 login-forget">
						<a href="#" class="link">Olvidaste tu Password?</a>
					</div>
				</div> -->
				<div class="form-action pb-0">
                    <button class="btn btn-primary btn-login" @click.prevent="login" :disabled="ShowIcon">
                        <span class="btn-label">
                            <i :class="[IconClass]"></i>
                        </span>
                        {{ labelButton }}
                    </button>                    
				</div>
<!-- 				<div class="login-account">
					<span class="msg">Don't have an account yet ?</span>
					<a href="#" id="show-signup" class="link">Sign Up</a>
				</div> -->
			</div>
		</div>
	</div>    
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'login',
    mixins: [mixin],     
    beforeCreate() {
        document.body.className = "login";
    },     
    data() {
        return {
            IconClass : 'la la-sign-in',
            ShowIcon : false,
            labelButton: 'INGRESAR', 
                        
            dataLogin: {
                name: '',
                password: '',
            },  
            errors:[] ,        
        }
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },         
        login() {  
            this.StatusForm(false,'la la-spinner','ACCEDIENDO')                                                                                       

            var url = "/api/login";    
            axios.post(url, this.dataLogin).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }
                    this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                    this.StatusForm(false,'la la-sign-in','INGRESAR')                                                                                       
                    return;
                }

                this.$store.dispatch('SAVE_TOKEN', { user : response.data } ).then(response => {
                    this.$store.dispatch('LOAD_PERFIL_USER')
                }, error => {
                    console.error("Fallo no definido")
                });
                this.StatusForm(false,'la la-sign-in','INGRESAR')                                                                                         
                this.$router.push({ name: 'dashboard' })
                //this.notificaciones('ingreso exitoso','la la-thumbs-up','success')                                 
            }).catch(error => {
                this.StatusForm(false,'la la-sign-in','INGRESAR')
                this.errors = error.response
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                
  
            }); 
        },

    }            
}
</script>