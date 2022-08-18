import './bootstrap';
import './config';
import './flash';
import './mobile-check';
import './zoom';

import Vue from 'vue';
import AddScriptPlugin from './plugins/addScripts';
import VueTheMask from 'vue-the-mask'

import Validator from './plugins/validator';

window.DEBUG  = false;

import Header from './components/HeaderComponent.vue';
import Side from './components/SideComponent.vue';
import Footer from './components/FooterComponent.vue';
import Cover from './components/CoverComponent.vue';

import StateCreate from './components/states/StateCreateComponent.vue';
import StateEdit from './components/states/StateEditComponent.vue';
import State from './components/states/StateComponent.vue';

import City from './components/cities/CityComponent.vue';
import CityCreate from './components/cities/CityCreateComponent.vue';
import CityEdit from './components/cities/CityEditComponent.vue';

import User from './components/users/UserComponent.vue';
import UserCreate from './components/users/UserCreateComponent.vue';
import UserEdit from './components/users/UserEditComponent.vue';

Vue.use(AddScriptPlugin);
Vue.use(Validator);
Vue.use(VueTheMask)

const app = new Vue({
    el: '#app',
    components: {
        'app-header': Header,
        'app-side': Side,
        'app-footer': Footer,
        'app-cover': Cover,

        'app-state-create': StateCreate,
        'app-state-edit': StateEdit,
        'app-state': State,

        'app-city': City,
        'app-city-create': CityCreate,
        'app-city-edit': CityEdit,

        'app-user': User,
        'app-user-create': UserCreate,
        'app-user-edit': UserEdit,

    }
});