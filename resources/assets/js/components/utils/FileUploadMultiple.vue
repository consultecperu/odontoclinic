<template>
    <div class="well col-12 border border-default">
        <div class="row">
            <div class="col-4 mt-20">
                <label for="images_uploads_pdf" class="btn btn-primary btn-sm text-white font-weight-bold mb-0 pt-10 pb-10"><span class="btn-label"><i class="la la-plus"></i></span> Seleccionar Archivos PDF</label>
                <input
                    type="file"
                    id = "images_uploads_pdf"
                    :name="name"
                    :accept="accept"
                    @change="change"
                    :multiple="multiple"
                />
            </div>
            <div class="col-4 mt-20" v-if="data_pdf.files_pdf != 0 && !loading">
                <button class="btn btn-success btn-sm" @click.prevent="UploadFiles"><i class="la la-cloud-upload"></i> Subir <span class="badge">{{ data_pdf.files_pdf.length }}</span> Archivos</button>
            </div> 
            <div class="col-4 mt-20" v-if="loading">
                <span class="text-primary"><i class="la la-refresh la-spin la-2x la-fw"></i> Subiendo Archivos ...</span>
            </div>  
        </div>
        <div class="row">
            <div class="preview col-12">
                <p v-if="data_pdf.files_pdf.length == 0 " >No hay archivos seleccionados</p>
                <table class="table table-sm table-striped jambo_table bulk_action" v-if="data_pdf.files_pdf != 0">
                    <thead>
                        <tr class="headings">
                            <th class="column-title" width="60%">Nombre del Archivo </th>
                            <th class="column-title" width="20%">Tamaño </th>
                            <th class="column-title text-right" width="20%">Accion </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(file, index) in data_pdf.files_pdf" :key="file.name">
                            <td>{{ file.name }}</td>
                            <td>{{ file.size | returnFileSize }}</td>
                            <td align="right"><button type="button" class="btn btn-danger btn-xs" @click.prevent="DeleteFile(index)"><i class="la la-trash"></i> Borrar</button></td>
                        </tr>                    
                    </tbody>  
                </table>
            </div>
        </div>

    </div>
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
    export default {
        props: {
            name: {
                type: String,
                default: 'file',
            },

            accept: {
                type: String,
            },

            multiple: {
                type: Boolean,
            },

            postAction: {
                type: String,
            },

            putAction: {
                type: String,
            },

            size: {
                type: Number,
                default: 0,
            },

            value: {
                type: Array,
                default: Array,
            },

            extensions: {
                default: Array,
            },            
        }, 
        mixins: [mixin],          
        mounted(){
            this.$parent.$on('send', (pac) => {
                this.idpac = pac;
            })
        },      
        data() {
            return {
                data_pdf : {
                    name : 'pdf',
                    files_pdf : []                    
                },
                postFormData: new FormData(),
                loading : false ,
                idpac: ''          
            }
        },
        methods : {
            change(e){
                let files = []
                if (e.target.files) {
                    this.postFormData.delete('files_pdf[]')
                    for (let i = 0; i < e.target.files.length; i++) {
                        let file = e.target.files[i]
                        if(file.type === 'application/pdf'){
                            this.postFormData.append('files_pdf[]', file);
                            files.push({
                                size: file.size,
                                name: file.name,
                                type: file.type,
                                file,
                                e
                            })
                        }

                    }
                } else {
                    files.push({
                        name: e.target.value.replace(/^.*?([^\/\\\r\n]+)$/, '$1'),
                        e,
                    })
                }
                this.data_pdf.files_pdf = files               
            },
            UploadFiles(){
                this.loading = true
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }                
                var url ="/api/uploadPdf"
                this.postFormData.append('id', this.idpac)
                axios.post(url,this.postFormData, config).then(response => {
                    if(typeof(response.data.errors) != "undefined"){
                        this.errors = response.data.errors;
                        var resultado = "";
                        for (var i in this.errors) {
                            if (this.errors.hasOwnProperty(i)) {
                                resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                            }
                        }
                        this.notificaciones('Hubo un error en el proceso: '+ resultado ,'la la-thumbs-o-down','danger')                        
                        this.loading = false                                      
                        return;
                    }
                    this.data_pdf = {
                        name : 'pdf',
                        files_pdf : []  
                    }  
                    this.postFormData.delete('files_pdf[]')
                    this.$emit('upload-complete')    
                    this.errors = [];
                    this.loading = false
                    this.notificaciones('se subieron los archivos correctamente','la la-thumbs-up','success') 
                }).catch(error => {
                    this.errors = error.response.data.status;
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')                 
                    this.loading = false
                });                
            },
            DeleteFile(key){
                this.data_pdf.files_pdf.splice(key, 1)
                this.updateFormData()
            },
            updateFormData(){
                this.postFormData.delete('files_pdf[]')
                for (let index = 0; index < this.data_pdf.files_pdf.length; index++) {
                    const element = this.data_pdf.files_pdf[index].file;
                    this.postFormData.append('files_pdf[]', element);
                }                
            },           

        },
        filters:{
            returnFileSize(number){
                if(number < 1024) {
                    return number + 'bytes';
                } else if(number > 1024 && number < 1048576) {
                    return (number/1024).toFixed(1) + 'KB';
                } else if(number > 1048576) {
                    return (number/1048576).toFixed(1) + 'MB';
                }
            }
        }        
    }
</script>
<style scoped>
    input[type="file"] {
        display: none;
    }
    .custom-file-upload {
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #337ab7;
        display: inline-block;
        padding: 5px 12px;
        cursor: pointer;
        color: white;
        width: 100%;
    } 
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    .btn-xs {
        padding: 3px !important;
    }      
</style>
