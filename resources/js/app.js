/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
//import Vuelidate from 'vuelidate';
import VueApexCharts from 'vue-apexcharts'



Vue.use(VueRouter);
Vue.use(VueApexCharts);


//Vue.use(Vuelidate);
Vue.component('apexchart', VueApexCharts);
Vue.filter('splitNumber',function(value){
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g," ");
});
Vue.directive('space',{
    update(el){
            //console.log(el.value);
            var num  = el.value.toString().replace(/ /g,'');
            
            el.value = num.replace(/\B(?=(\d{3})+(?!\d))/g," ");
           console.log(el.value);
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))



import Home from './components/HomeComponent.vue';
import Navbar from './components/NavbarComponent.vue';

import Article from './components/ArticleComponent.vue';
import Addkit from './components/AddkitComponent.vue';
import AddStock from './components/AddStockComponent';

import Etab from './components/EtabComponent';
import Selection from './components/SelectionComponent.vue';
import Repart from './components/RepartComponent.vue';

import Defect from './components/DefectComponent.vue';

import HistoEntre from './components/Histo_entreComponent.vue';
import HistoRepart from './components/Histo_repartComponent.vue';
import HistoDist from './components/HistoDistComponent.vue';

import Dist from './components/DistComponent.vue';
import Art from './components/ArtComponent.vue';

import ListEtab from './components/ListEtabComponent.vue';
import Classe from './components/ClasseComponent.vue';

import Epp from './components/EppComponent.vue';
import Ceg from './components/CegComponent.vue';
import Lycee from './components/LyceeComponent.vue';

import Recap from './components/RecapComponent.vue';
import Detail from './components/DetailComponent.vue';
import RecapStock from './components/RecapStockComponent.vue';
import Aute from './components/AutreComponent.vue';

import Task3 from './components/Task3Component.vue';
import Task4 from './components/Task4Component.vue';



/*Vue.component('navbarcomponent',require('./components/NavbarComponent.vue').default);
Vue.component('sidebarcomponent',require('./components/SidebarComponent.vue').default);*/

const routes = [
    { path: '/', component: Article, name: 'homepage' },
    { path: '/addkit', component: Addkit , children:[
        { path: '', component: AddStock},
        { path: 'defect', component: Defect }
    ]},
    { path: '/dist', component: Dist , children:[
       { path: '', component: Selection ,name: 'selection' },
       { path: 'create', component: Art, name: 'distribution' }
    ]},
    { path: '/etablissement', component: Etab },
    { path: '/list_etab', component: ListEtab },
    { path: '/effectifs_eleves', component: Classe, children:[
       { path: '', component: Epp },
       { path: 'ceg', component: Ceg },
       { path: 'lycee', component: Lycee }
    ] },
    { path: '/histo_entre', component: HistoEntre },
    { path: '/histo_repart', component: HistoRepart },
    { path: '/histo_dist', component: HistoDist },
    { path : '/repart',name: 'repartition', component: Repart},
    { path: '/recap', component : Recap},
    { path: '/recap_stock', component: RecapStock },
    { path: '/detail', component : Detail ,name: 'detail'},
    { path: '/other', component: Aute },

    { path: '/task3', component: Task3 },
    { path: '/task4', component: Task4 }
];

const router = new VueRouter({routes});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components:{
        Home,
        Article,
        Addkit,
        AddStock,
        Repart,
        Dist,
        Selection,
        Art,
        HistoEntre,
        HistoRepart,
        Task3,
        Task4,
        Defect,
        Navbar
    },
    router: router,
    data:{
        link: '',
        target: 'Home'
    }
});


