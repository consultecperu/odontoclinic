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
                    <div class="col-4">
                        <div class="form-group pl-0 pt-0">
                            <label for="basic" class="text-primary font-weight-bold">Sede :</label>
                            <div class="select2-input">
                                <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataSede" placeholder="Seleccione una sede" >
                                    <option value="">-- Seleccione una Sede --</option>
                                    <option v-for="sede in sedes" :value="sede.id" :key="sede.id">
                                        {{ sede.nombre_sede}}
                                    </option>
                                </select>
                            </div>
                        </div>                        
                    </div>                       
                    <div class="col border-top pt-20">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Servicio</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    title="Listado de Planes"
                    :columns="columns"
                    :rows="detalle_tarifario"
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
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-success btn-xs" data-original-title="Actualizar Tarifario" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-danger btn-xs" data-original-title="Eliminar Tarifario" @click.prevent="processDelete(props.row.id)">
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
        <modal name="servicio" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de planes -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Añadir Servicio al Plan</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <span class="col-12 pb-10">
                                <label class="text-primary font-weight-bold">Servicio :</label>
                            </span>                            
<!--                             <div class="col">
                                <vue-bootstrap-typeahead
                                    v-model="searchServicio"
                                    :data="servicios"
                                    placeholder="Buscar Servicio"
                                    :serializer="item => item.nombre_servicio"
                                    class="border border-primary"
                                    size="sm"
                                    @hit="handleHit"
                                    ref="typeahead"    
                                />  
                            </div> -->
                            <div class="col">
                                <autocomplete class="border border-primary rounded"
                                ref="autocomplete"
                                placeholder="Buscar Servicio"
                                :source="servicios"
                                input-class="form-control form-control-sm"
                                results-value="id"
                                results-display="nombre_servicio"
                                @selected="addDistributionGroup">
                                </autocomplete>                                
                            </div>
                        </div>
                        <div class="row pt-20">
                            <div class="col-6">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Moneda :</label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataServicio.moneda_id">
                                        <option v-for="moneda in monedas" :value="moneda.id" :key="moneda.id">
                                            {{ moneda.nombre_moneda}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Monto :</label>
                                    <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataServicio.costo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check pt-0 pb-0 pl-0">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="dataServicio.ortodoncia"/>
                                        <span class="form-check-sign text-primary font-weight-bold">Aplicar como Ortodoncia</span>
                                    </label>
                                </div>                                
                            </div>
                        </div>
                        <div class="row" v-if="dataServicio.ortodoncia">
                            <div class="col-6">
                                <div class="form-group pl-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Cuota Inicial :</label>
                                    <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataServicio.cuota_inicial">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="nombre" class="text-primary font-weight-bold">Control mensual :</label>
                                    <input ref="inputcontrol" type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataServicio.control_mensual">
                                </div>
                            </div>                                                      
                        </div>
                        <div class="row pl-5" v-if="dataServicio.id === undefined">
                            <span class="col-12 pb-10">
                                <label class="text-primary font-weight-bold">Sedes :</label>
                            </span>
                            <div class="form-check col-6 pt-0 pb-0" v-for="sed in sedes" :key="sed.id" >
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" :id="sed.id" :value="sed.id" v-model="dataServicio.sedes" />
                                    <span class="form-check-sign text-primary font-weight-bold">{{ sed.nombre_sede }}</span>
                                </label>
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
    name: 'detalle_tarifarios',
    mixins: [mixin],  
    mounted() {
        this.$store.dispatch('LOAD_SEDES_LIST')        
        this.$store.dispatch('LOAD_MONEDAS_LIST')        
        this.$store.dispatch('LOAD_SERVICIOS_LIST')
        this.$store.dispatch('LOAD_TARIFARIOS_LIST').then(() => {
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
            columns: [
                {
                label: 'Servicio',
                field: 'servicio.nombre_servicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },    
                {
                label: 'Costo',
                field: 'costo',
                width:'15%',
                }, 
                {
                label: 'Moneda',
                field: 'moneda.nombre_moneda',
                width:'15%',
                },
                {
                label: 'Sede',
                field: 'sede.nombre_sede',
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
            dataServicio : {
                sede_id:'',
                servicio_id:'',
                plan_id:'',
                moneda_id:'',
                costo:'',
                tipo:'',
                solocoaseguro:'',
                cuotas:'',
                cuota_inicial:'',
                ortodoncia:0,
                control_mensual:'',
                tarifa:'',
                user_id:'',
                sedes:[]
            }, 
            dataSede:'', 
            searchServicio:'',                                                           
            errors:[] ,              
        }
    },
    computed: {
        ...mapState(['tarifarios','servicios','user_system','sedes','monedas']),
        detalle_tarifario: function(){
            return this.tarifarios.filter((tar) => tar.sede_id == this.dataSede).filter((tar) => tar.plan_id == this.$route.params.plan)
        },        
    },    
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataServicio = {
                sede_id:'',
                servicio_id:'',
                plan_id:this.$route.params.plan,
                moneda_id:'',
                costo:'',
                tipo:1,
                solocoaseguro:'',
                cuotas:'',
                cuota_inicial:'',
                ortodoncia:0,
                control_mensual:'',
                tarifa:0,
                user_id: this.user_system.id,
                sedes:[]
            }           
            this.$modal.show('servicio')
        }, 
        ActionServicio: function(){
            if(typeof(this.dataServicio.id) === "undefined"){
                this.createServicio()
            }else{
                this.updateServicio()
            }
        },
        createServicio: function(){
            var url = '/api/tarifarios';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataServicio).then(response => {
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

            this.$store.dispatch('LOAD_SERVICIOS_LIST')    
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
            var url = '/api/tarifarios/'+this.dataServicio.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataServicio).then(response => {
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

                this.$store.dispatch('LOAD_SERVICIOS_LIST')                  
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
            this.dataServicio = {
                id:dataser.id,
                sede_id:dataser.sede_id,
                servicio_id:dataser.servicio_id,
                plan_id:dataser.plan_id,
                moneda_id:dataser.moneda_id,
                costo:dataser.costo,
                tipo:dataser.tipo,
                solocoaseguro:dataser.solocoaseguro,
                cuotas:dataser.cuotas,
                cuota_inicial:dataser.cuota_inicial,
                ortodoncia:dataser.ortodoncia,
                control_mensual:dataser.control_mensual,
                tarifa:dataser.tarifa,
                user_id: this.user_system.id                                                       
            }   
            console.log("ser:",dataser.servicio.nombre_servicio) 
            console.log("refs",this.$refs) 
            //this.$refs.typeahead.inputValue = dataser.servicio.nombre_servicio
            $( ".autocomplete__icon img" ).addClass( "vertical-top-0" );

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
                        var url = '/api/tarifarios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_SERVICIOS_LIST').then(() => {
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
        handleHit(evt) {
            this.dataServicio.servicio_id = evt.id
        },
        addDistributionGroup (group) {
            this.dataServicio.servicio_id = group.value
            console.log("resultado: ",this.dataServicio.servicio_id)
            // access the autocomplete component methods from the parent
            //this.$refs.autocomplete.clear()
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
