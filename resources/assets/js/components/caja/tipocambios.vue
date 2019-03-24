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
                        <button type="button" class="btn btn-primary float-right ml-10" @click.prevent="LoadForm"><span class="btn-label"><i class="la la-calculator"></i></span> Nuevo x Dia</button>
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="la la-calculator"></i></span> Nuevo Mensual</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="tipocambios"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Modificar Datos'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
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
        <modal name="tipocambio" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de aseguradoras -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion}} de Tipo de Cambio</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="moneda_d" class="text-primary font-weight-bold pb-10">De :</label>
                                    <div class="select2-input">
                                        <select id="moneda_d" name="basic" class="form-control form-control-sm border border-primary" v-model="dataTipocambio.monedade_id" disabled>
                                            <option v-for="mon in monedas" :value="mon.id" :key="mon.id">
                                                {{ mon.nombre_moneda}}
                                            </option>
                                        </select>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="moneda_a" class="text-primary font-weight-bold pb-10">A :</label>
                                    <div class="select2-input">
                                        <select id="moneda_a" name="basic" class="form-control form-control-sm border border-primary" v-model="dataTipocambio.monedaa_id" disabled>
                                            <option v-for="mon in monedas" :value="mon.id" :key="mon.id">
                                                {{ mon.nombre_moneda}}
                                            </option>
                                        </select>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="valor_sistema" class="text-primary font-weight-bold">Valor del Sistema </label>
                                    <input type="number" step="0.01" id="valor_sistema" class="form-control form-control-sm border border-primary" v-model="dataTipocambio.tipo_cambio" @keyup.enter="$refs.compra.focus" placeholder="0.00">
                                </div>                            
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="compra" class="text-primary font-weight-bold">Compra </label>
                                    <input type="number" step="0.01" ref="compra" id="compra" class="form-control form-control-sm border border-primary" v-model="dataTipocambio.valor_compra" @keyup.enter="$refs.venta.focus" placeholder="0.00">
                                </div>                            
                            </div>
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="venta" class="text-primary font-weight-bold">Venta </label>
                                    <input type="number" step="0.01" ref="venta" id="venta" class="form-control form-control-sm border border-primary" v-model="dataTipocambio.valor_venta" @keyup.enter="$refs.accion.focus" placeholder="0.00">
                                </div>                            
                            </div>
                        </div>                         
                    </div>
                    <div class="card-action">
                        <button ref="accion" class="btn btn-primary" @click.prevent="ActionTipocambio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('tipocambio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de aseguradoras -->
        </modal>                         
    </div>        
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'tipocambios',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_MONEDAS_LIST')                
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST').then(() => {
            this.isLoading = false
        }) 
    },
    data(){
        return {
            isLoading: true,
            fullPage: true,

            labelAccion:'',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            columns: [
                {
                label: 'De',
                field: 'monedade.nombre_moneda',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                }, 
                {
                label: 'A',
                field: 'monedaa.nombre_moneda',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                },   
                {
                label: 'Tipo Cambio',
                field: 'tipo_cambio',
                type: 'decimal',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                }, 
                {
                label: 'Conta Venta',
                field: 'valor_venta',
                type: 'decimal',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                }, 
                {
                label: 'Conta Compra',
                field: 'valor_compra',
                type: 'decimal',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'15%',
                },                                                               
                {
                label: 'Fecha Registro',
                field: 'fecha_registro',
                type: 'date',
                dateInputFormat: 'DD-MM-YYYY', 
                dateOutputFormat: 'DD-MM-YYYY', 
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
           dataTipocambio:{
               fecha_registro:'',
               valor_compra:'',
               valor_venta:'',
               tipo_cambio:'',
               monedade_id:2,
               monedaa_id:1,
               user_id:''
           } 
        }
    },
    computed: {
        ...mapState(['tipocambios','user_system','monedas'])            
    },    
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },     
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')   
            this.labelAccion = 'Registro'
            this.dataTipocambio = {
                fecha_registro:moment().format('DD-MM-YYYY'),
                valor_compra:'',
                valor_venta:'',
                tipo_cambio:'',
                monedade_id:2,
                monedaa_id:1,
                user_id:this.user_system.id
            }        
            this.$modal.show('tipocambio')
        }, 
        ActionTipocambio(){
            if(typeof(this.dataTipocambio.id) === "undefined"){
                this.createTipocambio()
            }else{
                this.updateTipocambio()
            }
        },        
        createTipocambio(){
            var url = '/api/tipocambios';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataTipocambio).then(response => {
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

            this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('tipocambio');   
            this.notificaciones('Nuevo Tipo de cambio agregado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateTipocambio(){
            var url = '/api/tipocambios/'+this.dataTipocambio.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataTipocambio).then(response => {
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

                this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('campaña');  
                this.notificaciones('El Tipo de cambio fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datatip = []
            datatip = _.clone(params.row)
            this.dataTipocambio = {
                id:datatip.id,
                fecha_registro:datatip.fecha_registro,
                valor_compra:datatip.valor_compra,
                valor_venta:datatip.valor_venta,
                tipo_cambio:datatip.tipo_cambio,
                monedade_id:datatip.monedade_id,
                monedaa_id:datatip.monedaa_id,
                user_id:this.user_system.id
            } 
            this.labelAccion = "Actualización"
            this.$modal.show('tipocambio')
        
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
                        var url = '/api/tipocambios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST').then(() => {
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
    },    

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

