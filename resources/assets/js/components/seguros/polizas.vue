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
                    <div class="row pl-20 pr-20">
                        <div class="col-6">
                            <label for="basic" class="text-primary font-weight-bold pb-10">Empresa :</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-primary font-weight-bold" placeholder="Nombre de Empresa" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="nom_emp" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-addon2" @click="$modal.show('empresas')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="basic" class="text-primary font-weight-bold pb-10">Aseguradora :</label>
                            <div class="select2-input">
                                <select id="basic" name="basic" class="form-control form-control border border-primary" v-model="dataPoliza.plane_id">
                                    <option value="">-- Seleccione Aseguradora--</option>
                                    <option v-for="plan in empresapacientesplanes" :value="plan.plane_id" :key="plan.plane_id">
                                        {{ plan.plane.descripcion}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>                       
                                                       
                </div>
                <div class="card-body">
                    <div class="col pb-20">
                        <button type="button" class="btn btn-primary float-right mb-20" @click.prevent="LoadForm" :disabled = "!(dataPoliza.empresapaciente_id > 0 && dataPoliza.plane_id > 0)"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Planes</button>
                    </div>                      
                    <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                        <thead>
                            <tr>
                                <th scope="col">Nº</th>
                                <th scope="col">Poliza Nº</th>
                                <th scope="col">Plan</th>
                                <th scope="col">Vigencia</th>
                                <th scope="col">Al</th>
                                <th scope="col">Moneda</th>     
                                <th scope="col">Deducible</th>
                                <th scope="col">%CoaSeguradora</th>                                                                                                                          
                            </tr>
                        </thead>
                        <tbody v-if="polizasemp.length > 0">
                            <tr v-for="(poliza,index) in polizasemp"  :key="poliza.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ poliza.codigo}}</td>
                                <td>{{ poliza.planpoliza.nombre_planpoliza}}</td>
                                <td>{{ poliza.vigencia_del | reversefecha}}</td>
                                <td>{{ poliza.vigencia_al | reversefecha}}</td>  
                                <td>{{ poliza.moneda.nombre_moneda}}</td>   
                                <td>{{ poliza.deducible}}</td>  
                                <td>{{ poliza.coaseguro}}</td>                                                                                                                         
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END DEFAULT DATATABLE -->              
        </div>
        <!-- form para seleccionar la empresa -->
        <modal name="empresas" width="50%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione una Empresa</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('empresas')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_empresas"
                        :rows="empresapacientes"
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
                        @on-row-click="selectEmpresa"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectEmpresa(props)">
                                    Seleccionar
                                </button>                                                               
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                    
                        </vue-good-table>
                        <!-- END DEFAULT DATATABLE -->  
                     </div>
                </div>
            </div>                                
        </modal>  
        <modal name="poliza" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de polizas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Agregar Nuevo Plan</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 pr-0">
                                <div class="form-group pt-0">
                                    <label for="codigo" class="text-primary font-weight-bold">Poliza Nº</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control form-control-sm border border-primary" v-model="dataPoliza.codigo">
                                </div>                            
                            </div>
                            <div class="col-6">
                                <label for="basic" class="text-primary font-weight-bold pb-7">Plan :</label>
                                <div class="select2-input pr-10">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataPoliza.planpoliza_id">
                                        <option value="">--Seleccione Plan--</option>
                                        <option v-for="plpol in planpolizas" :value="plpol.id" :key="plpol.id">
                                            {{ plpol.nombre_planpoliza}}
                                        </option>
                                    </select>
                                </div>                           
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="" class="text-primary font-weight-bold">Vigencia del </label>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <masked-input v-model="dataPoliza.vigencia_del" mask="11/11/1111" placeholder="DD/MM/YYYY" class="border border-primary"/>
                                        </div>
                                    </div>
                                </div>                            
                            </div>  
                            <div class="col-6">
                                <div class="form-group pt-0 pl-0">
                                    <label for="" class="text-primary font-weight-bold">Vigencia al </label>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <masked-input v-model="dataPoliza.vigencia_al" mask="11/11/1111" placeholder="DD/MM/YYYY" class="border border-primary"/>
                                        </div>
                                    </div>
                                </div>                            
                            </div>                                                       
                        </div>
                        <div class="row pl-10">
                            <div class="col-4 pr-0">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Moneda :</label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataPoliza.moneda_id">
                                        <option value="">-- Seleccione Moneda--</option>
                                        <option v-for="moneda in monedas" :value="moneda.id" :key="moneda.id">
                                            {{ moneda.nombre_moneda}}
                                        </option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="col-4 pr-0">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">Deducible : </label>
                                    <input type="text" id="deducible" class="form-control form-control-sm border border-primary" v-model="dataPoliza.deducible">
                                </div>                            
                            </div>
                            <div class="col-4 pl-0">
                                <div class="form-group pt-0">
                                    <label for="nombre" class="text-primary font-weight-bold">%Coaseguro : </label>
                                    <input type="text" id="coaseguro" class="form-control form-control-sm mayusculas border border-primary" v-model="dataPoliza.coaseguro">
                                </div>                            
                            </div>
                        </div>                                              
                        <div class="form-group">
                            <label for="comment" class="text-primary font-weight-bold">Comentario</label>
                            <textarea class="form-control form-control-sm border border-primary" id="comment" rows="4" v-model="dataPoliza.comentario">
                            </textarea>
                        </div>                        
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="createPoliza" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('poliza')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de polizas -->
        </modal>                 
    </div>
</template>
<script>
import mixin from '../../mixins.js'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'polizas',
    mixins: [mixin],  
    mounted() { 
        this.$store.dispatch('LOAD_MONEDAS_LIST')
        this.$store.dispatch('LOAD_PLANPOLIZAS_LIST')
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_LIST',{ id : 0 })        
        this.$store.dispatch('LOAD_POLIZAS_LIST').then(() => {
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
            columns_empresas: [
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'20%',
                },                 
                {
                label: 'Razón Social',
                field: 'razon_social',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'60%',
                },                                                                                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'20%',  
                }                               
            ],
            dataPoliza : {
                codigo:'',
                vigencia_del:'',
                vigencia_al:'',
                moneda_id:'',
                deducible:'',
                coaseguro:'',
                comentario:'',
                user_id:'',
                planpoliza_id:'',
                empresapaciente_id:'',
                plane_id:''
            },             
            errors:[] ,
            nom_emp:'', 
            emp_id:'',
            pla_id:''                                     
        }
    },
    computed: {
        ...mapState(['empresapacientes','user_system','empresapacientesplanes','polizas','planpolizas','monedas']),
        ...mapGetters(['getplanes_aseguradoras']),   
        polizasemp: function(){     
            return this.polizas.filter((pol) => pol.empresapaciente_id === this.dataPoliza.empresapaciente_id).filter((pol) => pol.plane_id === this.dataPoliza.plane_id);
        },             
    },
    components: {
      MaskedInput 
    },       
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },     
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')  
            this.pla_id = this.dataPoliza.plane_id   
            this.emp_id = this.dataPoliza.empresapaciente_id    

            this.dataPoliza = {
                codigo:'',
                vigencia_del:'',
                vigencia_al:'',
                moneda_id:'',
                deducible:'',
                coaseguro:'',
                comentario:'',
                user_id:this.user_system.id,
                planpoliza_id:'',
                empresapaciente_id:this.emp_id,
                plane_id: this.pla_id
            }         
            this.$modal.show('poliza')
        }, 
        createPoliza: function(){
            var url = '/api/polizas';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataPoliza).then(response => {
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

            this.$store.dispatch('LOAD_POLIZAS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('poliza');   
            this.notificaciones('Nuevo Plan agregado con exito','la la-thumbs-up','success')       
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
                        var url = '/api/polizas/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_POLIZAS_LIST').then(() => {
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
        selectEmpresa: function(params){
            this.dataPoliza.empresapaciente_id = params.row.id
            this.dataPoliza.plane_id = ''
            this.nom_emp = params.row.razon_social
            this.$modal.hide('empresas') 
            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_LIST',{ id : this.dataPoliza.empresapaciente_id }).then(() => {
                this.isLoading = false
                if(this.empresapacientesplanes.length === 0){
                    this.notificaciones('La Empresa seleccionada no tiene aseguradoras asignadas','la la-thumbs-o-down','danger')                               
                    return;
                }   
            }) 
          
        },
    },
    filters:{
        reversefecha: function(value){
            if(!value) return ''
            value = value.toString()
            return value.split('-').reverse().join('-')
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
    .pb-7 {
        padding-bottom: 7px !important;
    }
</style>