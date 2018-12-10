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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-agenda-1"></i></span> Nueva Aseguradora</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="getplanes_aseguradoras"
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
                                <button type="button" class="btn btn-border btn-primary btn-xs" v-tooltip="'Ver Tarifario'" @click.prevent="cargaTarifario(props.row.id)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                  
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Aseguradora'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Aseguradora'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="aseguradora" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de aseguradoras -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nueva Aseguradora</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 pr-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">RUC</label>
                                    <input type="text" id="ruc" class="form-control form-control-sm border border-primary" maxlength="11" v-model="dataAseguradora.ruc">
                                </div>                            
                            </div>
                            <div class="col-8 pl-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">Nombre de Aseguradora </label>
                                    <input type="text" id="nombre" class="form-control form-control-sm mayusculas border border-primary" v-model="dataAseguradora.descripcion">
                                </div>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-0">
                                    <label for="nombre">Direccion </label>
                                    <input type="text" id="direccion" class="form-control form-control-sm mayusculas border border-primary" v-model="dataAseguradora.direccion">
                                </div>                            
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-4 pr-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">Teléfono </label>
                                    <input type="text" id="telefono" class="form-control form-control-sm border border-primary" maxlength="9" v-model="dataAseguradora.telefono">
                                </div>                            
                            </div>
                            <div class="col-8 pl-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">Facturar a </label>
                                    <input type="text" id="facturar_a" class="form-control form-control-sm mayusculas border border-primary" v-model="dataAseguradora.facturar_a">
                                </div>                            
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-4 pr-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">% Descuento </label>
                                    <input type="text" id="descuento" class="form-control form-control-sm mayusculas border border-primary" v-model="dataAseguradora.descuento">
                                </div>                            
                            </div>
                            <div class="col-4 pl-0">
                                <div class="form-group pt-0">
                                    <label for="nombre">Monto Fact.Mensual </label>
                                    <input type="text" id="monto" class="form-control form-control-sm mayusculas border border-primary" v-model="dataAseguradora.monto_mensual">
                                </div>                            
                            </div>
                            <div class="form-check col-4 pt-20 pl-0">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" v-model="dataAseguradora.facturacion_mltd"/>
                                    <span class="form-check-sign text-primary font-weight-bold">Facturación MLTD</span>
                                </label>
                            </div>                            
                        </div>                                               

                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea class="form-control form-control-sm border border-primary" id="comment" rows="5" v-model="dataAseguradora.comentario">

                            </textarea>
                        </div>                        
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionAseguradora" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('aseguradora')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    name: 'aseguradora',
    mixins: [mixin],  
    mounted() {    
        this.$store.dispatch('LOAD_PLANES_LIST').then(() => {
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
                field: 'descripcion',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },
                {
                label: 'Facturar A',
                field: 'facturar_a',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
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
            dataAseguradora : {
                descripcion:'',
                comentario:'',
                abreviatura:'',
                ruc:'',
                principal:'',
                tipo:'',
                facturacion_mltd:'',
                direccion:'',
                facturar_a:'',
                telefono:'',
                descuento:'',
                user_id:''
            },                                                               
            errors:[] ,   
        }
    },
    computed: {
        ...mapState(['planes','user_system']),
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

            this.dataAseguradora = {
                descripcion:'',
                comentario:'',
                abreviatura:'',
                ruc:'',
                principal:0,
                tipo:2,
                facturacion_mltd:'',
                direccion:'',
                facturar_a:'',
                telefono:'',
                descuento:'',
                user_id: this.user_system.id
            }           
            this.$modal.show('aseguradora')
        }, 
        ActionAseguradora: function(){
            if(typeof(this.dataAseguradora.id) === "undefined"){
                this.createAseguradora()
            }else{
                this.updateAseguradora()
            }
        },
        createAseguradora: function(){
            var url = '/api/planes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataAseguradora).then(response => {
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

            this.$store.dispatch('LOAD_PLANES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('aseguradora');   
            this.notificaciones('Nueva Aseguradora creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateAseguradora: function(){
            var url = '/api/planes/'+this.dataAseguradora.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataAseguradora).then(response => {
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

                this.$store.dispatch('LOAD_PLANES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('aseguradora');  
                this.notificaciones('la Aseguradora fue actualizada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datapla = []
            datapla = _.clone(params.row)
            this.dataAseguradora = {
                id:datapla.id,
                descripcion:datapla.descripcion,
                comentario:datapla.comentario,
                abreviatura:datapla.abreviatura,
                ruc:datapla.ruc,
                principal:datapla.principal,
                tipo:datapla.tipo,
                facturacion_mltd:datapla.facturacion_mltd,
                direccion:datapla.direccion,
                facturar_a:datapla.facturar_a,
                telefono:datapla.telefono,
                descuento:datapla.descuento,                
                user_id: this.user_system.id                                         
            }            
            this.$modal.show('aseguradora')
        
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
                        var url = '/api/planes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PLANES_LIST').then(() => {
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
        cargaTarifario: function(id){
            this.$router.push({ name: 'detalleaseguradora', params: { plan: id }})
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
