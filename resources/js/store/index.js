// store/index.js

import Vue from 'vue'
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        products_homepage: null,
        prodCatalog: { // Đc dùng trong component khác khi người dùng chọn danh mục hoặc loại sản phẩm
            lv_pt_c: null,
            pt_c_ID: null, // Mã loại hoặc mã danh mục
        },
        pagination: { // Chứa các key đc dùng trong pagination (PaginationComponent)
            paging_type: 1, // Mặc định phân trang dc hiển thị cho các sản phẩm ở trang home
            total_pages: 0,
            default_page_numbs: 9,
        },
        filtersProdType: { // Được dùng trong bộ lọc (FilterComponent)
            prod_type: null,
            filters: null,
        },
        searchProduct: {
            infoSearched: ""
        }
    },
    getters: {},
    mutations: {
        changeProdHomepage(state, newProducts) {
            state.products_homepage = newProducts;
            console.log("Sản phẩm trên store đã đc cập nhật!")
            console.log(newProducts)
        },
        // Cập nhật cho phần phân trang
        changePagingType_P(state, paging_type) { // P là pagination
            state.pagination.paging_type = paging_type;
        },
        changeTotalNumbPage_P(state, total_pages) {
            state.pagination.total_pages = total_pages;
        },
        changeDefaultPageNumb_P(state, defaultPageNumb) {
            state.pagination.default_page_numbs = defaultPageNumb;
        },
        changeUrl_P(state, url) {
            state.pagination.url = url;
        },
        changeParams_P(state, params) {
            state.pagination.params = params;
        },
        // Cập nhật loại bộ lọc, các giá trị lọc mới
        changeFiltersProdType_F(state, p_filtersProdType) { // F: filters
            state.filtersProdType.prod_type = p_filtersProdType.prod_type;
            state.filtersProdType.filters = p_filtersProdType.filters;
        },
        // Cập nhật cấp độ, loại của danh mục hoặc loại sản phẩm
        changeProdCatalog(state, pt_c) {
            state.prodCatalog.lv_pt_c = pt_c.lv_pt_c;
            state.prodCatalog.pt_c_ID = pt_c.pt_c_ID;
        },
        // Cập nhật tìm kiếm
        changeInfoSearched(state, infoSearched) {
            state.searchProduct.infoSearched = infoSearched;
        }

    },
    actions: {}
});