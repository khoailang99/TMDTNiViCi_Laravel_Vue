<template>
  <div class="css-0bc721">
    <div class="paging-area">
      <ul class="pa__list-page-numbers">
        <li class="left-arow">
          <button type="button" class="lf__prev-page btn btn-link" @click="pageChangePagination(pageP - 1)">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#3F51B5" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
              <polyline points="15 6 9 12 15 18" />
            </svg>
          </button>
        </li>

        <li v-for="(page, index) of arrPagesPagination" :key="index">
          <button type="button" class="btn" :class="[{active: page == pageP}]" @click="pageChangePagination(isNaN(page) ? 0 : page)"> {{ page }} </button>
        </li>

        <li class="right-arow">
          <button type="button" class="rr__next-page btn btn-link" @click="pageChangePagination(pageP + 1)">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#3F51B5" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
    props: ['gross_product', 'total_pages', 'default_page_numbs'],
    data: function() {
      return {
        pageP: 1,
        numbPages: (this.total_pages > this.default_page_numbs) ? this.default_page_numbs : this.total_pages,
        arrPagesPagination: [],
        breakPSTS: 0,
        middleIndex: 0,
      }
    },
    mounted: function() {
      this.breakPSTS = Math.ceil(this.numbPages / 2) - 2;
      this.middleIndex = Math.ceil(this.numbPages / 2);
      this.initArrPagesPagination();
    },
    methods: {
      pageChangePagination: function(pagingBtnIsClicked) {
        if(pagingBtnIsClicked < 1 || pagingBtnIsClicked > this.total_pages) { return; }
        this.pageP = pagingBtnIsClicked;
        this.$emit('page_change_pagination', pagingBtnIsClicked);
        if(this.numbPages >= this.default_page_numbs) {
          this.handlePagination(this.pageP);
        }
      },
      initArrPagesPagination: function() {
        let orderPaginBtn;
        for(let i = 1; i <= this.numbPages; i++) {
          orderPaginBtn = (i == this.numbPages) ? this.total_pages : ((i == this.numbPages - 1 && this.total_pages > this.numbPages) ? "..." : i);
          this.arrPagesPagination.push(orderPaginBtn);
        }
      },
      handlePagination: function(page) {
        let txtPagingBtn = 0;
        let lastPages = this.total_pages + 3 - this.numbPages;
        this.arrPagesPagination.forEach(function(elem, index){
          if ((page - 1) <= this.breakPSTS) {
            txtPagingBtn = (++index == this.numbPages - 1) ? "..." : ((index == this.numbPages) ? this.total_pages : index);            
          } else if ((this.total_pages - page) <= this.breakPSTS) {
            txtPagingBtn = (++index == 2) ? "..." : ((index == 1) ? 1 : lastPages++);          
          } else {
            txtPagingBtn = (++index == 1 || index == this.numbPages) ? ((index == 1) ? 1 : this.total_pages) : ((Math.abs(this.middleIndex - index) > this.breakPSTS - 1) ? "..." : page - (this.middleIndex - index));            
          }
          this.arrPagesPagination[index-1] = txtPagingBtn;
        }.bind(this));
      }
    },
  }
</script>
