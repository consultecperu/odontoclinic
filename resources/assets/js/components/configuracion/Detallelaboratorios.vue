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
				    <div class="card-category">Laboratorio :</div>                    
                    <div class="card-title">{{ laboratorio.nombre_laboratorio}} </div> 
                    <div class="col border-top pt-20 pl-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Servicio</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="detalle_laboratorio"
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
                                <button type="button" class="btn btn-border btn-primary btn-xs" v-tooltip="'Ver Servicios Multident'" @click.prevent="CargaServiciosMultident(props.row)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                                                 
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Servicio'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Servicio'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="servicio" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de planes -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} Servicio</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Nombre del Servicio <span class="required-label"> *</span></label>
                                    <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataLabservicio.nombre_servicio">
                                </div>
                            </div>
                        </div>
                        <div class="row pl-20">
                            <div class="col-12 pl-6 pb-10 pr-30">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Moneda <span class="required-label"> *</span></label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataLabservicio.moneda_id">
                                        <option value="">--Seleccione--</option>
                                        <option v-for="moneda in monedas" :value="moneda.id" :key="moneda.id">
                                            {{ moneda.nombre_moneda}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Monto <span class="required-label"> *</span></label>
                                    <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataLabservicio.costo_lab">
                                </div>
                            </div>                            
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Monto Doctor <span class="required-label"> *</span></label>
                                    <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataLabservicio.costo_doctor">
                                </div>                               
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionServicio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('servicio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de planes -->
        </modal>                         
    </div>     
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detalle_laboratorios',
    mixins: [mixin],  
    mounted() {   
        this.$store.dispatch('LOAD_LABORATORIOS_LIST')        
        this.$store.dispatch('LOAD_MONEDAS_LIST')        
        this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST').then(() => {
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
                label: 'Servicio',
                field: 'nombre_servicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },
                {
                label: 'Nº Servicios',
                field: this.fieldFn,
                width:'15%',
                },                     
                {
                label: 'Costo',
                field: 'costo_lab',
                width:'15%',
                }, 
                {
                label: 'Moneda',
                field: 'moneda.nombre_moneda',
                width:'15%',
                },                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'15%',  
                }                               
            ],  
            dataLabservicio : {
                laboratorio_id:'',
                fase_id:'',
                costo_lab:'',
                costo_doctor:'',
                nombre_servicio:'',
                moneda_id:'',
                user_id:''
            },                                                      
            errors:[] ,              

        }
    },
    computed: {
        ...mapState(['laboratorios','servicios','user_system','monedas','laboratorioservicios']),
        detalle_laboratorio: function(){
            if(this.laboratorioservicios.length > 0){
                return this.laboratorioservicios.filter((lab) => lab.laboratorio_id == this.$route.params.laboratorio)
            }
            return []
        },
        laboratorio: function(){
            return this.laboratorios.find((lab) => lab.id == this.$route.params.laboratorio)
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

            this.dataLabservicio = {
                laboratorio_id:this.$route.params.laboratorio,
                fase_id:'',
                costo_lab:'',
                costo_doctor:'',
                nombre_servicio:'',
                moneda_id:'',
                user_id:this.user_system.id
            }   
            this.labelAccion = "Añadir"    
            this.$modal.show('servicio')
        }, 
        ActionServicio: function(){
            if(typeof(this.dataLabservicio.id) === "undefined"){
                this.createServicio()
            }else{
                this.updateServicio()
            }
        },
        createServicio: function(){
            var url = '/api/laboratorioservicios';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataLabservicio).then(response => {
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

            this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST')   
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('servicio');   
            this.notificaciones('Nuevo Servicio agregado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateServicio: function(){
            var url = '/api/laboratorioservicios/'+this.dataLabservicio.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataLabservicio).then(response => {
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

                this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('servicio');  
                this.notificaciones('el Servicio fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var dataser = []
            dataser = _.clone(params.row)
            this.dataLabservicio = {
                id:dataser.id,
                laboratorio_id:dataser.laboratorio_id,
                fase_id:dataser.fase_id,
                costo_lab:dataser.costo_lab,
                costo_doctor:dataser.costo_doctor,
                nombre_servicio:dataser.nombre_servicio,
                moneda_id:dataser.moneda_id,
                user_id:this.user_system.id                                                     
            }   
            this.labelAccion = "Actualizar"
            this.$modal.show('servicio')        
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
                        var url = '/api/laboratorioservicios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST').then(() => {
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
        CargaServiciosMultident(valor){
            console.log("valor",valor)
            this.$router.push({ name: 'detallelaboratoriomultident', params: { laboratorioservicio: valor.id , laboratorio : valor.laboratorio.id , servicio: valor.nombre_servicio}})
        },        
        fieldFn(rowObj) {
            return rowObj.servicios.length
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

    .pl-6 {
        padding-left: 6px !important;
    }
</style>
