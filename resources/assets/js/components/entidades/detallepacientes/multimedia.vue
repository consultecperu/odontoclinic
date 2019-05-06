<template>
    <div class="card card-with-nav pb-10">
        <div class="card-header">
            <div class="row">
                <ul class="nav nav-tabs nav-line nav-color-danger" role="tablist">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#imagenes" role="tab" aria-selected="true">Imagenes</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#documentos" role="tab" aria-selected="false" @click.prevent="LoadDirectory_pdf">Documentos (PDF)</a> </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="imagenes" role="tabpanel" aria-labelledby="imagenes-tab">
                    <div class="row">
                        <loading :active.sync="isLoading"
                            :background-color="'#000'" 
                            :color="'red'"
                            :can-cancel="false" 
                            :is-full-page="fullPage">
                        </loading>         
                        <div class="col-12 bg-white ml-10 pt-10">
                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="row pl-10 pr-20">
                                        <file-upload-images :accept="accept" :extensions="extensions" :multiple="multiple" :name="name" @upload-complete="actualizame"></file-upload-images>                   
                                        <div class="clearfix"></div>
                                    </div>
                                <div class="clearfix"></div>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-3 col-sm-4 col-xs-6" v-for="archivo in archivos" :key="archivo.name">
                                            <a class="example-image-link" :href="archivo.url.replace('localhost','localhost:8000')" data-lightbox="example-set" :data-title="archivo.name_file">
                                                <img class="img-thumbnail img-fluid" :src="archivo.url.replace('localhost','localhost:8000')">
                                            </a>
                                            <label for="">{{ archivo.name_file}}</label>
                                        </div>                                           
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="tab-pane" id="documentos" role="tabpanel" aria-labelledby="documentos-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="x_panel">
                                <div class="x_content">
<!--                                     <div class="page-title mb-0">
                                        <div class="title_left">
                                            <div class="col-md-6 col-sm-6 col-xs-12 form-group pl-0 pt-0">
                                                <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Buscar ...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button"><span class="btn-label"><i class="la la-search"></i></span></button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div> -->

                                    <div class="panel rounded shadow">
                                        <div class="panel-body no-padding">
                                            <file-upload-multiple :accept="accept_pdf" :extensions="extensions_pdf" :multiple="multiple_pdf" :name="name_pdf" @upload-complete="actualizame_pdf"></file-upload-multiple>
                                            <div class="clearfix"></div>
                                            <div class="row" style="padding-left:20px;padding-right:20px;">
                                                <!-- Start table with actions -->
                                                <div class="table-responsive mb-20">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Item</th>
                                                            <th>Nombre Archivo</th>
                                                            <th>Tamaño</th>
                                                            <th>Fecha Ult.Mod.</th>
                                                            <th class="text-center" style="min-width: 15%">Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(archivo, index) in archivos_pdf" :key="archivo.name">
                                                                <td class="text-center">{{ index + 1}}</td>
                                                                <td><a data-tooltip :href="archivo.url.replace('localhost','localhost:8000')" target="_blank">{{ archivo.name }}</a></td>
                                                                <td>{{ archivo.size | returnFileSize }}</td>
                                                                <td>{{ archivo.time | returnTime }}</td>
                                                                <td class="text-center">
                                                                    <a data-tooltip :href="archivo.url.replace('localhost','localhost:8000')" target="_blank" v-tooltip="'Ver archivo'"><i class="la la-eye"></i></a>
                                                                    <a data-tooltip href="#"  v-tooltip="'eliminar archivo'" @click.prevent="processDelete_pdf(archivo.name)"><i class="la la-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div><!-- /.table-responsive -->
                                            </div>
                                        </div>
                                    </div><!-- /.panel -->
                                    <!--/ End sample validation 1 -->
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div>                                                         
            </div>                            
        </div>                
    </div>
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
export default {
    name: 'multimedia',
    mixins: [mixin],  
    data () {
      return {
        isLoading: false,
        fullPage: true,

        accept: 'image/png,image/jpg,image/gif,image/jpeg',
        extensions: 'pdf',        
        multiple: true,
        name: 'file',
        archivos: [],
        dataFile: {
            file:''
        }, 
        
        accept_pdf: 'application/pdf',
        extensions_pdf: 'pdf',        
        multiple_pdf: true,
        name_pdf: 'file',
        archivos_pdf: [],
        dataFile_pdf: {
            file:''
        },
        errors:''        
      }
    },

    mounted() {
        this.LoadDirectory() 
        //this.LoadDirectory_pdf()   
    },
    updated(){
        this.getMenuClick()
    },    
    methods: {
        LoadDirectory(){
            this.isLoading = true
            var url ="/api/listarImages/"+ this.$route.params.idpaciente
            axios.get(url).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado ,'la la-thumbs-o-down','danger')                        
                this.isLoading = false
                return;
            }
            this.archivos = response.data
            this.$emit('sendimg', {'paciente_id':this.$route.params.idpaciente, 'archivos':this.archivos})
            this.isLoading = false
            }).catch(error => {
            this.isLoading = false
            this.errors = error.response.data.status;
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')                 
            });            
        },
        actualizame(){
            this.LoadDirectory()
        },
        getMenuClick(){ 
            lightbox.option({
                'albumLabel': "Imagen %1 de %2"
            }) 
        },
        LoadDirectory_pdf(){
            this.isLoading = true
            var url ="/api/listarPDF/"+ this.$route.params.idpaciente
            axios.get(url).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.isLoading = false
                return;
            }
            this.archivos_pdf = response.data
            this.$emit('send', this.$route.params.idpaciente)
            this.isLoading = false
            }).catch(error => {
            this.isLoading = false
            this.errors = error.response.data.status;
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')                 
            });            
        },
        actualizame_pdf(){
            this.LoadDirectory_pdf()
        },
        processDelete_pdf(file){
            this.$swal({
                title: 'Desea eliminar este documento?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/deletePDF'
                        this.dataFile_pdf.file = file
                        axios.post(url,this.dataFile_pdf).then(response=> {
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
                            this.errors = [];
                            this.LoadDirectory_pdf() 
                            this.isLoading = false  
                            this.notificaciones('Se elimino el archivo correctamente','la la-thumbs-up','success') 
                        });
                    }
                }).catch(error => {
                    this.isLoading = false
                    this.errors = error.response.data.status;               
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
                });
        }, 
        BuscarPDF(){
            let self = this
            _.each(self.archivos_pdf, function(value,key){
                
            })            
        }          
    },
    filters:{
        returnFileSize : function(number){
            if(number < 1024) {
                return number + 'bytes';
            } else if(number > 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + 'KB';
            } else if(number > 1048576) {
                return (number/1048576).toFixed(1) + 'MB';
            }
        },
        returnTime: function(number ){
            return moment.unix(number).format("DD-MM-YYYY hh:mm:ss")
        }
    }       
}
</script>
<style scoped>
    .modal-dialog {
        width:600px;
    }
    .img-thumbnail {
        margin-bottom:6px !important;
        height: 170px !important;
        overflow: hidden !important;
    }
    .v--modal-overlay {
        z-index:9000;     
    }    
    .vld-overlay.is-full-page {
        z-index: 99999;
    }    
</style>