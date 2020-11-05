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
Vue.component('products-component', require('./components/ProductsComponent.vue').default);
Vue.component('pagination-component', require('./components/PaginationComponent.vue').default);

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
        scriptJs.setAttribute('type', 'module');
        document.body.appendChild(scriptJs);
        
        this.runResPagination();
    },
    data: function() {
        return {
            listProducts: null,
            // Các biến cho phân trang
            pageP: 1, 
            defaultPageNumbs: 9,
            prodNumbDisplayed: 0,
            // Kết thúc các biến cho phân trang
            listSTPT: null,
            isHoveredOver: false,
            prodCatalogBtnClicked: false,
        }  
    },
    watch: {
        pageP: function(newPageP, oldPageP) {
            let vm = this;
            axios.get('/products', {
                params: {
                    page: newPageP,
                    prodNumbDisplayed: 30
                }
            })
            .then(function (response) {
              vm.listProducts = response.data.listProducts;
            })
            .catch(function (error) {
              console.log("Lỗi phân trang!")
            });
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
        }, 
        runResPagination: function() {
            let objApp = this;
            let wmM__minW400 = window.matchMedia("(min-width: 400px)"); // defaultPageNumbs = 9  
            let wmM__minW320_maxW400 = window.matchMedia("(min-width: 320px) and (max-width: 400px)"); // defaultPageNumbs = 7
            let wmM__maxW320 = window.matchMedia("(max-width: 320px)"); // defaultPageNumbs = 5

            objApp.defaultPageNumbs = (wmM__minW320_maxW400.matches) ? 7 : ((wmM__maxW320.matches) ? 5: 9); // 9 khi wmM__minW400.matches == true
        
            wmM__minW400.addListener(objApp.updateDefaultPageNumbs(this, 9));
            wmM__minW320_maxW400.addListener(objApp.updateDefaultPageNumbs(this, 7));
            wmM__maxW320.addListener(objApp.updateDefaultPageNumbs(this, 5));
        }, 
        updateDefaultPageNumbs: function(jsMediaQ, pageNumb) {
            if(jsMediaQ.matches) {
                this.defaultPageNumbs = pageNumb;
            }
        },
        pageChangePagination: function(page) {
            this.pageP = page;
        }
    }
});
