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
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="accesosusuario"
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
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Permiso'" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>                                
                            </span>
                            <span v-else-if="props.column.field == 'crear'" class="center">
                                <toggle-button :value="props.row.crear" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props)"/>                                
                            </span> 
                            <span v-else-if="props.column.field == 'actualizar'" class="center">
                                <toggle-button :value="props.row.actualizar" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props)"/>                                
                            </span>
                            <span v-else-if="props.column.field == 'eliminar'" class="center">
                                <toggle-button :value="props.row.eliminar" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props)"/>                                
                            </span>
                            <span v-else-if="props.column.field == 'ver'" class="center">
                                <toggle-button :value="props.row.ver" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props)"/>                                
                            </span>
                            <span v-else-if="props.column.field == 'autorizar'" class="center">
                                <toggle-button :value="props.row.autorizar" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" @change="updateAcceso(props)"/>                                
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
    name:'accesos',
    mixins: [mixin],     
    mounted() {     
        this.$store.dispatch('LOAD_ACCESOSUSUARIO_LIST',{ id : this.$route.params.user }).then(() => {
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
                label: 'Acceder a',
                field: 'acceso.nombre',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                },  
                {
                label: 'Key',
                field: 'acceso.key',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                },  
                {
                label: 'Crear',
                field: 'crear',
                width:'10%',
                },
                {
                label: 'Actualizar',
                field: 'actualizar',
                width:'10%',
                }, 
                {
                label: 'Eliminar',
                field: 'eliminar',
                width:'10%',
                }, 
                {
                label: 'Ver',
                field: 'ver',
                width:'10%',
                }, 
                {
                label: 'Autorizar',
                field: 'autorizar',
                width:'10%',
                },                                                                                                                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                thClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],                                                              
            errors:[]                          

        }
    },
    computed: {
        ...mapState(['accesosusuario']),
    }, 
    methods: {        
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
                            this.$store.dispatch('LOAD_ACCESOSUSUARIO_LIST',{ id : this.$route.params.user }).then(() => {
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
        updateAcceso: function(dato){
            //id , campo , value
            let campo = dato.column.field
            this.dataAcceso = {
                id : dato.row.id,
                valor : !dato.row.$campo,  
                column: campo            
            }
            var url = '/api/accesos/estados/'+this.dataAcceso.id;     
            axios.put(url, this.dataAcceso).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }
                    this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                                    
                    return;
                }
                this.$store.dispatch('LOAD_ACCESOSUSUARIO_LIST',{ id : this.$route.params.user })                  
                this.errors = [];         
                this.$modal.hide('perfil'); 
                this.notificaciones('el Usuario fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;           
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                                             

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
