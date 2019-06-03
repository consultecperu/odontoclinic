
window._ = require('lodash');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import VModal from 'vue-js-modal'
import './interceptors'
import VueGoodTable from 'vue-good-table'
import 'vue-good-table/dist/vue-good-table.css'
import ToggleButton from 'vue-js-toggle-button'
import underscore from 'vue-underscore'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import VueSweetalert2 from 'vue-sweetalert2'
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import Autocomplete from 'vuejs-auto-complete'
import Tooltip from 'vue-directive-tooltip'
import 'vue-directive-tooltip/css/index.css'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import 'pretty-checkbox/src/pretty-checkbox.scss'
import PrettyCheckbox from 'pretty-checkbox-vue'
import contextMenu from 'vue-context-menu'
import FullCalendar from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css'
import 'beautify-scrollbar/dist/index.css';
import 'v2-table/dist/index.css';
import V2Table from 'v2-table';
//import Datepicker from 'vuejs-datepicker';
import DatePicker from 'vue2-datepicker'
import Datatable from 'vue2-datatable-component';
import locale from 'vue2-datatable-component/locale/es-pe'
import MaskedInput from 'vue-masked-input'

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.use(VueRouter)
Vue.use(VueGoodTable)
Vue.use(VModal)
Vue.use(ToggleButton)
Vue.use(underscore)
Vue.use(Loading)
Vue.component('loading', Loading)
Vue.use(VueSweetalert2)
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
Vue.component('autocomplete',Autocomplete)
Vue.use(Tooltip)
Vue.component('multiselect', Multiselect)
Vue.use(PrettyCheckbox)
Vue.component('context-menu',contextMenu)
Vue.use(FullCalendar)
Vue.use(V2Table)
//Vue.component('Datepicker', Datepicker)
Vue.component('DatePicker', DatePicker)
Vue.component('MaskedInput',MaskedInput)
Vue.use(Datatable, { locale }) // done!