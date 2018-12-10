<template>
    <div class="row">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading> 
        <div class="col">
            <div class="card text-white bg-white mb-3">
                <div class="card-header">                          
                    <div class="col">
<!--                         <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nuevo Modulo</button>
 -->                    <div class="btn-group float-right" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="btn-label"><i class="flaticon-technology-1"></i></span> Nuevo
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#" @click.prevent="LoadMenu">Menú</a>
                                <a class="dropdown-item" href="#" @click.prevent="LoadOpcion">Opción</a>
                            </div>
                        </div>                        
                    </div>                                                        
                </div>
                <div class="card-body">
                    <div class="col-md-12 mt-10 p-0">
                        <div class="row ml-5 mr-5" style="display: flex; flex-wrap: wrap;">
                            <div class="col-md-6 pl-20 pr-20 pb-10" v-for="module in modules" :key="module.id" style="display: flex;flex-direction: column;">
                                <div class="table table-responsive table-bordered mb-10" style="width: 100%">
                                    <table class="table mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th><strong>{{module.name}}</strong></th>
                                                <th>
                                                    <button class="btn btn-link" @click.prevent="processEdit(module.idmenu,1)">
                                                        <span class="btn-label">
                                                            <i class="la la-edit"></i>
                                                        </span>
                                                        Editar
                                                    </button>
                                                    <button class="btn btn-link" :disabled="module.options.length > 0" @click.prevent="processDelete(module.idmenu)">
                                                        <span class="btn-label">
                                                            <i class="la la-trash"></i>
                                                        </span>
                                                        Eliminar
                                                    </button>                                                                                            
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="opcion in module.options" :key="opcion.options.options.id">
                                                <td>{{opcion.name}}</td> 
                                                <td>
                                                    <button class="btn btn-link" @click.prevent="processEdit(opcion.options.options.id,2)">
                                                        <span class="btn-label">
                                                            <i class="la la-edit"></i>
                                                        </span>
                                                        Editar
                                                    </button>
                                                    <button class="btn btn-link" @click.prevent="processDelete(opcion.options.options.id)">
                                                        <span class="btn-label">
                                                            <i class="la la-trash"></i>
                                                        </span>
                                                        Eliminar
                                                    </button>                                                       
                                                </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div><!-- /.table-responsive --> 
                            </div>
                        </div>
                    </div> 
                </div>
            </div>        
        </div> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="modulo" :width="'30%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de modulos -->
                <div class="card mb-0">
                    <div class="card-header pt-5 pb-5">
                        <div class="card-title">Registro de {{ labelSeleccion }}</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group pt-0 pb-0" v-if="MenuSelect">
                            <label for="exampleFormControlSelect1">Seleccione el Menú</label>
                            <select v-model="dataModulo.idparent" class="form-control form-control-sm" id="exampleFormControlSelect1" :disabled="!(typeof(dataModulo.id) === 'undefined')">
                            <option v-for="menu in getMenus" :value="menu.id" :key="menu.id">
                                {{ menu.name }}
                            </option>
                            </select>                            
                        </div>                    
                        <div class="form-group pb-0">
                            <label for="opcion">Nombre de {{ labelSeleccion }}</label>
                            <input type="text" id="opcion" placeholder="Nombre" class="form-control form-control-sm" v-model="dataModulo.name">
                        </div>
                        <div class="form-group pb-0">
                            <label for="icono">Icono</label>
                            <input type="text" id="icono" placeholder="Nombre de Icono" class="form-control form-control-sm" v-model="dataModulo.icono">
                        </div>
                        <div class="form-group pb-0">
                            <label for="ruta">Nombre de Ruta</label>
                            <input type="text" id="ruta" placeholder="Nombre de Ruta" class="form-control form-control-sm" v-model="dataModulo.name_router">
                        </div> 
                        <div class="form-group pb-0">
                            <label for="plantilla">Nombre en Plantilla</label>
                            <input type="text" id="plantilla" placeholder="Nombre en Plantilla" class="form-control form-control-sm" v-model="dataModulo.name_template">
                        </div>                                                                        
                        <div class="form-group pb-0">
                            <label for="orden">Numero de orden</label>
                            <input type="text" id="orden" placeholder="Número Orden" class="form-control form-control-sm" v-model="dataModulo.orden">
                        </div> 
                    </div>
                    <div class="card-action pb-10 pt-10">
                        <button class="btn btn-primary" @click.prevent="ActionModulo" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('modulo')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de modulos -->
        </modal>        

    </div>
   
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'modulos',
    mixins: [mixin],     
    mounted() {
        this.showToolTips()        
        this.$store.dispatch('LOAD_MENUS_LIST')
        this.$store.dispatch('LOAD_MODULES_LIST').then(() => {
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

            labelSeleccion:'',
            MenuSelect: true,

            dataModulo: {
                name: '',
                idparent: 0,
                type: '',
                icono: '',
                name_router: '',
                name_template: '',
                orden: 1
            },
            
            dataRolModulo : {
                idRol : '',
                checkedRol :[]
            },                                  
            errors:[]            
        }
    },
    computed: {
        ...mapState(['modules']),
        ...mapGetters(['getMenus','getModulo']),        
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },         
        LoadMenu: function() {
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')  

            this.MenuSelect = false 
            this.labelSeleccion = 'Menú'

            this.dataModulo =  {
                name: '',
                idparent: 0,
                type: 'menu',
                icono: '',
                name_router: '',
                name_template: '',
                orden: 1
            }    

            this.$modal.show('modulo')
        },
        LoadOpcion: function() {
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')   

            this.MenuSelect = true
            this.labelSeleccion = 'Opción'

            this.dataModulo =  {
                name: '',
                idparent: 0,
                type: 'option',
                icono: '',
                name_router: '',
                name_template: '',
                orden: 1
            }      

            this.$modal.show('modulo')
        },
        ActionModulo: function() {
            if(typeof(this.dataModulo.id) === "undefined"){
                this.createModulo()
            }else{
                this.updateModulo()
            }
        },
        createModulo: function(){
            var url = '/api/modulos';
            this.StatusForm(true,'la la-spinner','Procesando')       
            axios.post(url, this.dataModulo).then(response => {
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
            this.$store.dispatch('LOAD_MENUS_LIST')
            this.$store.dispatch('LOAD_MODULES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
            this.$modal.hide('modulo');
            this.notificaciones('Nuevo modulo creado con exito','la la-thumbs-up','success')                   
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updateModulo: function(){
            var url = '/api/modulos/'+this.dataModulo.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataModulo).then(response => {
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
            this.$store.dispatch('LOAD_MENUS_LIST')
            this.$store.dispatch('LOAD_MODULES_LIST')                    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
            this.$modal.hide('modulo');
            this.notificaciones('el Modulo fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                              
            });
        },        
        processEdit(id,type){
            var datamod = []
            var modulo = this.getModulo(id)
            datamod = _.clone(modulo[0])

            if(type === 1){     // menu
                this.MenuSelect = false 
                this.labelSeleccion = 'Menú'                
            }else{              // opcion
                this.MenuSelect = true
                this.labelSeleccion = 'Opción'
            }

            this.dataModulo = {
                id:datamod.id,
                name: datamod.name,
                idparent: datamod.idparent,
                type: datamod.type,
                icono: datamod.icono,
                name_router: datamod.name_router,
                name_template: datamod.name_template,
                orden: datamod.orden
            }                          
            this.$modal.show('modulo')
        
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
                        var url = '/api/modulos/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_MENUS_LIST').then(() => {
                                this.$store.dispatch('LOAD_MODULES_LIST').then(() => {
                                    this.isLoading = false
                                    this.$swal(
                                    'Eliminado!',
                                    'Este registro fue eliminado.',
                                    'success'
                                    )
                                }) 
                            })
                   
                        });
                    }
                });
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