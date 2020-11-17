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
                <div
                  v-for="(filter, filterIndex) in selectedFilters"
                  :key="filterIndex"
                  class="css-d763f0"
                >
                  <div
                    v-for="(value, indexValue) in filter.values"
                    :key="indexValue"
                    @click="getProductsFilter(filter.filterID, value.filterValue, value.elemHTML)"
                    class="css-aa3ad4"
                  >
                    <span> {{ value.filterValue }} </span>
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
              <a target="_self" class="css-a9a90c">
                <div
                  v-if="selectedFilters.length > 0"
                  @click="selectedFilters.splice(0)"
                  color="#ef2741"
                  class="css-a94d62"
                >
                  <span class="css-2dse8b" style="margin-right: 5px"
                    >Xóa bộ lọc</span
                  >
                </div>
              </a>
            </div>
          </div>
          <div class="css-strwe">
            <div
              v-for="filter in filters"
              :key="filter.filterName.ID"
              class="css-0f4d54"
            >
              <div class="css-81e6e6">
                <div class="css-987424">{{ filter.filterName.Name }}</div>
              </div>
              <div class="css-0d472a">
                <div id="js-brands">
                  <div
                    v-for="(f_Value, index) in filter.filterValues"
                    :key="index"
                    data-track-content="true"
                    data-content-region-name="sortFilterProduct"
                    data-content-name="filterProductResult"
                    data-content-target="KINGSTON"
                    data-content-payload="brands"
                    class="css-8a614d"
                    @click="
                      getProductsFilter(filter.filterName.ID, f_Value.Value, $event.currentTarget)
                    "
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
      filters: null,
      selectedFilters: [],
    };
  },
  created: function () {
    console.log("Trước khi khoi tạo component filter!");
    this.getNewFilter();
  },
  mounted: function () {
    console.log("Component Filter Mounted.");

    // Cập nhật loại phân trang ở trên store
    this.$store.commit("changePagingType_P", 3); // 3: Phân trang cho các sản phẩm đã đc lọc
  },
  updated: function () {
    console.log("FilterComponent đã được cập nhật!");
  },
  methods: {
    getNewFilter: function () {
      let vm = this;
      axios
        .get("/prod-catalog-filters", {
          params: {
            f_lv: vm.f_lv,
            pt_c_id: vm.pt_id,
          },
        })
        .then(function (response) {
          if (response.data.length == 0) {
            vm.$emit("hide_filters", false);
          } else {
            vm.$emit("hide_filters", true);
          }
          vm.filters = response.data;
        })
        .catch(function (error) {
          console.log("Lỗi lấy bộ lọc!");
        });
    },
    getProductsFilter: function (filterID, filterValue, elemHTML) {
      if (elemHTML) {
        if($(elemHTML).attr('class').indexOf('active') > 0) {
          $(elemHTML).toggleClass('active').children('div.css-4ec51c','div.css-d6d985').remove();
        }else {
          $(elemHTML).toggleClass('active').append('<div class="css-4ec51c"></div><span class="css-d6d985"> &#x2713; </span>')
        }
      }
      this.updateSelectedFilters(filterID, filterValue, elemHTML);

      
      let vm = this;
      let filtersProdType = {
        prod_type: vm.pt_id,
        filters: JSON.stringify(vm.selectedFilters.map(function(filter){
            return {
              filterID: filter.filterID,
              values: filter.values.map(function(value){
                return value.filterValue;
              })
            };
          })
        ),
      };
      
      if(this.selectedFilters.length > 0) {
        axios
        .get("/prod-filters", {
          params: filtersProdType,
        })
        .then(function (response) {
          vm.$store.commit("changeProdHomepage", response.data.listProducts);
          if (vm.$store.state.pagination.paging_type != 3) {
            vm.$store.commit("changePagingType_P", 3); // 3: Phân trang cho các sản phẩm đã đc lọc
          }
          vm.$store.commit("changeTotalNumbPage_P", response.data.totalPages);
          vm.$store.commit("changeFiltersProdType_F", filtersProdType);

          console.log("Total_pages - " + response.data.totalPages);
        })
        .catch(function (error) {
          console.log("Lỗi lấy sản phẩm theo bộ lọc!");
          console.log(error);
        });
      }
    },
    updateSelectedFilters: function (filterType, filterValue, elemHTML) {
      
      let filterIndex = this.selectedFilters.findIndex((value, index) => {
        return value.filterID == filterType;
      });
      let filter = this.selectedFilters[filterIndex];

      

      if (filterIndex >= 0) {
       
        // Thêm giá trị lọc mới vào bộ lọc đã có giá trị đc khởi tạo
        let indexFilterValue = -1;
        filter.values.forEach((value, index) => {
          if(value.filterValue == filterValue ) {
            indexFilterValue = index;
            return;
            console.log("^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^")
          }
        });
        console.log("")
        console.log("filterType")
        console.log(indexFilterValue)
        console.log(filter.values)
        console.log("")
        if (indexFilterValue >= 0) {
          if (filter.values.length == 1) {
            this.selectedFilters.splice(filterIndex, 1);
            return;
          }
          filter.values.splice(indexFilterValue, 1);
        } else {
          
          filter.values.push({
            filterValue,
            elemHTML
          });
        }

        return;
      }
      this.selectedFilters.push({
        filterID: filterType,
        values: [{
          filterValue,
          elemHTML
        }],
      });
    },
    delSelectedFilterValue: function (
      filterIndex,
      indexValue,
      delAllFilters = false
    ) {
      if (delAllFilters) {
        // Xóa tất cả bộ lọc
        this.selectedFilters.splice(0);
        return;
      }
      if (this.selectedFilters[filterIndex].values.length == 1) {
        // Nếu bộ lọc bất kì đang hiển thị chứa 1 giá trị lọc thì khi giá trị lọc đó đc click
        // thì bộ lọc đó bị xóa luôn
        this.selectedFilters.splice(filterIndex, 1);
        return;
      }
      this.selectedFilters[filterIndex].values.splice(indexValue, 1); // Xóa 1 giá lọc đc chọn
    },
  },
  watch: {
    $route(to, from) {
      this.getNewFilter(); // Lấy bộ lọc mới khi route hiện tại chuyển sang route khác
      this.selectedFilters.splice(0); // Xóa bộ lọc của route cũ
    },
    selectedFilters: function () {
      if (this.selectedFilters.length == 0) {
        let vm = this;
        axios
          .get("/prod-catalog", {
            params: {
              f_lv: vm.f_lv,
              pt_c_ID: vm.pt_id,
              page: 1,
            },
          })
          .then(function (response) {
            vm.$store.commit("changeProdHomepage", response.data.listProducts);
            vm.$store.commit(
              "changeTotalNumbPage_P",
              response.data.total_pages
            );
            if (vm.$store.state.pagination.paging_type != 2) {
              vm.$store.commit("changePagingType_P", 2); // 2: Phân trang cho các sản phẩm theo danh mục hoặc loại sản phẩm
            }
            vm.$store.commit("changeProdCatalog", { lv_pt_c: vm.f_lv, pt_c_ID: vm.pt_id });
          })
          .catch(function (error) {
            console.log("Lỗi chíp!");
          });
      }
    },
  },
};
</script>
