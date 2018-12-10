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
                    <!-- <h3 class="panel-title">VillaSalud</h3>   -->                             
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nuevo Perfil</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="perfiles"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Modulos'" @click.prevent="cargaModulos(props.row)">
                                    <i class="la la-calendar-check-o font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Perfil'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="perfil" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de perfiles -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Perfil</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de Perfil</label>
                            <input type="text" id="nombre" placeholder="Nombre de Perfil" class="form-control input-sm mayusculas" v-model="dataPerfil.nombre_perfil">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <textarea class="form-control input-sm " id="descripcion" rows="2" v-model="dataPerfil.descripcion">

                            </textarea>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionPerfil" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('perfil')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de perfiles -->
        </modal>
          <!-- modal de configuracion-->
        <modal name="modulos" :width="'70%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de Modulos -->
                <div class="card mb-0">
                    <div class="card-header pt-10 pb-10">
                        <div class="card-title">Carga de Modulos </div>
                    </div>
                    <div class="card-body">
                        <div class="col mt-10 p-0">
                            <div class="row ml-5 mr-5" style="display: flex; flex-wrap: wrap;">
                                <div class="col-6 pl-20 pr-20 pb-10" v-for="module in modules" :key="module.id" style="display: flex;flex-direction: column;">
                                        <table class="table table-bordered table-sm mb-0">
                                            <thead>
                                                <tr class="bg-light">
                                                    <th>  
                                                        <div class="form-check p-0">
                                                            <label :for="module.idmenu" class="form-check-label">
                                                                <input :id="module.idmenu" :value="module.idmenu" v-model="dataRolModulo.checkedRol" class="form-check-input" type="checkbox" @change="updateChildren($event,module)"/>
                                                                <span class="form-check-sign text-dark">{{module.name}}</span>
                                                            </label>
                                                        </div>                                                                                                                 
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="opcion in module.options" :key="opcion.options.options.id">
                                                    <td>                                                    
                                                        <div class="form-check p-0">
                                                            <label :for="opcion.options.options.id" class="form-check-label">
                                                                <input :id="opcion.options.options.id" :value="opcion.options.options.id" v-model="dataRolModulo.checkedRol" class="form-check-input" type="checkbox" @change="updateParent($event,opcion,module)"/>
                                                                <span class="form-check-sign">{{opcion.name}}</span>
                                                            </label>
                                                        </div>                                                                                                                
                                                    </td>
                                                </tr> 
                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-action pb-10 pt-10">
                        <button class="btn btn-primary" @click.prevent="updateModulos" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('modulos')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>                    
                </div>
            <!-- /. form de modulos -->
        </modal>
        <!-- /. modal -->                         
    </div>    
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'perfiles',
    mixins: [mixin],         
    mounted() {  
        this.$store.dispatch('LOAD_MODULES_LIST')
        this.$store.dispatch('LOAD_PERFILES_LIST').then(() => {
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
                label: 'Nombre de Perfil',
                field: 'nombre_perfil',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },  
                {
                label: 'Descripcion',
                field: 'descripcion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },                                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'20%',  
                }                               
            ],  
            dataPerfil : {
                nombre_perfil:'',
                descripcion:'',
                habilitado: true,
                activo: true
            },   
            dataRolModulo : {
                idRol : '',
                checkedRol :[]
            },                                                               
            errors:[]                          
        }
    },
    computed: {
        ...mapState(['perfiles','modules']),
    },      
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },          
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataPerfil = {
                nombre_perfil:'',
                descripcion:'',
                habilitado: true,
                activo: true
            }           
            this.$modal.show('perfil')
        }, 
        ActionPerfil: function(){
            if(typeof(this.dataPerfil.id) === "undefined"){
                this.createPerfil()
            }else{
                this.updatePerfil()
            }
        },
        createPerfil: function(){
            var url = '/api/perfiles';
            this.StatusForm(true,'la la-spinner','Procesando')        
            axios.post(url, this.dataPerfil).then(response => {
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
            this.$store.dispatch('LOAD_PERFILES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')              
            this.$modal.hide('perfil');
            this.notificaciones('Nuevo Perfil creado con exito','la la-thumbs-up','success')             
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updatePerfil: function(){
            var url = '/api/perfiles/'+this.dataPerfil.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataPerfil).then(response => {
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
                this.$store.dispatch('LOAD_PERFILES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')           
                this.$modal.hide('perfil'); 
                this.notificaciones('el Perfil fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                                             

            });
        },
        processEdit(params){
            var dataper = []
            dataper = _.clone(params.row)
            this.dataPerfil = {
                id:dataper.id,
                nombre_perfil:dataper.nombre_perfil, 
                descripcion:dataper.descripcion                                           
            }            
            this.$modal.show('perfil')
        
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
                        var url = '/api/perfiles/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PERFILES_LIST').then(() => {
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
        cargaModulos(row){
            var list=[];
            var imod = _.size(row.modules)
            if(imod > 0){
                row.modules.map(function(value, key) {
                    list.push(value.id)
                }) 
            }   
            this.dataRolModulo.idRol = row.id
            this.dataRolModulo.checkedRol = list  

            this.$modal.show('modulos')    
        },
        updateModulos: function(){
            var url = '/api/perfiles/updateModules/'+this.dataRolModulo.idRol;
            axios.put(url, this.dataRolModulo).then(response => {
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
                this.$store.dispatch('LOAD_PERFILES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
                this.$modal.hide('modulos');
                this.notificaciones('el Perfil fue actualizado con exito','la la-thumbs-up','success')                   
            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                                             
            });
        },         
        updateChildren: function(e,valor){
            var list=[]
            valor.options.map(function(value, key) {
                list.push(value.options.options.id)
            })    
            if(e.target.checked){     // seleccionamos todos
                this.dataRolModulo.checkedRol = _.union(this.dataRolModulo.checkedRol,list)
            }else{        // deseleccionamos todos
                this.dataRolModulo.checkedRol = _.difference(this.dataRolModulo.checkedRol,list)
            }
        } ,
        updateParent: function(e,valor,mod){
            var list=[]
            var search = false
            mod.options.map(function(value, key) {
                list.push(value.options.options.id)
            })      
            if(e.target.checked){
                if(_.indexOf(this.dataRolModulo.checkedRol,valor.options.idmenu)  == -1){
                    this.dataRolModulo.checkedRol.push(valor.options.idmenu)
                }
            }
            else{
                var self = this
                _.map(list, function(value) {
                if(_.indexOf(self.dataRolModulo.checkedRol,value)  > -1){
                    search = true
                    }
                }); 
                if(!search){
                    var i = _.indexOf(self.dataRolModulo.checkedRol,valor.idmenu)
                    self.dataRolModulo.checkedRol.splice(i,1)
                }
            }
        }                                                                          

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
    
    .label-grupo {
        text-align: left;
        border: 1px solid gray;
    }  

</style>
