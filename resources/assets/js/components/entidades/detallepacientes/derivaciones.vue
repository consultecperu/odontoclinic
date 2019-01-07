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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-repeat"></i></span> Agregar Derivación</button>
<!--                         <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
 -->                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="derivaciones"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Ver Derivación'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                            </span>
                            <span v-else-if="props.column.field == 'indicador'">
                                <span v-if="props.row.indicador == 1" class="center badge badge-danger">{{ 'DERIVADO' }}</span>
                                <span v-if="props.row.indicador == 2" class="center badge badge-primary">{{ 'RECIBIDO' }}</span>
                                <span v-if="props.row.indicador == 3" class="center badge badge-warnning">{{ 'DEVUELTO'}}</span>
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
        <!-- form para seleccionar la empresa -->
        <modal id="servicios" name="servicios" width="50%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione un Tratamiento</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('servicios')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_servicios"
                        :rows="servicios"
                        :paginationOptions="{
                            enabled: true,
                            dropdownAllowAll: false,
                            nextLabel: 'Sig',
                            prevLabel: 'Ant',
                            rowsPerPageLabel: 'Registros por Pagina',
                            ofLabel: 'de',
                            allLabel: 'Todos',
                        }"
                        :rowStyleClass="'enlace'"
                        @on-row-click="selectServicio"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectServicio(props)">
                                    Seleccionar
                                </button>                                                               
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                    
                        </vue-good-table>
                        <!-- END DEFAULT DATATABLE -->  
                     </div>
                </div>
            </div>                                
        </modal>          
        <!-- PAGE CONTENT MODAL -->  
        <modal name="derivacion" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de campañas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} Derivación</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-group-default border border-primary">
                                    <label for="tipodoc" class="text-primary font-weight-bold">Dr. que deriva : <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm" id="tipodoc" v-model="dataDerivacion.empleadoderivante_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                            {{ med.nombre_completo}}
                                        </option>
                                    </select>
                                </div>                             
                            </div>
                            <div class="col-6">
                                <div class="form-group form-group-default border border-primary">
                                    <label for="tipodoc" class="text-primary font-weight-bold">Deriva a : <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm" id="tipodoc" v-model="dataDerivacion.empleadoderivado_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                            {{ med.nombre_completo}}
                                        </option>
                                    </select>
                                </div>                             
                            </div>                                                        
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Tratamiento :</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-primary font-weight-bold" placeholder="Nombre de Tratamiento" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="nom_ser" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('servicios')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                    </div>
                                </div>                           
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-0 pl-0 pr-0">
                                    <label for="motivo" class="text-primary font-weight-bold">Motivo <span class="required-label"> *</span></label>
                                    <textarea class="form-control form-control-sm border border-primary" id="comment" rows="3" v-model="dataDerivacion.motivo">

                                    </textarea>
                                </div>                                
                            </div>
                        </div>                                          
                    </div>
                    <div class="card-action pt-15 pb-15">
                        <button class="btn btn-primary" @click.prevent="ActionDerivacion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('derivacion')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de campañas -->
        </modal>                              
    </div>     
</template>
<script>
import mixin from '../../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'derivaciones',
    mixins: [mixin],
    mounted(){    
        this.$store.dispatch('LOAD_SERVICIOS_LIST')
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')   
        this.$store.dispatch('LOAD_DERIVACIONES_LIST').then(() => {
            this.isLoading = false
        })  
    },          
    data(){
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 
            labelAccion:'',
            
            columns: [
                {
                label: 'Doctor que deriva',
                field: 'empleadoderivante.nombre_completo',
                width:'32%',
                }, 
                {
                label: 'Derivado a',
                field: 'empleadoderivado.nombre_completo',             
                width:'25%',
                },
                
                {
                label: 'Fec. Registro',
                field: 'fecha_registro',   
                type: 'date',
                dateInputFormat: 'YYYY-MM-DD', 
                dateOutputFormat: 'DD-MM-YYYY', 
                thClass:'center',
                tdClass:'center',                             
                width:'18%',
                }, 
                {
                label: 'Estado',
                field: 'indicador',
                thClass:'center',
                tdClass:'center',                 
                width:'15%',
                },                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],
            columns_servicios: [
                {
                label: 'Tratamiento',
                field: 'nombre_servicio',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'75%',
                },                                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'25%',  
                }                               
            ], 
            dataDerivacion: {
                empleadoderivante_id:'',
                empleadoderivado_id:'',
                paciente_id:'',
                servicio_id:'',
                user_id:'',
                fecha_registro:'',
                indicador:1
            },
            nom_ser:'',
            errors:[]           
            
        }
    },
    computed: {
        ...mapState(['empleados','user_system','servicios']),
        ...mapGetters(['getDerivacionesById','getMedicos']),  
        derivaciones(){
            return this.getDerivacionesById(this.$route.params.idpaciente)
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
            this.labelAccion = "Agregar"  
            this.nom_ser = ''      

            this.dataDerivacion = {
                empleadoderivante_id:'',
                empleadoderivado_id:'',
                paciente_id:this.$route.params.idpaciente,
                servicio_id:'',
                user_id:this.user_system.id,
                fecha_registro:moment().format('DD-MM-YYYY'),
                indicador:1  
            }                    
            this.$modal.show('derivacion')                                                
        },  
        ActionDerivacion: function(){
            if(typeof(this.dataDerivacion.id) === "undefined"){
                this.createDerivacion()
            }else{
                this.updateDerivacion()
            }
        },               
        createDerivacion: function(){
            var url = '/api/derivaciones';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataDerivacion).then(response => {
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

            this.$store.dispatch('LOAD_DERIVACIONES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('derivacion');   
            this.notificaciones('Derivación creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateDerivacion: function(){
            var url = '/api/derivaciones/'+this.dataDerivacion.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataDerivacion).then(response => {
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
                this.$store.dispatch('LOAD_DERIVACIONES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('derivacion');  
                this.notificaciones('Derivacion actualizada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datader = []
            datader = _.clone(params.row)
            this.dataDerivacion = {
                id:datader.id,
                empleadoderivante_id:datader.empleadoderivante_id,
                empleadoderivado_id:datader.empleadoderivado_id,
                paciente_id:datader.paciente_id,
                servicio_id:datader.servicio_id,
                user_id:datader.user_id,
                fecha_registro:datader.fecha_registro,
                indicador:datader.indicador,
                motivo:datader.motivo                         
            }     
            this.nom_ser = datader.servicio.nombre_servicio  
            this.labelAccion = "Actualizar"     
            this.$modal.show('derivacion')        
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
                        var url = '/api/derivaciones/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_DERIVACIONES_LIST').then(() => {
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
        selectServicio: function(params){
            this.dataDerivacion.servicio_id = params.row.id
            this.nom_ser = params.row.nombre_servicio
            this.$modal.hide('servicios')           
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
    #servicios {
        z-index:999999;
    } 
    .form-control-sm {
        font-size: .680rem !important;
    }
    .form-group-default label:not(.error) {
        font-size: 9.5px !important;
    }         
</style>