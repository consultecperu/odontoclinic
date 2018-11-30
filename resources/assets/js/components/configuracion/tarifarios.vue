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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-agenda-1"></i></span> Nuevo Plan</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    title="Listado de Planes"
                    :columns="columns"
                    :rows="getplanes_multident"
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
        <modal name="plan" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de planes -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nuevo Plan Multident</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de Plan</label>
                            <input type="text" id="nombre" placeholder="Nombre de Plan" class="form-control input-sm mayusculas" v-model="dataPlan.descripcion">
                        </div>
                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea class="form-control" id="comment" rows="5" v-model="dataPlan.comentario">

                            </textarea>
                        </div>                        
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionPlan" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('plan')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    name: 'tarifarios',
    mixins: [mixin],  
    mounted() {
        this.$store.dispatch('LOAD_PLANES_LIST').then(() => {
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
                label: 'Nombre',
                field: 'descripcion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'70%',
                },                                                                                                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'30%',  
                }                               
            ],
            dataPlan : {
                descripcion:'',
                comentario:'',
                user_id:''
            },                                                               
            errors:[] ,                           
        }
    },
    computed: {
        ...mapState(['planes','user_system']),
        ...mapGetters(['getplanes_multident']),        
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataPlan = {
                descripcion:'',
                comentario:'',
                user_id: this.user_system.id
            }           
            this.$modal.show('plan')
        }, 
        ActionPlan: function(){
            if(typeof(this.dataPlan.id) === "undefined"){
                this.createPlan()
            }else{
                this.updatePlan()
            }
        },
        createPlan: function(){
            var url = '/api/planes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataPlan).then(response => {
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
            this.$modal.hide('plan');   
            this.notificaciones('Nuevo Plan creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updatePlan: function(){
            var url = '/api/planes/'+this.dataPlan.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataPlan).then(response => {
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
                this.$modal.hide('plan');  
                this.notificaciones('el Plan fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datapla = []
            datapla = _.clone(params.row)
            this.dataPlan = {
                id:datapla.id,
                descripcion:datapla.descripcion,
                comentario:datapla.comentario 
                                          
            }            
            this.$modal.show('plan')
        
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

    }    
}
</script>
<style scoped>

</style>
