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
                <div class="card-header pr-0">                        
                    <div class="col pl-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-technology-1"></i></span> Nuevo Laboratorio</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="laboratorios"
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
                                <button type="button" class="btn btn-border btn-primary btn-xs" v-tooltip="'Ver Servicios'" @click.prevent="cargaServicios(props.row.id)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                  
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Laboratorio'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Laboratorio'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="laboratorio" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de laboratorios -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} de Laboratorio</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group pt-0">
                            <label for="nombre" class="text-primary font-weight-bold">Nombre de Laboratorio <span class="required-label"> *</span></label>
                            <input type="text" id="nombre" placeholder="Nombre de laboratorio" class="form-control form-control-sm mayusculas border border-primary" v-model="dataLaboratorio.nombre_laboratorio">
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionLaboratorio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('laboratorio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    name: 'laboratorios',
    mixins: [mixin],     
    mounted() {
        this.$store.dispatch('LOAD_LABORATORIOS_LIST').then(() => {
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
            columns: [
                {
                label: 'Nombre de Laboratorio',
                field: 'nombre_laboratorio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'65%',
                },    
                {
                label: 'Nro.Servicios',
                field: this.fieldFn,
                tdClass: 'center',
                thClass: 'center',                
                width:'15%',
                },                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                thClass: 'center',
                html: true  ,
                width:'20%',  
                }                               
            ],  
            dataLaboratorio : {
                nombre_laboratorio:'',
                user_id:''
            },                                                               
            errors:[]                          
        }
    },
    computed: {
        ...mapState(['laboratorios','user_system']),
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },          
        LoadForm: function(){      
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                    
            this.dataLaboratorio = {
                nombre_laboratorio:'',
                user_id: this.user_system.id
            }       
            this.labelAccion = "Registro"    
            this.$modal.show('laboratorio')
        }, 
        ActionLaboratorio: function(){
            if(typeof(this.dataLaboratorio.id) === "undefined"){
                this.createLaboratorio()
            }else{
                this.updateLaboratorio()
            }
        },
        createLaboratorio: function(){
            var url = '/api/laboratorios';
            this.StatusForm(true,'la la-spinner','Procesando')         
            axios.post(url, this.dataLaboratorio).then(response => {
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
            this.$store.dispatch('LOAD_LABORATORIOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')              
            this.$modal.hide('laboratorio');
            this.notificaciones('Nuevo Laboratorio creado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updateLaboratorio: function(){
            var url = '/api/laboratorios/'+this.dataLaboratorio.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataLaboratorio).then(response => {
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
                this.$store.dispatch('LOAD_LABORATORIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
                this.$modal.hide('laboratorio');
                this.notificaciones('el Laboratorio fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                              

            });
        },
        processEdit(params){
            var datalab = []
            datalab = _.clone(params.row)
            this.dataLaboratorio = {
                id:datalab.id,
                nombre_laboratorio:datalab.nombre_laboratorio 
                                          
            }   
            this.labelAccion = "Actualización"         
            this.$modal.show('laboratorio')
        
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
                        var url = '/api/laboratorios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_LABORATORIOS_LIST').then(() => {
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
        cargaServicios: function(id){
            this.$router.push({ name: 'detallelaboratorio', params: { laboratorio: id }})
        },
        fieldFn(rowObj) {
            return rowObj.laboratorioservicios.length
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
