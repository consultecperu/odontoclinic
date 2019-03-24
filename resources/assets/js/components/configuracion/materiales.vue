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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-inbox"></i></span> Nuevo Material</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="materiales"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Material'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Material'" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>                                
                            </span>
                            <span v-else-if="props.column.field == 'devolucion'">
<!--                                 <label v-if="props.row.devolucion == true" class="text-primary">SI</label>
                                <label v-else class="text-danger">NO</label>
 -->                                <span class="center badge" :class="[props.row.devolucion == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.devolucion == 1 ? 'SI' : 'NO'}}</span>                                
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
        <modal name="material" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de materiales -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} de Material</div>
                    </div>
                    <div class="card-body">                   
                        <div class="form-group pt0">
                            <label for="opcion" class="text-primary font-weight-bold">Nombre de Material <span class="required-label">*</span></label>
                            <input type="text" id="opcion" placeholder="Nombre" class="form-control form-control-sm mayusculas" v-model="dataMaterial.nombre_material">
                        </div>
                        <div class="form-group pt-0 pb-0">
                            <label for="exampleFormControlSelect1" class="text-primary font-weight-bold">Seleccione la Moneda <span class="required-label">*</span></label>
                            <select v-model="dataMaterial.moneda_id" class="form-control form-control-sm" id="exampleFormControlSelect1">
                            <option v-for="moneda in monedas" :value="moneda.id" :key="moneda.id">
                                {{ moneda.nombre_moneda }}
                            </option>
                            </select>                            
                        </div>                        
                        <div class="form-group pb-0">
                            <label for="costo" class="text-primary font-weight-bold">Costo</label>
                            <input type="text" id="costo" placeholder="Costo" class="form-control form-control-sm" v-model="dataMaterial.costo">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" v-model="dataMaterial.devolucion" true-value=true false-value=false />
                                <span class="form-check-sign text-primary font-weight-bold">Devolución al Doctor</span><span class="required-label"> *</span>
                            </label>
                        </div>                        

                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionMaterial" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('material')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de materiales -->
        </modal>                         
    </div>        
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'materiales',
    mixins: [mixin],     
    mounted() {  
        this.$store.dispatch('LOAD_MONEDAS_LIST')
        this.$store.dispatch('LOAD_MATERIALES_LIST').then(() => {
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
                label: 'Nombre de Material',
                field: 'nombre_material',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                }, 
                {
                label: 'Nro.Servicios',
                field: this.fieldFn,
                tdClass: 'center',
                thClass: 'center',                 
                width:'10%',
                },
                {
                label: 'Moneda',
                field: 'moneda.nombre_moneda',
                width:'17%',
                },
                {
                label: 'Costo',
                field: 'costo',
                width:'8%',
                },
                {
                label: 'Devolucion al Doc',
                field: 'devolucion',
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
                width:'15%',  
                }                               
            ],  
            dataMaterial : {
                nombre_material:'',
                devolucion:'',
                moneda_id:'',
                user_id:'',
                costo:''
            },                                                               
            errors:[]                          
        }
    },
    computed: {
        ...mapState(['materiales','monedas','user_system']),
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },          
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.dataMaterial = {
                nombre_material:'',
                devolucion: true,
                moneda_id:'',
                user_id:this.user_system.id,
                costo:''
            }   
            this.labelAccion = "Registro"                    
            this.$modal.show('material')
        }, 
        ActionMaterial: function(){
            if(typeof(this.dataMaterial.id) === "undefined"){
                this.createMaterial()
            }else{
                this.updateMaterial()
            }
        },
        createMaterial: function(){
            var url = '/api/materiales';
            this.StatusForm(true,'la la-spinner','Procesando')         
            axios.post(url, this.dataMaterial).then(response => {
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
            this.$store.dispatch('LOAD_MATERIALES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                 
            this.$modal.hide('material');
            this.notificaciones('Nuevo Material creado con exito','la la-thumbs-up','success')            
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updateMaterial: function(){
            var url = '/api/materiales/'+this.dataMaterial.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataMaterial).then(response => {
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
                this.$store.dispatch('LOAD_MATERIALES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.$modal.hide('material');
                this.notificaciones('el Material fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                              
            });
        },
        processEdit(params){
            var datamat = []
            datamat = _.clone(params.row)
 
            this.dataMaterial = {
                id:datamat.id,
                nombre_material:datamat.nombre_material,
                devolucion:datamat.devolucion,
                moneda_id:datamat.moneda_id,
                user_id:this.user_system.id,
                costo:datamat.costo
            }   
            this.labelAccion = "Actualización"                       
            this.$modal.show('material')
        
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
                        var url = '/api/materiales/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_MATERIALES_LIST').then(() => {
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
        fieldFn(rowObj) {
            return rowObj.materialservicios.length
        },          
        cargaServicios: function(id){
            this.$router.push({ name: 'detallematerial', params: { material: id }})
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
