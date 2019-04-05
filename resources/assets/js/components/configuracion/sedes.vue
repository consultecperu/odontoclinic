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
                    <div class="col pl-0 pr-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-placeholder"></i></span> Nueva Sede</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="sedes"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Sede'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Sede'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="sede" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de laboratorios -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title pl-10">{{ labelAccion }} de Sede</div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-6 pr-0">
                                <div class="form-group pt-0">
                                    <label for="codigo" class="text-primary font-weight-bold mb-0">Codigo <span class="required-label">*</span></label>
                                    <input type="text" id="codigo" class="form-control form-control-sm border border-primary" v-model="dataSede.codigo">
                                </div>
                              
                            </div>
                            <div class="col-6 pl-0">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold mb-0">Nombre de Sede <span class="required-label">*</span></label>
                                    <input type="text" id="nombre" class="form-control form-control-sm mayusculas border border-primary" v-model="dataSede.nombre_sede" required />
                                </div>                                  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 pr-0">
                                <div class="form-group pt-0">
                                    <label for="telefono" class="text-primary font-weight-bold mb-0">Teléfono </label>
                                    <input type="text" id="telefono" class="form-control form-control-sm border-primary" v-model="dataSede.telefono" required />
                                </div>
                              
                            </div>
                            <div class="col-6 pl-0">
                                <div class="form-group pt-0">
                                    <label for="celular" class="text-primary font-weight-bold mb-0">Celular </label>
                                    <input type="text" id="celular" class="form-control form-control-sm border-primary" v-model="dataSede.celular" required />
                                </div>                                  
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-6 pr-0">
                                <div class="form-group pt-0">
                                    <label for="teladicional" class="text-primary font-weight-bold mb-0">Teléfono Adicional</label>
                                    <input type="text" id="teladicional" class="form-control form-control-sm border-primary" v-model="dataSede.telef_adicional" />
                                </div>                              
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-4 pr-0">
                                <div class="form-group pt-0">
                                    <label class="text-primary font-weight-bold mb-0">Departamento <span class="required-label"> *</span></label>
                                    <div class="select2-input">
                                        <select id="basic" name="basic" class="form-control form-control-sm border-primary" v-model="coddepa" @change="onchangeDepa">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="depa in departamentos" :value="depa.coddepa" :key="depa.id">
                                                {{ depa.descripcion}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pr-0 pl-0">
                                <div class="form-group pt-0">
                                    <label class="text-primary font-weight-bold mb-0">Provincia <span class="required-label"> *</span></label>
                                    <div class="select2-input">
                                        <select id="basic2" name="basic" class="form-control form-control-sm border-primary" v-model="codprov" @change="onchangeProv">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="prov in provincias" :value="prov.codprov" :key="prov.id">
                                                {{ prov.descripcion}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pl-0">
                                <div class="form-group pt-0">
                                    <label class="text-primary font-weight-bold mb-0">Distrito <span class="required-label"> *</span></label>
                                    <div class="select2-input">
                                        <select id="basic3" name="basic" class="form-control form-control-sm border-primary" v-model="dataSede.ubigeo_id" @change="onchangeDist">
                                            <option value="">--Seleccione--</option>
                                            <option v-for="dist in distritos" :value="dist.id" :key="dist.id">
                                                {{ dist.descripcion}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>                                                        
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group pt-0 mb-0">
                                    <label for="direccion" class="text-primary font-weight-bold">Dirección</label>
                                    <input type="text" id="direccion" class="form-control form-control-sm border border-primary" v-model="dataSede.direccion" />
                                </div>                              
                            </div>                        
                        </div> 
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0 mb-0">
                                    <label for="tipoplan" class="text-primary font-weight-bold">Tipo Plan por defecto</label>
                                    <p class="form-control-static mt-5 mb-0" >PLAN PARTICULAR</p>
                                </div>                                              
                            </div> 
                            <div class="col-6">
                                <div class="form-group pt-0 mb-0">
                                    <label for="plan" class="text-primary font-weight-bold">Elige el Plan <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm border-primary" id="plan" v-model="dataSede.plan_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="pla in getPlanes" :value="pla.id" :key="pla.id">
                                            {{ pla.descripcion}}
                                        </option>
                                    </select>
                                </div>                                              
                            </div>                                                                                                                                                    
                        </div>                                                                    

                    </div>
                    <div class="card-action pt-20 pb-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('sede')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="ActionSede" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
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
    name: 'sedes',
    mixins: [mixin],      
    mounted() {   
        this.$store.dispatch('LOAD_PLANES_LIST')  
        this.$store.dispatch('LOAD_UBIGEOS_LIST')
        this.$store.dispatch('LOAD_SEDES_LIST').then(() => {
            this.isLoading = false
        })                       
    },     
    data() {
        return {
            isLoading: true,
            fullPage: true,

            labelAccion:'',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',  
            
            coddepa:'',
            codprov:'',
            coddist:'',

            columns: [
                {
                label: 'Codigo',
                field: 'codigo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },  
                {
                label: 'Nombre de Sede',
                field: 'nombre_sede',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                }, 
                {
                label: 'Dirección',
                field: 'direccion',
                width:'20%',
                }, 
                {
                label: 'Teléfono',
                field: 'telefono',
                width:'10%',
                }, 
                {
                label: 'Celular',
                field: 'celular',
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
            dataSede : {
                nombre_sede:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                telef_adicional:'',
                correo:'',
                codigo:'',
                user_id:'',
                plan_id:''
            },                                                               
            errors:[]                          
        }
    },
    computed: {
        ...mapState(['sedes','user_system','planes']),
        ...mapGetters(['getubigeos']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00');
        },
        getPlanes(){
            return this.planes.filter((pla) => pla.tipo == 1)            
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

            this.dataSede = {
                nombre_sede:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                telef_adicional:'',
                correo:'',
                codigo:'',
                user_id:this.user_system.id,
                plan_id:''
            }   
            this.labelAccion = "Registro"                  
            this.$modal.show('sede')
        }, 
        ActionSede: function(){
            if(typeof(this.dataSede.id) === "undefined"){
                this.createSede()
            }else{
                this.updateSede()
            }
        },
        createSede: function(){
            var url = '/api/sedes';
            this.StatusForm(true,'la la-spinner','Procesando')      
            axios.post(url, this.dataSede).then(response => {
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
            this.$store.dispatch('LOAD_SEDES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                  
            this.$modal.hide('sede');
            //this.notificaciones('Nueva Sede creado con exito','la la-thumbs-up','success')            
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')                     
            });
        },
        updateSede: function(){
            var url = '/api/sedes/'+this.dataSede.id;
            this.StatusForm(true,'la la-spinner','Procesando')      
            axios.put(url, this.dataSede).then(response => {
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
                this.$store.dispatch('LOAD_SEDES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')         
                this.$modal.hide('sede');
                this.notificaciones('la Sede fue actualizada con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')                                             
            });
        },
        processEdit(params){
            var datased = []
            datased = _.clone(params.row)
            this.dataSede = {
                id: datased.id,
                nombre_sede : datased.nombre_sede,
                ubigeo_id: datased.ubigeo_id,
                direccion: datased.direccion,
                telefono: datased.telefono,
                celular: datased.celular,
                telef_adicional: datased.telef_adicional,
                correo: datased.correo,
                codigo: datased.codigo,
                user_id: datased.user_id,
                plan_id:datased.plan_id
            }      
            
            this.coddepa = datased.ubigeo.coddepa;
            this.codprov = datased.ubigeo.codprov;
            this.coddist = datased.ubigeo.coddist;           
            this.labelAccion = "Actualización" 
            this.$modal.show('sede')
        
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
                        var url = '/api/sedes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_SEDES_LIST').then(() => {
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
