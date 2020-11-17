<template>
  <div class="hp__pl__container css-a46f11">
    <a v-for="prodD of list_products" v-bind:key="prodD.product.ID" v-bind:href="getUrl(prodD.product.ID)" class="css-2c7762">
      <div class="hp__pl__product product-card css-2e8efa d-flex flex-column align-content-center justify-content-center">
        <div class="product-card__content" style="height: 100%;">
          <div class="pl__prod-image css-506c78">
            <picture>
              <img v-bind:src="prodD.product.Image" alt="Flowers" class="css-963f94" style="height: 100%;">
            </picture>
          </div>
          <div class="product-card__info">
            <div class="pl__prod-name css-fde874">
              {{ prodD.product.Name }}
            </div>
            <div v-if="prodD.product.Quantity < showNumbProdsRemain" class="pc__info__numb-prod-remain css-b38591">
              Chỉ còn {{ prodD.product.Quantity }} sản phẩm
            </div>
            <div class="css-e678cc">
              <div class="css-46c3ed">
                <div class="css-3c7ce6">
                  <span class="price css-690a6b">
                    {{ moneyFormatVN(prodD.product.PromotionPrice == null ? prodD.product.Price: prodD.product.PromotionPrice) }}
                    <span class="css-9f611a">đ</span>
                  </span>
                  <div v-if="prodD.product.PromotionPrice != null" class="css-48812d">
                    <span class="promotion_price css-c5818a">
                      {{ moneyFormatVN(prodD.product.Price)}}
                      <span class="css-9f611a">đ</span>
                    </span>
                    <span class="promotion_percen css-027579"> {{Math.round((1 - prodD.product.PromotionPrice/prodD.product.Price)*100) + "%" }} </span>
                  </div>
                </div>
              </div>
              <div v-if="prodD.product.Status == 4 || prodD.product.Price > freeShip ? true : false" class="css-950c09">
                <div class="css-49039d free-ship">
                  <img src="/Data/images/Product/Icon/free-delivery.svg" alt="" style="width: 45px; height: 32px">
                </div>
              </div>
            </div>
            <div v-if="prodD.pmtDetail_PmtPackage.pmtDetail.length > 0" class="pc__info__gift css-8280ac">
              <div class="css-41ab48"> QUÀ TẶNG </div>
              <div class="css-7bc7d3">
                <div v-for= "(gift, index) in prodD.pmtDetail_PmtPackage.pmtDetail" :key="index" class="css-83b632">
                  <img data-src="" :src="gift.Image" class="css-904f61" :alt="gift.Name">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </a>
	</div>
</template>

<script>
  export default {
    props: ['list_products'],
    data: function() {
      return {
        showNumbProdsRemain: 15, // Những sản phẩm nào có số lượng tồn < 15 thì hiển thị thông báo
        freeShip: 500000, // Sản phẩm nào có giá bán > 500.000đ thì đc freesShip
      }
    },
    methods: {
      getUrl: function(prodID) {
        return "/prod-detail/" + prodID;
      },
      moneyFormatVN: function(strMoney) {
        let arrStr = parseInt(strMoney).toString().split("");
          let len = arrStr.length - 1;
          for (let i = len - 1; i >= 0; i--) {
            arrStr[i] = ((len - i) % 3 == 0) ? arrStr[i] + "." : arrStr[i];
          }
        return arrStr.join("");
      }
    }
  }
</script>
