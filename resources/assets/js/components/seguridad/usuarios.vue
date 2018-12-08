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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nuevo Perfil</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    title="Listado de Usuarios"
                    :columns="columns"
                    :rows="usuarios"
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
                    :lineNumbers="true"
                    styleClass="vgt-table condensed bordered striped">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-success btn-xs" data-original-title="Actualizar Accesos" @click.prevent="cargaAccesos(props.row.id)">
                                    <i class="la la-calendar-check-o font-large"></i>
                                </button>                                
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-danger btn-xs" data-original-title="Eliminar Usuario" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>
                            </span>
                            <span v-else-if="props.column.field == 'acceso'" class="center">
                                <toggle-button :value="props.row.acceso" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props.row)"/>                                
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
    </div>     
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'usuarios',
    mixins: [mixin],     
    mounted() {
        this.$store.dispatch('LOAD_USUARIOS_LIST').then(() => {
            this.isLoading = false
        })                  
    }, 
    data() {
        return {
            isLoading: true,
            fullPage: true,

            columns: [
                {
                label: 'Nombre Usuario',
                field: 'name',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },  
                {
                label: 'Perfil',
                field: 'perfile.nombre_perfil',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                },  
                {
                label: 'Habilitado',
                field: 'acceso',
                tdClass: 'center',
                thClass: 'center',                
                width:'10%',
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
            dataAcceso : {
                id : '',
                acceso : ''
            },                                                                            
            errors:[]                                                      
        }
    },
    computed: {
        ...mapState(['usuarios']),
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },           
        updateAcceso: function(dato){
            this.dataAcceso = {
                id : dato.id,
                acceso : !dato.acceso                
            }
            var url = '/api/users/accesos/'+this.dataAcceso.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataAcceso).then(response => {
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
                this.$store.dispatch('LOAD_USUARIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')           
                this.$modal.hide('perfil'); 
                this.notificaciones('el Usuario fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                                             

            });
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
                        var url = '/api/users/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_USUARIOS_LIST').then(() => {
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
        cargaAccesos: function(id){
            this.$router.push({ name: 'accesos', params: { user : id }})
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