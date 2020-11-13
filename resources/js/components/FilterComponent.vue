<template>
  <div class="prod_category-filter css-20369a">
    <div class="css-0bc721">
      <div class="css-bc16c0">
        <div>
          <div class="css-3fba6e">
            <div class="css-554658">
              <div class="css-844e64"></div>
              <div class="title css-56cb1d">Bộ lọc</div>
            </div>
            <div class="css-361513">
              <div class="css-d763f0">
                <div v-for="(filter, filterIndex) in selectedFilters" :key=filterIndex class="css-d763f0">
                  <div v-for="(value, indexValue) in filter.values" :key="indexValue" @click="delSelectedFilterValue(filterIndex, indexValue)" class="css-aa3ad4">
                    <span> {{ value }} </span>
                    <span class="css-2ba442">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-x"
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="#1435c3"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                      </svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <a
                target="_self"
                class="css-a9a90c"
              >
                <div v-if="selectedFilters.length > 0" @click="delSelectedFilterValue(null, null, true)" color="#ef2741" class="css-a94d62">
                  <span class="css-2dse8b" style="margin-right: 5px"
                    >Xóa bộ lọc</span
                  >
                </div>
              </a>
            </div>
          </div>
          <div class="css-strwe">
            <div v-for="filter in filters" :key="filter.filterName.ID" class="css-0f4d54">
              <div class="css-81e6e6">
                <div class="css-987424"> {{ filter.filterName.Name }} </div>
              </div>
              <div class="css-0d472a">
                <div id="js-brands">
                  <div
                    v-for="(f_Value, index) in filter.filterValues" :key="index"
                    data-track-content="true"
                    data-content-region-name="sortFilterProduct"
                    data-content-name="filterProductResult"
                    data-content-target="KINGSTON"
                    data-content-payload="brands"
                    class="css-8a614d"
                    @click="getProductsFilter(filter.filterName.ID, f_Value.Value)"
                  >
                    <div class="css-400bf0"></div>
                    <div v-html="f_Value.Value"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["f_lv", "pt_id"],
  data: function () {
    return {
      newFilter: this.pt_id,
      filters: null,
      selectedFilters: []
    };
  },
  created: function() {
    console.log("Trước khi khoi tạo component filter!")
    this.getNewFilter();
  },
  mounted: function () {
    console.log("Component Filter Mounted.");
    console.log(this.$store.state.user)
  },
  updated: function () {
    console.log("FilterComponent đã được cập nhật!")
  },
  methods: {
    getNewFilter: function () {
      let vm = this;
      axios
        .get("/prod-catalog-filters", {
          params: {
            f_lv: vm.f_lv,
            pt_c_id: vm.pt_id
          },
        })
        .then(function (response) {
          if(response.data.length == 0) {
            vm.$emit("hide_filters", false);
          }else {
            vm.$emit("hide_filters", true);
          }
          vm.filters = response.data;
        })
        .catch(function (error) {
          console.log("Lỗi lấy bộ lọc!");
        });
    },
    getProductsFilter: function(filterID, filterValue) {
      this.updateSelectedFilters(filterID, filterValue);
      let vm = this;
      axios
        .get("/prod-filters", {
          params: {
            prod_type: vm.pt_id,
            filters: JSON.stringify(vm.selectedFilters)
          }
        })
        .then(function (response) {
          console.log("Lấy các sản phẩm qua bộ lọc từ DB: ")
          console.log(response.data)
          vm.$store.commit("changeProdHomepage", response.data);
        })
        .catch(function (error) {
          console.log("Lỗi lấy sản phẩm theo bộ lọc!");
          console.log(error)
        });
    },
    updateSelectedFilters: function(filterType, filterValue) {
      let filterIndex = this.selectedFilters.findIndex((value, index) => { return value.filterID == filterType; });
      if(filterIndex >= 0) { // Thêm giá trị lọc mới vào bộ lọc đã có giá trị đc khởi tạo
        this.selectedFilters[filterIndex].values.push(filterValue);
        return;
      }
      this.selectedFilters.push({
        filterID: filterType,
        values: [filterValue]
      });
    },
    delSelectedFilterValue: function(filterIndex, indexValue, delAllFilters = false) {
      if(delAllFilters) { // Xóa tất cả bộ lọc
        this.selectedFilters.splice(0);
        return;
      }
      if(this.selectedFilters[filterIndex].values.length == 1) {
        // Nếu bộ lọc bất kì đang hiển thị chứa 1 giá trị lọc thì khi giá trị lọc đó đc click
        // thì bộ lọc đó bị xóa luôn
        this.selectedFilters.splice(filterIndex,1);
        return;
      }
      this.selectedFilters[filterIndex].values.splice(indexValue, 1); // Xóa 1 giá lọc đc chọn
    }
  },
  watch: {
    $route(to, from) {
      this.getNewFilter(); // Lấy bộ lọc mới khi route hiện tại chuyển sang route khác
      this.delSelectedFilterValue(null, null, true); // Xóa bộ lọc của route cũ
    }, 
    selectedFilters: function() {
      console.log("Bộ lọc đc chọn đã đc cập nhật!")
      console.log(this.selectedFilters)
    }
  },
};
</script>
