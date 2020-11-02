/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        this.event = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', this.event)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', this.event)
    },
});

Vue.component('menu-panel-component', require('./components/MenuPanelComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    mounted: function() {
        let scriptJs = document.createElement('script');
        scriptJs.setAttribute('src', '/js/client/common.js');
        document.body.appendChild(scriptJs)
    },
    data: function() {
        return {
            listSTPT: null,
            isHoveredOver: false,
            prodCatalogBtnClicked: false,
        }  
    },
    methods: {
        turnOffProdCDropDown: function() {
            if($('.css-036586').length == 2) {
                this.prodCatalogBtnClicked = false;
            }
        },
        mouseoverMI: function(listSTPT) {
            this.listSTPT = listSTPT;
            this.isHoveredOver = true;
        },
        mouseleaveMI: function() {
            this.isHoveredOver = false;
        }
    }
});
