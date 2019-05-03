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
                    <div class="col pl-0 pr-0">
                        <button type="button" class="btn btn-danger btn-sm btn-round" @click.prevent="$router.go(-1)"><span class="btn-label"><i class="la la-arrow-circle-o-left"></i></span> Volver</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="getCitasPaciente"
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
                            <span v-if="props.column.field == 'btn'">
                                <span class="center badge-mini badge badge-danger" v-if="props.row.realizado == 1" v-text="'P'"></span>                                
                                <span class="center badge-mini badge badge-primary" v-if="props.row.realizado == 2" v-text="'EN PROCESO'"></span>                                
                                <span class="center badge-mini badge badge-success" v-if="props.row.realizado == 3" v-text="'TERMINADO'"></span>                                
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
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'citaspacientes',
    mixins: [mixin], 
    mounted(){          
        this.$store.dispatch('LOAD_CITAS_LIST').then(() => {
            this.isLoading = false
        })        
    },     
    data(){
        return {
            isLoading: true,
            fullPage: true, 
            
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    width:'8%',
                }, 
                {
                    label: 'Odontólogo encargado',
                    field: 'empleado.nombre_completo',
                    filterOptions: {
                        enabled: false, 
                        placeholder: 'Buscar', 
                    },             
                    width:'30%',
                },
                
                {
                    label: 'Fecha cita',
                    field: 'fecha_cita',                
                    width:'20%',
                }, 
                {
                    label: 'Hora',
                    field: this.fieldFn,
                    width:'25%',
                },                                                                                                                                                                                                                                       
                {
                    label: 'Estado',
                    field: 'estadocita.nombre_estadocita',
                    thClass: 'center',
                    tdClass: 'center',
                    html: true  ,
                    width:'17%',  
                }                               
            ],            
        }
    }
    
}
</script>
<style scoped>

</style>