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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-archive"></i></span> Nuevo Canje</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="canjes"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Canje'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Canje'" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>   
                                <button type="button" :disable="props.row.estado == 'autorizado'" class="btn btn-border btn-primary btn-xs" v-tooltip="'Autorizar Canje'" @click.prevent="processAutorizar(props.row.id)">
                                    <i class="la la-thumbs-o-up font-large"></i>
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
        <modal name="canje" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de campañas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nuevo Canje</div>
                    </div>
                        <form role="form" method="POST" v-on:submit.prevent="ActionCanje">                    
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group pt-0">
                                            <label for="nombre" class="text-primary font-weight-bold">Nº de Certificado </label>
                                            <input type="text" id="nombre" class="form-control form-control-sm mayusculas border border-primary" v-model="dataCanje.numero_certificado">
                                        </div>  
                                    </div>
                                    <div class="col-6 pr-25">
                                        <label for="basic" class="text-primary font-weight-bold pb-7">Tipo de Canje </label>
                                        <div class="select2-input">
                                            <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataCanje.tipo_canje">
                                                <option value="">-- Seleccione Tipo--</option>
                                                <option v-for="tipo in tipoCanjes" :value="tipo.id" :key="tipo.id">
                                                    {{ tipo.text}}
                                                </option>
                                            </select>
                                        </div>                                
                                    </div>                         
                                </div>  
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group pt-0">
                                            <label for="motivo" class="text-primary font-weight-bold">Motivo del Canje </label>
                                            <input type="text" id="motivo" class="form-control form-control-sm mayusculas border border-primary" v-model="dataCanje.motivo_canje">
                                        </div>                                         
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="basic" class="text-primary font-weight-bold pb-10 pl-10">Generar A </label>
                                        <div class="select2-input pl-10">
                                            <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataCanje.genera_canje_a">
                                                <option value="">-- Seleccione Opcion--</option>
                                                <option v-for="igen in itemsGenerar" :value="igen.id" :key="igen.id">
                                                    {{ igen.text}}
                                                </option>
                                            </select>
                                        </div>                          
                                    </div>  
                                    <div class="col-6 pr-25">
                                        <label for="basic" class="text-primary font-weight-bold pb-10">Otorgar A </label>
                                        <div class="select2-input">
                                            <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataCanje.otorgar_a">
                                                <option value="">-- Seleccione Opcion--</option>
                                                <option v-for="ioto in itemsOtorgar" :value="ioto.id" :key="ioto.id">
                                                    {{ ioto.text}}
                                                </option>
                                            </select>
                                        </div>                          
                                    </div>                         
                                </div>                   
                            </div>
                            <div class="card-action">
                                <button type="submit" class="btn btn-primary" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                                <button class="btn btn-danger" @click.prevent="$modal.hide('canje')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                            </div>
                        </form>                    
                </div>
            <!-- /. form de registro de campañas -->
        </modal>                                
    </div>     
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'canjes',
    mixins: [mixin],
    mounted() {    
        this.$store.dispatch('LOAD_CANJES_LIST').then(() => {
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
                label: '# Certificado',
                field: 'numero_certificado',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'12%',
                }, 
                {
                label: 'Motivo',
                field: 'motivo_canje',             
                width:'30%',
                },
                {
                label: 'Tipo Canje',
                field: 'tipo_canje',
                formatFn: this.fnTipo,
                width:'15%',
                }, 
                {
                label: 'Generar a',
                field: 'genera_canje_a',
                formatFn: this.fnGenera,                             
                width:'15%',
                },                  
                {
                label: 'Estado',
                field: 'estado',
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
                width:'13%',  
                }                               
            ],
            dataCanje : {
                motivo_canje:'',                
                genera_canje_a:'',
                tipo_canje:'',
                numero_certificado:'',
                otorgar_a:'',
                user_id:'',
                estado:''
            }, 
            tipoCanjes : [
                { id: 1 , text : 'MONTO' },
                { id: 2 , text : 'SERVICIOS'},
                { id: 3 , text : 'MIXTO'}
            ], 
            itemsGenerar : [
                { id: 1 , text : 'EMPRESA'},
                { id: 2 , text : 'DR: JESUS OCHOA'},
                { id: 3 , text : 'ALDA SOTOMAYOR'}                                
            ], 
            itemsOtorgar : [
                { id: 1 , text : 'AL PORTADOR'},
                { id: 2 , text : 'PERSONALIZADO'}                 
            ],                          
            errors:[]                                    
        }
    },
    computed: {
        ...mapState(['user_system','canjes'])      
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataCanje = {
                motivo_canje:'',                
                genera_canje_a:'',
                tipo_canje:'',
                numero_certificado:'',
                otorgar_a:'',
                user_id:this.user_system.id
            }           
            this.$modal.show('canje')
        }, 
        
        ActionCanje: function(){
            if(typeof(this.dataCanje.id) === "undefined"){
                this.createCanje()
            }else{
                this.updateCanje()
            }
        },
        createCanje: function(){
            var url = '/api/canjes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataCanje).then(response => {
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

            this.$store.dispatch('LOAD_CANJES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('canje');   
            this.notificaciones('Nuevo Canje creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateCanje: function(){
            var url = '/api/canjes/'+this.dataCanje.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataCanje).then(response => {
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

                this.$store.dispatch('LOAD_CANJES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('canje');  
                this.notificaciones('El Canje fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datacan = []
            datacan = _.clone(params.row)
            this.dataCanje = {
                id:datacan.id,
                motivo_canje:datacan.motivo_canje,                
                genera_canje_a:datacan.genera_canje_a,
                tipo_canje:datacan.tipo_canje,
                numero_certificado:datacan.numero_certificado,
                otorgar_a:datacan.otorgar_a,
                user_id:this.user_system.id,
                estado:datacan.estado                             
            }        
            this.$modal.show('canje')
        
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
                        var url = '/api/canjes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_CANJES_LIST').then(() => {
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
        processAutorizar(id){
            this.$swal({
                title: 'Desea Autorizar este canje?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, autorizar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/canjes/autorizar/' + id;
                        axios.put(url).then(response=> {
                            this.$store.dispatch('LOAD_CANJES_LIST').then(() => {
                                this.isLoading = false
                                this.$swal(
                                'Autorizado!',
                                'Este registro fue autorizado.',
                                'success'
                                )
                            })                    
                        });
                    }
                });
        },         
        fnTipo: function(value){
            var tipo = _.find(this.tipoCanjes, function(tip){ return tip.id  === value })
            return tipo.text
        },            
        fnGenera: function(value){
            var generar = _.find(this.itemsGenerar, function(gen){ return gen.id  === value })
            return generar.text
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
    .pb-7 {
        padding-bottom: 7px !important;
    }
</style>
