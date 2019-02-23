<template>
    <!-- form de registro de cargos -->
    <div class="card mb-0">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>        
        <div class="card-header">
            <div class="card-title">Record de Atención</div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-head-bg-primary table-bordered-bd-primary">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Tratamiento Realizado</th>
                        <th scope="col">Doctor Responsable</th>
                        <th scope="col">Comentario</th>                                                                                                                      
                    </tr>
                </thead>
                <tbody>
                    <!--<tr v-for="serv in list_services_dent" :key="serv.id">-->
                    <tr v-for="trat in list_detalle" :key="trat.id" class="table_record">
                        <td width="15%">{{ trat.fecha}}</td>
                        <td width="30%">{{ trat.letras }} / {{ trat.tratamiento}}</td>
                        <td width="30%">{{ trat.doctor}}</td>
                        <td width="25%">{{ trat.comentario}}</td>
                    </tr>                                      
                    <!--<tr v-if="list_services_dent.length == 0">-->
                    <tr v-if="list_detalle.length == 0">
                        <td colspan="4" class="text-center">NO HAY RECORD DE ATENCIÓN GRABADOS ...</td>                                           
                    </tr>
                </tbody>
            </table>     
        </div>
        <div class="card-action">
            <button class="btn btn-success float-right" @click.prevent="$router.go(-1)"><span class="btn-label"><i class="la la-arrow-circle-left"></i> Regresar</span></button>
        </div>
    </div>
    <!-- /. form de registro de cargos -->    
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import jsPDF from 'jspdf'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'ver-record-atencion',
    mixins: [mixin], 
    created() {  
        this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
            this.isLoading = false
        })                              
    },
    mounted(){
        this.list_detalle = this.CargaRecord()
    }, 
    data(){
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            list_detalle:[]

        }
    },
    computed: {
        ...mapState(['user_system','sede_system']),
        ...mapGetters(['getPresupuestoOperatoriaById']), 
        presupuestoOperatoriaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOperatoriaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        }             
    },
    methods:{
        CargaRecord(){
            let lista = []
            let data = {
                fecha:'',
                letras:'',
                tratamiento:'',
                doctor:'',
                comentario:''
            }
            let datitos = []
            let detalle = this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles
            _.each(detalle, function(value,key){
                if(value.recordatencionoperatorias.length > 0){
                    data.letras = value.letras
                    data.tratamiento = value.tarifario.servicio.nombre_servicio
                    _.each(value.recordatencionoperatorias, function(value2,key2){
                        data.fecha = value2.fecha_realizacion
                        data.doctor = value2.empleado.nombre_completo
                        data.comentario = value2.descripcion
                        datitos = _.clone(data)
                        lista.push(datitos)
                    })
                }
            })
            return lista
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
    .table_record td {
        font-size: 0.78em !important;
    }
</style>

