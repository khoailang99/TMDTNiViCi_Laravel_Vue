<template>
  <div class="css-bc9d08">
    <div v-show="!noProducts" class="css-b7fa2c">
      <div class="css-f566aa">
        <a
          :href="getUrl(prodS.product.ID)"
          class="css-93b7d3"
          v-for="(prodS, index) in products_searched"
          :key="index"
        >
          <div class="css-f8a39b">
            <img :src="prodS.product.Image" alt="" />
          </div>
          <div class="css-cef33e">
            <div class="css-830b37">
              <div class="css-82a866">
                {{ prodS.product.Name }}
              </div>
            </div>
            <div class="css-3c7ce6">
              <span class="price css-690a6b">
                {{ moneyFormatVN(prodS.product.PromotionPrice) }}
                <span class="css-9f611a">đ</span>
              </span>
              <div class="css-48812d">
                <span class="promotion_price css-c5818a">
                  {{ moneyFormatVN(prodS.product.Price) }}
                  <span class="css-9f611a">đ</span>
                </span>
              </div>
            </div>
          </div>
          <div class="css-b89921">
            <div class="css-e37899">
              <div class="css-5f796a">QUÀ TẶNG</div>
              <div class="css-a59f33">
                <div class="css-83b632 css-21b9ec">
                  <img
                    data-src=""
                    src="/Data/images/Product/Balo/mainImg-balo1.png"
                    alt="Chuột máy tính Logitech B175 (Đen)"
                    class="css-904f61"
                  />
                </div>
                <div class="css-83b632 css-21b9ec">
                  <img
                    data-src=""
                    src="/Data/images/Product/Balo/Rivacase/mainImg-rivacase3.png"
                    alt="Túi đựng laptop 14''"
                    class="css-904f61"
                  />
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="css-2b99b8">
        <button class="css-6f07dc" @click="seeAllSearchedProds()">
          Xem tất cả
        </button>
      </div>
    </div>
    <div v-show="noProducts" class="css-26944c">
      <div>
        <div class="css-418419 active">
          <div class="css-c2ed66" style="width: 100px; height: 100px!important;">
            <img src="/Data/images/Product/no-products-found.png" alt="" />
          </div>
          <div class="css-9cba25">Không tìm thấy sản phẩm</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["products_searched"],
  data: function() {
    return {
      noProducts: false,
    }
  },
  mounted: function () {
    console.log("");
    console.log("ProdSearchIndicatorComponent mounted.");
    console.log("");
  },
  watch: {
    products_searched: function() {
      this.noProducts = this.products_searched == null || this.products_searched.length == 0 ? true : false;
    }
  },
  methods: {
    moneyFormatVN: function (strMoney) {
      let arrStr = parseInt(strMoney).toString().split("");
      let len = arrStr.length - 1;
      for (let i = len - 1; i >= 0; i--) {
        arrStr[i] = (len - i) % 3 == 0 ? arrStr[i] + "." : arrStr[i];
      }
      return arrStr.join("");
    },
    seeAllSearchedProds: function () {
      this.$emit("see_all_searched_prods");
    },
    getUrl: function(prodID) {
      return "/prod-detail/" + prodID;
    },
  },
};
</script>
