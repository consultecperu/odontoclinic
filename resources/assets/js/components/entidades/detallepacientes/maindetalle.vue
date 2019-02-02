<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-profile card-secondary">
                <div class="card-header" style="background-image: url('/img/blogpost.jpg')">
                    <div class="profile-picture">
                        <img v-if="imagenPerfil" :src="imagenPerfil" alt="Imagen de Perfil objeto">
                        <img v-if="!imagenPerfil" :src="'/images/pacientes/' + dataPacienteMain.foto" alt="Imagen de Perfil db">                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{ dataPacienteMain.numero_documento }}</div>
                        <div class="job">{{ dataPacienteMain.nombre_completo }}</div>
                        <div class="desc"> SEDE : {{ dataPacienteMain.sede.nombre_sede}}</div>

                        <div class="view-profile">
                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" @change="onFileChange" >
                            <label for="uploadImg" class=" label-input-file text-white btn btn-icon btn-secondary"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                        </div>
                        <div class="seperator-solid"></div>                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 pl-10 pr-10">
                            <div class="nav flex-column nav-pills nav-secondary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <router-link :to="{ name: 'datos' }" class="nav-link" id="v-pills-datos-tab" data-toggle="pill" href="#v-pills-datos" role="tab" aria-controls="v-pills-datos" aria-selected="true" exact>Datos Generales</router-link>
                                <router-link :to="{ name: 'derivaciones' }" class="nav-link" id="v-pills-derivaciones-tab" data-toggle="pill" href="#v-pills-derivaciones" role="tab" aria-controls="v-pills-derivaciones" aria-selected="false" exact>Derivaciones</router-link>
                                <router-link :to="{ name: 'citas-paciente' }" class="nav-link" id="v-pills-citas-tab" data-toggle="pill" href="#v-pills-citas" role="tab" aria-controls="v-pills-citas" aria-selected="false" exact>Citas</router-link>
                                <router-link :to="{ name: 'multimedia' }" class="nav-link" id="v-pills-multimedia-tab" data-toggle="pill" href="#v-pills-multimedia" role="tab" aria-controls="v-pills-multimedia" aria-selected="false" exact>Imagenes y Archivos</router-link>
                                <div class="seperator-solid"></div>
                                <router-link :to="{ name: 'lista-ppto-operatoria' }" class="nav-link" id="v-pills-operatoria-tab" data-toggle="pill" href="#v-pills-operatoria" role="tab" aria-controls="v-pills-operatoria" aria-selected="true" exact>Ppto. Operatoria</router-link>
                                <router-link :to="{ name: 'lista-ppto-ortodoncia' }" class="nav-link" id="v-pills-ortodoncia-tab" data-toggle="pill" href="#v-pills-ortodoncia" role="tab" aria-controls="v-pills-ortodoncia" aria-selected="false" exact>Ppto. Ortodoncia</router-link>
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
    },
    data(){
        return {
            isLoading: true,
            fullPage: true, 

            dataPacienteMain: {},
            imagenPerfil:null
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
                            this.isLoading = false
                            this.$swal(
                            'Actualizado!',
                            'Este registro fue actualizado.',
                            'success'
                            )                   
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

</style>


