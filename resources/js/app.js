/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Import Vuex store
const store = require('./store/index').default;

//Import View Router
const VueRouter = require('vue-router').default;
Vue.use(VueRouter);

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
    bind: function(el, binding, vnode) {
        this.event = function(event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', this.event)
    },
    unbind: function(el) {
        document.body.removeEventListener('click', this.event)
    },
});

Vue.component('menu-panel-component', require('./components/MenuPanelComponent.vue').default);
Vue.component('products-component', require('./components/ProductsComponent.vue').default);
Vue.component('pagination-component', require('./components/PaginationComponent.vue').default);
Vue.component('search-indicator-component', require('./components/SearchIndicatorComponent.vue').default);
Vue.component('product-detail-component', require('./components/ProductDetailComponent.vue').default);

const FilterComponent = Vue.component('filter-component', require('./components/FilterComponent.vue').default);
// const vtest = Vue.component('test-component', require('./components/TestComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const routes = [{
    path: '/product-category/lv/:f_lv/:pt_id/',
    name: 'productCategory',
    components: {
        productCatalogFilters: FilterComponent,
    },
    props: {
        default: true,
        // function mode, more about it below
        productCatalogFilters: route => ({ f_lv: route.params.f_lv, pt_id: route.params.pt_id })
    },

}];

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    router,
    store,
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
            // Tìm kiếm
            prodSearchQuery: '',
            prorductsSearched: null,
            // Kết thúc tìm kiếm
            listProducts: this.$store.state.products_homepage,
            productExists: true,
            // Các biến cho phân trang
            urlPaginHomepage: '/products',
            pageP: 1,
            defaultPageNumbs: 9,
            prodNumbDisplayed: 0,
            // Kết thúc các biến cho phân trang
            listSTPT: null,
            isHoveredOver: false,
            prodCatalogBtnClicked: false,
            filterDisplay: false,
        }
    },
    watch: {
        prodSearchQuery: function() {
            this.searchProduct(0);
        },
        pageP: function(newPageP, oldPageP) {
            let vm = this;
            axios.get('/products', {
                    params: {
                        page: newPageP,
                        prodNumbDisplayed: 30
                    }
                })
                .then(function(response) {
                    //   vm.listProducts = response.data.listProducts;
                    vm.$store.commit("changeProdHomepage", response.data.listProducts);
                    console.log("Lấy sản phẩm theo phân trang làm việc ở root!")
                })
                .catch(function(error) {
                    console.log("Lỗi phân trang!")
                });
        },
        "$store.state.products_homepage" (nv) {
            console.log("State.Products_Homepage đã đc thay đổi!")
            this.listProducts = this.$store.state.products_homepage;
            this.productExists = (this.listProducts.length > 0) ? true : false;
        },
        prorductsSearched: function() {
            console.log("Danh sách sản phẩm đc tìm kiếm đã đc cập nhật!")
        }
    },
    methods: {
        turnOffProdCDropDown: function() {
            if ($('.css-036586').length == 2) {
                this.prodCatalogBtnClicked = false;
            }
        },
        mouseoverMI: function(listSTPT) {
            this.listSTPT = listSTPT;
            this.isHoveredOver = true;
        },
        mouseleaveMI: function() {
            // this.isHoveredOver = false;
        },
        runResPagination: function() {
            let objApp = this;
            let wmM__minW400 = window.matchMedia("(min-width: 400px)"); // defaultPageNumbs = 9  
            let wmM__minW320_maxW400 = window.matchMedia("(min-width: 320px) and (max-width: 400px)"); // defaultPageNumbs = 7
            let wmM__maxW320 = window.matchMedia("(max-width: 320px)"); // defaultPageNumbs = 5

            objApp.defaultPageNumbs = (wmM__minW320_maxW400.matches) ? 7 : ((wmM__maxW320.matches) ? 5 : 9); // 9 khi wmM__minW400.matches == true

            wmM__minW400.addListener(objApp.updateDefaultPageNumbs(this, 9));
            wmM__minW320_maxW400.addListener(objApp.updateDefaultPageNumbs(this, 7));
            wmM__maxW320.addListener(objApp.updateDefaultPageNumbs(this, 5));
        },
        updateDefaultPageNumbs: function(jsMediaQ, pageNumb) {
            if (jsMediaQ.matches) {
                // this.defaultPageNumbs = pageNumb;
                this.$store.commit("changeDefaultPageNumb_P", pageNumb);
            }
        },
        pageChangePagination: function(page) {
            this.pageP = page;
        },
        updateProdListByFilter: function(pt_c) {
            console.log("")
            console.log("Đã đc chọn!")
            console.log("")
            this.turnOffProdCDropDown();
            let f_lv = 1,
                pt_c_ID = null;
            if (isNaN(pt_c)) {
                f_lv = pt_c.lv_c_pt;
                pt_c_ID = pt_c.pt_c_id;
            } else {
                pt_c_ID = pt_c;
            }

            let vm = this;
            axios
                .get('/prod-catalog', {
                    params: {
                        f_lv,
                        pt_c_ID,
                        page: 1
                    }
                })
                .then(function(response) {
                    vm.$store.commit("changeProdHomepage", response.data.listProducts);
                    vm.$store.commit("changeTotalNumbPage_P", response.data.total_pages);
                    if (vm.$store.state.pagination.paging_type != 2) {
                        vm.$store.commit("changePagingType_P", 2); // 2: Phân trang cho các sản phẩm theo danh mục hoặc loại sản phẩm
                    }
                    vm.$store.commit("changeProdCatalog", { lv_pt_c: f_lv, pt_c_ID })
                    console.log("")
                    console.log("Các sản phẩm thỏa mãn loại hoặc danh mục sản phẩm!")
                    console.log(response.data.listProducts)
                    console.log("")
                })
                .catch(function(error) {
                    console.log("Lỗi chíp!")
                });
        },
        hideFilters: function(bool_fd) { // Ẩn bộ lọc
            this.filterDisplay = bool_fd;
        },
        changeUrlParamsPaginHomepage: function() { // Thay đổi url và param cho phân trang ở route home
            this.$store.commit("changeUrl_P", this.urlPaginHomepage);
        },
        // Tìm kiếm sản phẩm
        searchInputFocus: function() {
            if (this.prodSearchQuery != "") {
                this.searchProduct(0);
            }
        },
        hideIndicator: function() {
            this.prorductsSearched = null;
        },
        searchProduct: _.debounce(function(show_all) {
            console.log("")
            console.log("Giá trị đc tìm kiếm")
            console.log(show_all)
            console.log("")
            let vm = this;
            axios
                .get('/search-product', {
                    params: {
                        show_all,
                        info_searched: vm.prodSearchQuery,
                        page: 1
                    }
                })
                .then(function(response) {
                    vm.prorductsSearched = show_all == 1 ? null : response.data.listProducts;
                    if (show_all == 1) {
                        vm.filterDisplay = false; // Ẩn đi bộ lọc
                        vm.$store.commit("changeProdHomepage", response.data.listProducts);
                        vm.$store.commit("changeTotalNumbPage_P", response.data.total_pages);
                        vm.$store.commit("changeInfoSearched", vm.prodSearchQuery);
                        if (vm.$store.state.pagination.paging_type != 4) {
                            vm.$store.commit("changePagingType_P", 4); // 4: Phân trang cho các sản phẩm thỏa mãn giá trị tìm kiếm
                        }
                    }
                })
                .catch(function(error) {
                    console.log("Lỗi lấy sản phẩm khi tìm kiếm!")
                });
        }, 200),
        // Sắp xếp sản phẩm
        sortBestPromotion: function() {
            let vm = this;
            axios
                .get('/search-product', {
                    params: {
                        show_all,
                        info_searched: vm.prodSearchQuery,
                        page: 1
                    }
                })
                .then(function(response) {
                    vm.prorductsSearched = show_all == 1 ? null : response.data.listProducts;
                    if (show_all == 1) {
                        vm.filterDisplay = false; // Ẩn đi bộ lọc
                        vm.$store.commit("changeProdHomepage", response.data.listProducts);
                        vm.$store.commit("changeTotalNumbPage_P", response.data.total_pages);
                        vm.$store.commit("changeInfoSearched", vm.prodSearchQuery);
                        if (vm.$store.state.pagination.paging_type != 4) {
                            vm.$store.commit("changePagingType_P", 4); // 4: Phân trang cho các sản phẩm thỏa mãn giá trị tìm kiếm
                        }
                    }
                })
                .catch(function(error) {
                    console.log("Lỗi lấy sản phẩm khi tìm kiếm!")
                });
        }
    }
});