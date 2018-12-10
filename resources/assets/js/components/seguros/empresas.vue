<template>
    <div class="row">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>  
        <div class="col">
            <!-- START DEFAULT DATATABLE -->
            <div class="card text-white bg-white mb-3">
                <div class="card-header pl-0 pr-0">                        
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-agenda-1"></i></span> Nueva Empresa</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="empresapacientes"
                    :paginationOptions="{
                        enabled: true,
                        dropdownAllowAll: false,
                        nextLabel: 'Sig',
                        prevLabel: 'Ant',
                        rowsPerPageLabel: 'Registros por Pagina',
                        ofLabel: 'de',
                        allLabel: 'Todos',
                    }"
                    @on-row-dblclick="processEdit"
                    :rowStyleClass="'enlace'"
                    :lineNumbers="true"
                    styleClass="vgt-table condensed bordered striped">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" class="btn btn-border btn-primary btn-xs" v-tooltip="'Ver Aseguradoras'" @click.prevent="cargaAseguradora(props.row.id)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                  
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Empresa'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Empresa'" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>                                
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                         
                    </vue-good-table>
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->                                   
        </div> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="empresa" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nueva Empresa</div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">RUC</label>
                                <input type="text" id="ruc" class="form-control form-control-sm border border-primary" maxlength="11" v-model="dataEmpresa.ruc">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Razón Social </label>
                                <input type="text" id="razonsocial" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.razon_social">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Direccion </label>
                                <input type="text" id="direccion" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.direccion">
                            </div>                            
                        </div>                            
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Email </label>
                                <input type="email" id="email" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.email">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Teléfono </label>
                                <input type="text" id="telefono" class="form-control form-control-sm border border-primary" maxlength="9" v-model="dataEmpresa.telefono">
                            </div>                            
                        </div>                       
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionEmpresa" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('empresa')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de empresas -->
        </modal>                         
    </div>        
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'empresapacientes',
    mixins: [mixin],  
    mounted() {    
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST').then(() => {
            this.isLoading = false
        })                          
    },     
    data() {
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',  
            columns: [
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                }, 
                {
                label: 'Nombre',
                field: 'razon_social',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },
                {
                label: 'Telefonos',
                field: 'telefono',
                width:'20%',
                },                                                                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'20%',  
                }                               
            ],
            dataEmpresa : {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                user_id:'',
                codigo:'',
            },                                                               
            errors:[] , 
        }
    },
    computed: {
        ...mapState(['empresapacientes','user_system']),
        ...mapGetters(['getplanes_aseguradoras']),        
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataEmpresa = {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                codigo:'',
                user_id: this.user_system.id
            }           
            this.$modal.show('empresa')
        }, 
        ActionEmpresa: function(){
            if(typeof(this.dataEmpresa.id) === "undefined"){
                this.createEmpresa()
            }else{
                this.updateEmpresa()
            }
        },
        createEmpresa: function(){
            var url = '/api/empresapacientes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataEmpresa).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }

            this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('empresa');   
            this.notificaciones('Nueva Empresa creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateEmpresa: function(){
            var url = '/api/empresapacientes/'+this.dataEmpresa.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataEmpresa).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }   
                    this.StatusForm(false,'la la-cloud-download','Grabar Datos')
                    this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                 
                    return;
                }

                this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('empresa');  
                this.notificaciones('la Empresa fue actualizada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var dataemp = []
            dataemp = _.clone(params.row)
            this.dataEmpresa = {
                id:dataemp.id,
                ruc:dataemp.ruc,
                razon_social:dataemp.razon_social,
                ubigeo_id:dataemp.ubigeo_id,
                direccion:dataemp.direccion,
                telefono:dataemp.telefono,
                celular:dataemp.celular,
                email:dataemp.email,
                codigo:dataemp.codigo,
                user_id: this.user_system.id                                      
            }            
            this.$modal.show('empresa')
        
        },
        processDelete(id){
            this.$swal({
                title: 'Desea eliminar este registro?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/empresapacientes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST').then(() => {
                                this.isLoading = false
                                this.$swal(
                                'Eliminado!',
                                'Este registro fue eliminado.',
                                'success'
                                )
                            })                    
                        });
                    }
                });
        },
        cargaAseguradora: function(id){
            this.$router.push({ name: 'detalleempresa', params: { empresa: id }})
        } 
    }       
}
</script>
<style scoped>
    .v--modal-overlay {
        z-index:9000;     
    }    

    .vld-overlay.is-full-page {
        z-index: 99999;
    }
</style>