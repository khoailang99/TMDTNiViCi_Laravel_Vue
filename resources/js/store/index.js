// store/index.js

import Vue from 'vue'
import Vuex from 'vuex';
 
Vue.use(Vuex);
 
export default new Vuex.Store({
 state: {
  products_homepage: null,
  user: "cuong",
 },
  getters: {},
  mutations: {
    changeProdHomepage(state, newProducts) {
      state.products_homepage = newProducts;
      console.log("Sản phẩm trên store đã đc cập nhật!")
      console.log(newProducts)
    },
  },
  actions: {}
});
