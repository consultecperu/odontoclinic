<template>
    <div class="content">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>         
        <div class="container-fluid">
            <div class="row">
                  <div class="card col-12">
                      <div class="card-header">
                          <div class="row">
                              <div class="col-12">
                                  <date-picker @change="cambiarFecha" v-model="fecha_fullcalendar" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker> 
                              </div>
                          </div>                        
                      </div>
                      <div class="card-body">
                          <vFullCalendar
                            class='demo-app-calendar'
                            ref="fullCalendar"
                            defaultView="resourceTimeGridDay"  
                            :header="header"
                            locale="es"
                            :editable="true"
                            :selectable="true"
                            :nowIndicator="true"
                            slotDuration ='00:15:00'  
                            :slotLabelFormat ="format_hora"  
                            :buttonText="button_text"                       
                            minTime ='08:00:00'
                            maxTime ='24:00:00'
                            :allDaySlot="false"
                            :eventLimit="true"    
                            :plugins="calendarPlugins"
                            :weekends="calendarWeekends"
                            :events="calendarEvents"
                            :resources="resources"
                            @dateClick="handleDateClick"
                            @select="handleDateClick"
                            @datesRender="handleDatesRender"
                            />
                      </div>
                  </div>

            </div>
        </div>
    </div> 
</template>
<script>
import vFullCalendar from '@fullcalendar/vue'
import vdayGridPlugin from '@fullcalendar/daygrid'
import vtimeGridPlugin from '@fullcalendar/timegrid'
import vinteractionPlugin from '@fullcalendar/interaction'
import vresourceTimelinePlugin from '@fullcalendar/resource-timeline'
import vresourceTimeGridDay from '@fullcalendar/resource-timegrid'
import 'fullcalendar/dist/locale/es'

import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'consultorios',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_TURNOS_LIST')
        this.$store.dispatch('LOAD_TURNOS_ESPECIALES_LIST')
        this.$store.dispatch('LOAD_PERMISOS_LIST')
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')
        //this.$store.dispatch('LOAD_PACIENTES_LIST')
        this.$store.dispatch('LOAD_DATA_INIT_LIST')  
        window.addEventListener('scroll', this.handleScroll);              
    },  
  components: {
    vFullCalendar // make the <FullCalendar> tag available
  },
  data: function() {
    return {
            isLoading: false,
            fullPage: true,  

            header: { 
                left: 'prev,next', 
                center: 'title', 
                right: 'today' 
            }, 
            format_hora : {
              hour: 'numeric',
              minute: '2-digit',
              omitZeroMinute: false,
              meridiem: 'short'
            },
            button_text:{
              today: 'Hoy',
              month: 'Mes',
              week: 'Semana',
              day: 'Dia',
              list: 'Lista'
            },
            calendarPlugins: [ vresourceTimelinePlugin ,vresourceTimeGridDay ,vinteractionPlugin],
            calendarWeekends: true,
/*             resources: [
              { id: 'a', title: 'Consultorio 1' ,businessHours: [ // specify an array instead
                {
                  daysOfWeek: [ 1, 2, 3 ], // Monday, Tuesday, Wednesday
                  startTime: '08:00', // 8am
                  endTime: '14:00' // 2pm
                },
                {
                  daysOfWeek: [ 1, 2, 3 ], // Monday, Tuesday, Wednesday
                  startTime: '16:00', // 8am
                  endTime: '22:00' // 2pm
                },  
                {
                  daysOfWeek: [ 4, 5 ], // Thursday, Friday
                  startTime: '10:00', // 10am
                  endTime: '14:00' // 2pm
                }
              ]},
              { id: 'b', title: 'Consultorio 2', eventColor: 'green' },
              { id: 'c', title: 'Consultorio 3', eventColor: 'orange' },
              { id: 'd', title: 'Consultorio 4', eventColor: 'red' }
            ], */
            resources :[],
            calendarEvents: [
              { id: '1', resourceId: 'a', start: '2019-05-26', end: '2019-05-28', title: 'event 1' },
              { id: '2', resourceId: 'a', start: '2019-05-27T09:00:00', end: '2019-05-27T14:00:00', title: 'event 2' },
              { id: '3', resourceId: 'b', start: '2019-05-27T12:00:00', end: '2019-05-28T06:00:00', title: 'event 3' },
              { id: '4', resourceId: 'c', start: '2019-05-27T07:30:00', end: '2019-05-27T09:30:00', title: 'event 4' },
              { id: '5', resourceId: 'd', start: '2019-05-27T10:00:00', end: '2019-05-27T15:00:00', title: 'event 5' }
            ], 
            //resources: [],
            //calendarEvents :[],
            lang: {
                days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                months: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'Seleccione Dia',
                    dateRange: 'Select Date Range'
                }
            }, 
            fecha_fullcalendar:'',
            turn_especials :[],
            turn_permisos:[]              
    }
  },
  computed: {
      ...mapState(['user_system','sede_system','especialidades','documentos','pacientes','turnos','turnosespeciales','citasconsultorios','estadocitas','permisos']),
      ...mapGetters(['getMedicos','getDocumentosIdentidad']),                  
  },   
  methods: {
    handleDateClick(arg) {
      if (confirm('Would you like to add an event to ' + arg.dateStr + ' ?')) {
        this.calendarEvents.push({ // add new event data
          title: 'New Event',
          start: arg.date,
          allDay: arg.allDay
        })
      }
    },

    handleDatesRender(info){    // recarga la vista
    let self = this
      //console.log("dates",info.view.currentStart)
      let other_resources = this.CargaTurnoMedico(info.view.currentStart)

      _.each(other_resources, function(value,key){
          self.resources.push(value)            
      })            

      let calendario = this.$refs.fullCalendar.getApi()      
    },
    handleviewSkeletonRender(info){
      console.log("info",info)
    },
    cambiarFecha(){
      let fec = moment(this.fecha_fullcalendar).format('YYYY-MM-DD')
      let calendarApi = this.$refs.fullCalendar.getApi() // from the ref="..."
      calendarApi.gotoDate(fec) // call a method on the Calendar object 
      //console.log("fec_start",calendarApi.getDate())     //fecha actual del FullCalendar
    },
    CargaTurnoMedico(fec){
        let self = this
        let numdia = moment(fec).day()
        let bussinessDoctor = []
        this.turn_especials = []    // turnos especiales del doctor
        this.turn_permisos = []
        let turnomedico = this.turnos.filter(tur => tur.dia_id == numdia && tur.empleado.tipo == 1)
        //console.log("turnos",turnomedico)
        let turnomedico_esp = this.turnosespeciales.filter(tur => moment(tur.fecha).day() == numdia && tur.empleado.tipo == 1)
        //let permisos = this.permisos.filter(per => per.empleado_id == this.dataCita.empleado_id)        
        let turncompleto = []
        _.each(turnomedico, function(value,key){
            bussinessDoctor = []
            let turn_med = {
              id :'',
              title:'',
              businessHours:[]
            }
            if(value.horaini1 != null && value.horafin1 != null){
                let dataturn = {
                    daysOfWeek:[],
                    startTime:'',
                    endTime:''
                }                
                dataturn.daysOfWeek.push(numdia)
                dataturn.startTime = value.horaini1.nombre_hora
                dataturn.endTime = value.horafin1.nombre_hora
                let copyt = _.clone(dataturn)
                bussinessDoctor.push(copyt) 
            }
            
            if(value.horaini2 != null && value.horafin2 != null){
                let dataturn = {
                    daysOfWeek:[],
                    startTime:'',
                    endTime:''
                }                
                dataturn.daysOfWeek.push(numdia)
                dataturn.startTime = value.horaini2.nombre_hora
                dataturn.endTime = value.horafin2.nombre_hora
                let copyt = _.clone(dataturn)
                bussinessDoctor.push(copyt)                                     
            }
            turn_med.id = value.empleado_id
            turn_med.title = value.empleado.nombre_completo
            turn_med.businessHours = bussinessDoctor
            let copytc = _.clone(turn_med)
            turncompleto.push(copytc)
        })
        //let turnomedico_esp = this.turnosespeciales.filter(tur => tur.empleado_id == this.dataCita.empleado_id)
        //let permisos = this.permisos.filter(per => per.empleado_id == this.dataCita.empleado_id)
        _.each(turnomedico_esp, function(value,key){
            if(moment().isBefore(value.fecha) || moment().isSame(value.fecha)){
              if(value.horaini1 != null && value.horafin1 != null){
                  let evento = {
                      resourceId:value.empleado_id,
                      start : String(value.fecha) + 'T' + value.horaini1.nombre_hora + ':00',
                      end: String(value.fecha) + 'T' + value.horafin1.nombre_hora + ':00',
                      rendering: 'background',
                      color: '#99FF00',
                      especial: 'si'
                  }
                  self.turn_especials.push(evento)
              }               
              if(value.horaini2 != null && value.horafin2 != null){
                  let evento = {
                      resourceId:value.empleado_id,
                      start : String(value.fecha) + 'T' + value.horaini2.nombre_hora + ':00',
                      end: String(value.fecha) + 'T' + value.horafin2.nombre_hora + ':00',
                      rendering: 'background',
                      color: '#99FF00',
                      especial: 'si'
                  }
                  self.turn_especials.push(evento)                                      
              } 
            }                          
        })
         _.each(turnomedico, function(valuet,keyt){
              let permisos_med = self.permisos.filter(per => per.empleado_id == valuet.empleado_id)
              _.each(permisos_med, function(value,key){
                  if(moment(value.fecha_inicio).day() == numdia){
                    let fec_ini = moment(value.fecha_inicio,'DD-MM-YYYY').format('YYYY-MM-DD')
                    let fec_fin = value.fecha_fin != null ? moment(value.fecha_fin,'DD-MM-YYYY').format('YYYY-MM-DD') : ''
                    let evento = {
                        resourceId:value.empleado_id,
                        start : value.tipopermiso == 1 ?  String(fec_ini) : String(fec_ini) + 'T' + value._horaini.nombre_hora + ':00', 
                        end: value.tipopermiso == 1 ? String(fec_fin) : String(fec_ini) + 'T' + value._horafin.nombre_hora + ':00',
                        rendering: 'background',
                        color: 'red',
                        especial: 'no'
                    }
                    self.turn_permisos.push(evento)  
                  }
                                  
              })
         })
         console.log("carga_completa",turncompleto)
        return turncompleto           
    },
    CargaFullcalendar(fdata){
        let self = this
        this.isLoading = true
        let fec = moment(fdata).format('DDMMYYYY')
        this.$store.dispatch('LOAD_CITAS_CONSULTORIOS_LIST',{ fecha : fec }).then(() => {
            console.log("citas",this.citasconsultorios)
            //this.cargaEventos(this.citasconsultorios)
            this.isLoading = false 
        }) 
      
    },    
  }    
}
</script>
<style scoped>
    .demo-app-calendar {
      margin: 0 auto;
      max-width: 900px;
    }
    .v--modal-overlay {
        z-index:9000;     
    }    
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
     
</style>
