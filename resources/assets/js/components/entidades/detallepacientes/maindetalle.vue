<template>
    <div class="row">
        <div class="col-md-3 div-left">
            <div class="card card-profile card-primary">
                <div class="card-header">
                    <div class="profile-picture">
                        <img v-if="imagenPerfil" :src="imagenPerfil" alt="Imagen de Perfil objeto">
                        <img v-if="!imagenPerfil" :src="'/images/pacientes/' + dataPacienteMain.foto" alt="Imagen de Perfil db">                        
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="user-profile text-center">
                        <!-- <div class="name">{{ dataPacienteMain.numero_documento }}</div> -->
                        <div class="job">{{ dataPacienteMain.nombre_completo }}</div>
                        <!-- <div class="desc"> SEDE : {{ dataPacienteMain.sede.nombre_sede}}</div> -->
                        <div class="view-profile">
                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" @change="onFileChange" >
                            <label for="uploadImg" class=" label-input-file text-white btn btn-sm btn-icon btn-info"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                        </div>
                        <div class="seperator-solid"></div>                        
                    </div>
                </div>
                <div class="card-footer pt-0">
                    <div class="row">
                        <div class="col-12 pl-10 pr-10">
                            <div class="nav flex-column nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <router-link :to="{ name: 'datos' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-datos-tab" data-toggle="pill" href="#v-pills-datos" role="tab" aria-controls="v-pills-datos" aria-selected="true" exact>Datos Generales</router-link>
                                <!-- <router-link :to="{ name: 'derivaciones' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-derivaciones-tab" data-toggle="pill" href="#v-pills-derivaciones" role="tab" aria-controls="v-pills-derivaciones" aria-selected="false" exact>Derivaciones</router-link> -->
                                <router-link :to="{ name: 'citas-paciente' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-citas-tab" data-toggle="pill" href="#v-pills-citas" role="tab" aria-controls="v-pills-citas" aria-selected="false" exact>Citas</router-link>
                                <router-link :to="{ name: 'multimedia' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-multimedia-tab" data-toggle="pill" href="#v-pills-multimedia" role="tab" aria-controls="v-pills-multimedia" aria-selected="false" exact>Imagenes y Archivos</router-link>
                                <div class="seperator-solid mt-10 mb-10"></div>
                                <router-link :to="{ name: 'lista-ppto-operatoria' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-operatoria-tab" data-toggle="pill" href="#v-pills-operatoria" role="tab" aria-controls="v-pills-operatoria" aria-selected="true" exact>Ppto. Operatoria</router-link>
                                <router-link :to="{ name: 'lista-ppto-ortodoncia' }" class="nav-link border-odonto pt-5 pb-5" id="v-pills-ortodoncia-tab" data-toggle="pill" href="#v-pills-ortodoncia" role="tab" aria-controls="v-pills-ortodoncia" aria-selected="false" exact>Ppto. Ortodoncia</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 pl-0">
            <div class="tab-content" id="v-pills-tabContent">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import mixin from '../../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detallepacientes',
    mixins: [mixin], 
    created(){
        this.dataPacienteMain = _.clone(this.PacienteById)
        if(this.dataPacienteMain.foto == null){
            this.dataPacienteMain.foto = "no-image.jpg"
        }
    },
    data(){
        return {
            isLoading: true,
            fullPage: true, 

            dataPacienteMain: {},
            imagenPerfil:null,

            errors:[]
        }
    },
    computed: {
        ...mapState(['pacientes','user_system']),
        ...mapGetters(['getPacienteById']),
        PacienteById(){
            return this.getPacienteById(this.$route.params.idpaciente)
        }                                    
    },  
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },        
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.dataPacienteMain.image = null;
                this.imagenPerfil = null
                return;
            }
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.dataPacienteMain.image = e.target.result;
                vm.imagenPerfil = vm.dataPacienteMain.image
            };
            reader.readAsDataURL(file); 
            this.processFoto()   
        }, 
        processFoto(){
            this.$swal({
                title: 'Desea cambiar la Foto del Paciente?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, cambiar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/pacientes/actualizafoto/' + this.dataPacienteMain.id;
                        axios.put(url,this.dataPacienteMain).then(response=> {
                        if(typeof(response.data.errors) != "undefined"){
                            this.errors = response.data.errors;
                            var resultado = "";
                            for (var i in this.errors) {
                                if (this.errors.hasOwnProperty(i)) {
                                    resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                }
                            }
                            this.isLoading = false
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                            return;
                        }
                        //this.$store.dispatch('LOAD_PACIENTES_LIST')    
                        this.errors = [];              
                        //this.notificaciones('Paciente actualizado con exito','la la-thumbs-up','success') 
                        this.isLoading = false
                        this.$swal(
                            'Actualizado!',
                            'Este registro fue actualizado.',
                            'success'
                        )                                                 
                        }).catch(error => {
                            this.errors = error.response.data.status;
                            this.isLoading = false
                            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        });
                    }else{
                        this.imagenPerfil = null
                    }
                });
        },              

    },          

}
</script>
<style scoped>
    input[type="file"] {
        display: none;
    }
    .sansSerif {
        font-family:sans-serif !important;
    }  
    .contenedor {
        overflow: hidden;
    }
    .div-left {
        padding-bottom: 100%;
        margin-bottom: -100%;        
    }
    .div-right {
        padding-bottom: 100%;
        margin-bottom: -100%;
    }
    .border-odonto {
        border-color: #c1c4c7 !important;
    } 
    .card-profile .profile-picture{
        bottom: -40px !important;
    }       
</style>


