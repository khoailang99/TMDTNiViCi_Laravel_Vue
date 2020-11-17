<template>
  <div class="css-0bc721">
    <div class="paging-area">
      <ul class="pa__list-page-numbers">
        <li class="left-arow">
          <button
            type="button"
            class="lf__prev-page btn btn-link"
            @click="pageChangePagination(pageP - 1)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-left"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              stroke-width="3"
              stroke="#3F51B5"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="15 6 9 12 15 18" />
            </svg>
          </button>
        </li>

        <li v-for="(page, index) of arrPagesPagination" :key="index">
          <button
            type="button"
            class="btn"
            :class="[{ active: page == pageP }]"
            @click="pageChangePagination(isNaN(page) ? 0 : page)"
          >
            {{ page }}
          </button>
        </li>

        <li class="right-arow">
          <button
            type="button"
            class="rr__next-page btn btn-link"
            @click="pageChangePagination(pageP + 1)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-right"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              stroke-width="3"
              stroke="#3F51B5"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="9 6 15 12 9 18" />
            </svg>
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  props: ["gross_product", "total_pages", "default_page_numbs"],
  data: function () {
    return {
      pageP: 1,
      totalPages: this.total_pages,
      numbPages: 0,
      defaultPageNumbs: this.default_page_numbs,
      arrPagesPagination: [],
      breakPSTS: 0,
      middleIndex: 0,
    };
  },
  created: function () {
    this.$store.commit("changeTotalNumbPage_P", this.totalPages);
    console.log(
      "Trước khi mouted pagingCompoent thì total_pages + default_page: " +
        this.$store.state.pagination.total_pages +
        " - " +
        this.$store.state.pagination.default_page_numbs
    );
  },
  mounted: function () {
    this.initArrPagesPagination();
  },
  methods: {
    getProducts: function () {
      let vm = this;
      let url_params = this.getUrlParams();

      axios
        .get(url_params.url, {
          params: url_params.value,
        })
        .then(function (response) {
          vm.$store.commit("changeProdHomepage", response.data.listProducts);
          console.log(
            "Lấy sản phẩm theo phân trang ở PagingComponent đã làm việc!"
          );
          console.log(response.data.listProducts);
          console.log(vm.pageP);
        })
        .catch(function (error) {
          console.log("Lỗi phân trang!");
        });
    },
    pageChangePagination: function (pagingBtnIsClicked) {
      if (pagingBtnIsClicked < 1 || pagingBtnIsClicked > this.totalPages) {
        return;
      }
      this.pageP = pagingBtnIsClicked;
      this.getProducts();
      if (this.numbPages >= this.default_page_numbs) {
        this.handlePagination(this.pageP);
      }
    },
    initArrPagesPagination: function () {
      this.totalPages = this.$store.state.pagination.total_pages;
      this.defaultPageNumbs = this.$store.state.pagination.default_page_numbs;
      this.numbPages =
        this.totalPages> this.defaultPageNumbs ? this.defaultPageNumbs : this.totalPages;
      this.breakPSTS = Math.ceil(this.numbPages / 2) - 2;
      this.middleIndex = Math.ceil(this.numbPages / 2);
      this.pageP = 1;
      let orderPaginBtn;

      if (this.arrPagesPagination.length > 0) {
        this.arrPagesPagination.splice(0);
      }
      for (let i = 1; i <= this.numbPages; i++) {
        orderPaginBtn =
          i == this.numbPages
            ? this.totalPages
            : (i == this.numbPages - 1 && this.totalPages > this.numbPages
            ? "..."
            : i);
        this.arrPagesPagination.push(orderPaginBtn);
      }
      console.log("");
      console.log("paging!");
      console.log(this.arrPagesPagination);
      console.log("");
    },
    handlePagination: function (page) {
      let txtPagingBtn = 0;
      let lastPages = this.totalPages + 3 - this.numbPages;
      this.arrPagesPagination.forEach(
        function (elem, index) {
          if (page - 1 <= this.breakPSTS) {
            txtPagingBtn =
              ++index == this.numbPages - 1
                ? "..."
                : index == this.numbPages
                ? this.totalPages
                : index;
          } else if (this.totalPages - page <= this.breakPSTS) {
            txtPagingBtn = ++index == 2 ? "..." : index == 1 ? 1 : lastPages++;
          } else {
            txtPagingBtn =
              ++index == 1 || index == this.numbPages
                ? index == 1
                  ? 1
                  : this.total_pages
                : Math.abs(this.middleIndex - index) > this.breakPSTS - 1
                ? "..."
                : page - (this.middleIndex - index);
          }
          this.arrPagesPagination[index - 1] = txtPagingBtn;
        }.bind(this)
      );
    },
    getUrlParams: function () {
      let arr_urls_params = [
        {
          pagingType: 1, // Phân trang của các sản phẩm hiển thị ở trang home
          url: "/products",
          value: {
            page: this.pageP,
          },
        },
        {
          pagingType: 2, // Phân trang của các sản phẩm của danh mục hoặc loại sản phẩm
          url: "/prod-catalog",
          value: {
            f_lv: this.$store.state.prodCatalog.lv_pt_c,
            pt_c_ID: this.$store.state.prodCatalog.pt_c_ID,
            page: this.pageP,
          },
        },
        {
          pagingType: 3, // Phân trang của các sản phẩm đã đc lọc
          url: "/prod-filters",
          value: { ...this.$store.state.filtersProdType, page: this.pageP },
        },
        {
          pagingType: 4, // Phân trang của các sản phẩm thỏa mãn giá trị tìm kiếm
          url: "/search-product",
          value: {
            show_all: 1,
            info_searched: this.$store.state.searchProduct.infoSearched,
            page: this.pageP 
          },
        },
      ];

      let params = arr_urls_params[this.$store.state.pagination.paging_type - 1];
      console.log("Tham số thỏa mãn: ");
      console.log(params);
      return params;
    },
  },
  watch: {
    "$store.state.pagination.default_page_numbs"() {
      this.initArrPagesPagination();
    },
    "$store.state.prodCatalog.pt_c_ID"() {
      this.initArrPagesPagination();
    },
    "$store.state.pagination.total_pages"() {
      this.initArrPagesPagination();
    },
    
  },
};
</script>
