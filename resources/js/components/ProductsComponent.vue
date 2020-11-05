<template>
  <div class="hp__pl__container css-a46f11">
    <a v-for="prod of list_products" v-bind:key="prod.ID" href="" class="css-2c7762">
      <div class="hp__pl__product product-card css-2e8efa d-flex flex-column align-content-center justify-content-center">
        <div class="product-card__content">
          <div class="pl__prod-image css-506c78">
            <picture>
              <img v-bind:src="prod.Image" alt="Flowers" class="css-963f94">
            </picture>
          </div>
          <div class="product-card__info">
            <div class="pl__prod-name css-fde874">
              {{ prod.Name }}
            </div>
            <div class="css-b38591">
              Chỉ còn 1 sản phẩm
            </div>
            <div class="css-e678cc">
              <div class="css-46c3ed">
                <div class="css-3c7ce6">
                  <span class="css-690a6b">
                    8.123.456
                    <span class="css-9f611a">đ</span>
                  </span>
                  <div class="css-48812d">
                    <span class="css-c5818a">
                      1.234.567
                      <span class="css-9f611a">đ</span>
                    </span>
                    <span class="css-027579"> 9% </span>
                  </div>
                </div>
              </div>
              <div class="css-950c09">
                <div class="css-49039d">
                  <img src="/Data/images/Product/Icon/free-delivery.svg" alt="" style="width: 45px; height: 32px">
                </div>
              </div>
            </div>
            <div class="css-8280ac">
              <div class="css-41ab48"> QUÀ TẶNG </div>
              <div class="css-7bc7d3">
                <div class="css-83b632">
                  <img data-src="" src="https://lh3.googleusercontent.com/joith777IiUPvSztaoEOH0UgTyRQiBTuV3IclRHWF0Uj8Y7bep8CxSCU4iYqAmetPCbZJ-JJqODsdgc9nw" class="css-904f61" alt="Khung mâm nghiêng - Từ 19” - 42″ M43N">
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
    mounted: function(){
      console.log(this.list_products)
      console.log('Component Products Mounted.')
    },
    destroyed: function() {
      console.log("Đã hủy bỏ danh sách sản phẩm cũ!");
    }
  }
</script>
