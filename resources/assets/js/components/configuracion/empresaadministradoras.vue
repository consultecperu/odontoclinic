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
                <div class="card-header">                        
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nueva Empresa</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="empresas"
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
        <modal name="empresa" :width="'70%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Empresa Administradora</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="razon">Razón Social <span class="required-label">*</span></label>
                                    <input type="text" id="razon" placeholder="Razón social" class="form-control form-control-sm mayusculas" v-model="dataEmpresa.nombre_empresa" required />
                                </div>
                              
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="ruc">RUC <span class="required-label">*</span></label>
                                    <input type="text" id="ruc" placeholder="RUC" class="form-control form-control-sm" maxlength="11" v-model="dataEmpresa.ruc" required />
                                </div>                                  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono <span class="required-label">*</span></label>
                                    <input type="text" id="telefono" placeholder="Teléfono" class="form-control form-control-sm" v-model="dataEmpresa.telefono" required />
                                </div>
                              
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="celular">Celular <span class="required-label">*</span></label>
                                    <input type="text" id="celular" placeholder="Celular" class="form-control form-control-sm" v-model="dataEmpresa.celular" required />
                                </div>                                  
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email </label>
                                    <input type="email" id="email" placeholder="Email" class="form-control form-control-sm" v-model="dataEmpresa.email" />
                                </div>
                              
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="teladicional">Telef. Adicional </label>
                                    <input type="text" id="teladicional" placeholder="Teléfono adicional" class="form-control form-control-sm" v-model="dataEmpresa.telef_adicional" />
                                </div>                                  
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="representante">Representante Legal</label>
                                    <input type="text" id="representante" placeholder="Representante" class="form-control form-control-sm" v-model="dataEmpresa.representante_legal" />
                                </div>                              
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <div class="select2-input">
                                            <select id="basic" name="basic" class="form-control form-control-sm" v-model="coddepa" @change="onchangeDepa">
                                                <option value="">&nbsp;</option>
                                                <option v-for="depa in departamentos" :value="depa.coddepa" :key="depa.id">
                                                    {{ depa.descripcion}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        <div class="select2-input">
                                            <select id="basic2" name="basic" class="form-control form-control-sm" v-model="codprov" @change="onchangeProv">
                                                <option value="">&nbsp;</option>
                                                <option v-for="prov in provincias" :value="prov.codprov" :key="prov.id">
                                                    {{ prov.descripcion}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Distrito</label>
                                        <div class="select2-input">
                                            <select id="basic3" name="basic" class="form-control form-control-sm" v-model="dataEmpresa.ubigeo_id" @change="onchangeDist">
                                                <option value="">&nbsp;</option>
                                                <option v-for="dist in distritos" :value="dist.id" :key="dist.id">
                                                    {{ dist.descripcion}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                        
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" id="direccion" placeholder="Dirección" class="form-control form-control-sm" v-model="dataEmpresa.direccion" />
                                </div>                              
                            </div>                        
                        </div>                                             

                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionEmpresa" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('empresa')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de laboratorios -->
        </modal>                         
    </div>       
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'empresaadministradoras',
    mixins: [mixin],    
    mounted() {
        this.$store.dispatch('LOAD_UBIGEOS_LIST')
        this.$store.dispatch('LOAD_EMPRESAS_LIST').then(() => {
            this.isLoading = false
        })                       
    },     
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            searchText: '', // If value is falsy, reset searchText & searchItem

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',  
            
            coddepa:'',
            codprov:'',
            coddist:'',

            columns: [
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },  
                {
                label: 'Nombre',
                field: 'nombre_empresa',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                }, 
                {
                label: 'Dirección',
                field: 'direccion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                }, 
                {
                label: 'Teléfono',
                field: 'telefono',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                }, 
                {
                label: 'Celular',
                field: 'celular',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                }, 
                {
                label: 'Representante',
                field: 'representante_legal',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                },                                                                                                                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'15%',  
                }                               
            ],  
            dataEmpresa : {
                nombre_empresa:'',
                ruc:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                telef_adicional:'',
                email:'',
                representante_legal:'',
                logo:'',
                user_id:''
            },                                                               
            errors:[] ,          

        }
    },
    computed: {
        ...mapState(['empresas','user_system']),
        ...mapGetters(['getubigeos']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00');
        }        
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },        
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                 
            
            this.coddepa =''
            this.codprov =''
            this.coddist =''           

            this.dataEmpresa = {
                nombre_empresa:'',
                ruc:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                telef_adicional:'',
                email:'',
                representante_legal:'',
                logo:'',
                user_id:this.user_system.id
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
            var url = '/api/empresas';
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
            this.$store.dispatch('LOAD_EMPRESAS_LIST')    
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
            var url = '/api/empresas/'+this.dataEmpresa.id; 
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
                this.$store.dispatch('LOAD_EMPRESAS_LIST')                  
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
                nombre_empresa:dataemp.nombre_empresa,
                ruc:dataemp.ruc,
                ubigeo_id:dataemp.ubigeo_id,
                direccion:dataemp.direccion,
                telefono:dataemp.telefono,
                celular:dataemp.celular,
                telef_adicional:dataemp.telef_adicional,
                email:dataemp.email,
                representante_legal:dataemp.representante_legal,
                user_id:dataemp.user_id,
                logo:dataemp.logo,
            }             
            
            this.coddepa = dataemp.ubigeo.coddepa;
            this.codprov = dataemp.ubigeo.codprov;
            this.coddist = dataemp.ubigeo.coddist;           

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
                        var url = '/api/empresas/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_EMPRESAS_LIST').then(() => {
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
        onchangeDepa: function(){
            //this.coddepa = this.departamento;
            console.log('depa',this.coddepa)

        },
        onchangeProv: function(){
            //this.codprov = this.provincia;
            console.log('prov',this.codprov)
        },
        onchangeDist: function(){
            //this.coddist = this.distrito;
            console.log('dist',this.coddist)
        },                       
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
