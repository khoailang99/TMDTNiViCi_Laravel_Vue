<template>
  <div class="css-p91eq5">
    <div class="css-6l7rf5">
      <div class="css-1hwtax5">
        <div class="css-i22ydz">
          <div class="css-0">
            <div class="css-4cffwv">
              <div class="css-1i1dodm">
                <div class="css-709yn1">
                  <!-- Hình ảnh chính và các hình ảnh liên quan -->
                  <div id="modal-body__prod-details-area">
                    <div class="pda__detail-info-prod">
                      <div class="dip__container-pp-mis">
                        <div
                          class="pp__gt__close-enlarge-image"
                          style="display: none"
                        >
                          <p class="gt__cei__icon-times">
                            <i class="fas fa-times"></i>
                          </p>
                        </div>
                        <div class="pad__dip__part-pictures">
                          <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                              <div
                                class="swiper-slide"
                                v-for="(imgP, index) in mainImg_relatedImg"
                                :key="index"
                              >
                                <div class="swiper-zoom-container">
                                  <img :src="imgP" alt="" />
                                </div>
                              </div>
                            </div>
                            <!-- Add Arrows -->
                            <div
                              class="swiper-button-next swiper-button-white"
                            ></div>
                            <div
                              class="swiper-button-prev swiper-button-white"
                            ></div>
                          </div>

                          <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                              <div
                                class="swiper-slide"
                                v-for="(imgP, index) in mainImg_relatedImg"
                                :key="index"
                              >
                                <img :src="imgP" alt="" />
                              </div>
                            </div>
                            <!-- <div class="swiper-button-next swiper-button-white"></div>
						<div class="swiper-button-prev swiper-button-white"></div> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="css-3tu0eq"></div>
                <div>
                  <div class="css-r9cu07">
                    <div class="card-body css-0">
                      <div
                        class="css-111s35w"
                        v-html="product_detail.product.Description"
                      >
                        <!-- Miêu tả sản phẩm -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="css-6b3ezu">
                <div class="css-1jpdzyd">
                  <!-- Tên sản phẩm -->
                  {{ product_detail.product.Name }}
                </div>
                <div class="css-5nimvs">
                  Thương hiệu
                  <a href="/search?brands=acer" class="css-c2cixi">ACER</a>
                </div>
                <div class="css-1b2x0kn"></div>
                <div v-if="product_detail.product.Quantity < showNumbProdsRemain" class="css-1wn7dgo">
                  Chỉ còn {{ product_detail.product.Quantity }}
                </div>
                <div class="css-11n8erc">
                  <div class="css-1etdbj7">
                    <span class="css-3725in">
                      {{
                        moneyFormatVN(
                          product_detail.product.PromotionPrice != null
                            ? product_detail.product.PromotionPrice
                            : product_detail.product.Price
                        )
                      }}
                      <span class="css-1ul6wk9">đ</span>
                    </span>
                  </div>
                </div>
                <div>
                  <div v-for="(promt,index) in product_detail.pmtDetail_PmtPackage.pmtDetail" :key="index" class="css-vuhw84">
                    <div v-if="promt.Image != null">
                      <div height="32" width="32" class="css-195zgzt">
                        <img
                          class="lazyload css-jdz5ak"
                          alt=""
                          data-src=""
                          :src="promt.Image"
                          loading="lazy"
                          decoding="async"
                        />
                      </div>
                    </div>
                    <span v-if="promt.Image != null" class="css-barcwm"> {{ promt.Name }}</span>
                  </div>
                </div>
                <div class="css-3tu0eq"></div>
                <div v-if="product_detail.product.PromotionPrice != null">
                  <div class="css-1sfy14o">Giá khuyến mãi:</div>
                  <div class="css-kr4u7a">
                    <div class="css-10y5j5j"></div>
                    <div class="css-1sulisw">
                      <div class="css-syv2kv">
                        <div class="css-64noit">
                          <strong class="css-sr31nm">Giá:</strong>
                          <span class="css-1xghdzx">
                            {{
                              moneyFormatVN(
                                product_detail.product.PromotionPrice
                              )
                            }}
                          </span>
                        </div>
                        <div class="css-iq3qhu">
                          Đã giảm thêm
                          <span class="css-1mye30f">
                            {{
                              moneyFormatVN(
                                product_detail.product.Price -
                                  product_detail.product.PromotionPrice
                              )
                            }}
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="css-18wywdr"></div>
                    <span class="css-th3zma">✓</span>
                  </div>
                </div>
                <div class="css-ji66tv">
                  <!-- <a
                    href="https://m.me/phongvuvietnam"
                    target="_blank"
                    class="css-rj9ja1"
                    ><strong> LIÊN HỆ</strong></a
                  > -->
                  <div class="css-ji66tv">
                    <button class="css-33xjxx">
                      <strong>MUA NGAY</strong>
                    </button>
                    <button class="css-bkwyxf">
                      <strong>THÊM VÀO GIỎ HÀNG</strong>
                    </button>
                  </div>
                </div>
                <div class="css-3tu0eq"></div>
                <div class="css-1rggx5t">
                  <div class="css-mz7xyg">Khuyến mãi liên quan</div>
                  <ul>
                    <li v-for="(promt,index) in product_detail.pmtDetail_PmtPackage.pmtDetail" :key="index">
                      <p v-if="promt.Image == null">
                        {{ promt.Name }}
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="css-l5vln9">
        <div class="css-cc7zbm">
          <div class="card-body css-0">
            <div class="css-5ri8n0">
              <span size="24" color="#53c305" class="css-swn1i6"></span>
              <div class="css-1plrovb">Sản phẩm được miễn phí giao hàng</div>
            </div>
            <div class="css-3tu0eq"></div>
            <div class="css-tq900l">
              <div class="css-nlnywq">Chính sách bán hàng</div>
              <div class="css-762ld9">
                <span size="24" class="css-1sk9y4t"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-circle-check"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <circle cx="12" cy="12" r="9" />
                      <path d="M9 12l2 2l4 -4" />
                    </svg>
                  </span>
                  Cam kết hàng chính hãng 100%
                </div>
              </div>
              <div class="css-762ld9">
                <span size="24" class="css-1maatv7"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-truck-delivery"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <circle cx="7" cy="17" r="2" />
                      <circle cx="17" cy="17" r="2" />
                      <path
                        d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5"
                      />
                      <line x1="3" y1="9" x2="7" y2="9" />
                    </svg>
                  </span>
                  Miễn phí giao hàng từ 500K
                </div>
              </div>
              <div class="css-762ld9">
                <span size="24" class="css-zcwrt7"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-replace"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <rect x="3" y="3" width="6" height="6" rx="1" />
                      <rect x="15" y="15" width="6" height="6" rx="1" />
                      <path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" />
                      <path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" />
                    </svg>
                  </span>
                  Đổi trả miễn phí trong 10 ngày
                </div>
              </div>
            </div>
            <div class="css-1b0ylgr">
              <div class="css-nlnywq">Dịch vụ khác</div>
              <div class="css-762ld9">
                <span size="24" class="css-11g1ek"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-settings"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path
                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
                      />
                      <circle cx="12" cy="12" r="3" />
                    </svg>
                  </span>
                  Sửa chữa đồng giá 150.000đ.
                </div>
              </div>
              <div class="css-762ld9">
                <span size="24" class="css-1f6le2r"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-device-laptop"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <line x1="3" y1="19" x2="21" y2="19" />
                      <rect x="5" y="6" width="14" height="10" rx="1" />
                    </svg>
                  </span>
                  Vệ sinh máy tính, laptop.
                </div>
              </div>
              <div class="css-762ld9">
                <span size="24" class="css-1usmsyf"></span>
                <div class="css-ssxjzj">
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="icon icon-tabler icon-tabler-shield-check"
                      width="25"
                      height="25"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="#3F51B5"
                      fill="none"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M9 12l2 2l4 -4" />
                      <path
                        d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"
                      />
                    </svg>
                  </span>
                  Bảo hành tại nhà.
                </div>
              </div>
            </div>
            <a
              href="https://phongvu.vn/landing/dich-vu-sua-chua-va-bao-tri-phong-vu.html"
              target="_blank"
              class="css-k4cc6o"
              >Xem chi tiết</a
            >
          </div>
        </div>
      </div>
    </div>

    <!-- San pham tuong tu -->
    <!-- <div class="prod-detail__similar-products">
      <div class="css-efadb6">
        <div class="css-9ad9ed">
          <p class="css-cdb9a5">Sản phẩm tương tự</p>
        </div>
        <div class="css-00c4d0">
          <a href="" class="css-73cdde">
            Xem tất cả
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-right"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="#ae8585"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="9 6 15 12 9 18" />
            </svg>
          </a>
        </div>
      </div>
      <div class="css-5d0d0b">
        <div class="css-483354">
          <a href="/prod-detail/56" class="css-2c7762">
            <div
              class="hp__pl__product product-card css-2e8efa d-flex flex-column align-content-center justify-content-center"
            >
              <div class="product-card__content" style="height: 100%">
                <div class="pl__prod-image css-506c78">
                  <picture
                    ><img
                      src="/Data/images/Product/Laptop/Apple/main-apple1.png"
                      alt="Flowers"
                      class="css-963f94"
                      style="height: 100%"
                  /></picture>
                </div>
                <div class="product-card__info">
                  <div class="pl__prod-name css-fde874">
                    Laptop APPLE MacBook Air 2020 MWTL2SA/A MWTL2SA/A (13.3"
                    Intel Core i3/8GB/256GB SSD/macOS/1.3kg)
                  </div>
                  <div class="pc__info__numb-prod-remain css-b38591">
                    Chỉ còn 12 sản phẩm
                  </div>
                  <div class="css-e678cc">
                    <div class="css-46c3ed">
                      <div class="css-3c7ce6">
                        <span class="price css-690a6b">
                          27.490.000
                          <span class="css-9f611a">đ</span></span
                        >
                        <div class="css-48812d">
                          <span class="promotion_price css-c5818a">
                            27.580.000
                            <span class="css-9f611a">đ</span></span
                          >
                          <span class="promotion_percen css-027579"> 0% </span>
                        </div>
                      </div>
                    </div>
                    <div class="css-950c09">
                      <div class="css-49039d free-ship">
                        <img
                          src="/Data/images/Product/Icon/free-delivery.svg"
                          alt=""
                          style="width: 45px; height: 32px"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="pc__info__gift css-8280ac">
                    <div class="css-41ab48">QUÀ TẶNG</div>
                    <div class="css-7bc7d3">
                      <div class="css-83b632">
                        <img
                          data-src=""
                          src="/Data/images/Product/Balo/mainImg-balo1.png"
                          alt="Chuột máy tính Logitech B175 (Đen)"
                          class="css-904f61"
                        />
                      </div>
                      <div class="css-83b632">
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
              </div>
            </div>
          </a>
        </div>
      </div>
    </div> -->

    <!-- Chi tiết sản phẩm và thông số kĩ thuật -->
    <div class="product_details-specifications">
      <div class="css-197050">
        <div class="pds__product-details css-c38e84">
          <div class="pds__title css-88daca">
            <p class="css-cdb9a5">Mô tả sản phẩm</p>
          </div>

          <div
            class="pds__pd__content css-4c1e9d"
            :class="{ active: moreDetails }"
            v-html="product_detail.product.Content"
          ></div>
          <button class="content-expansion" @click="moreDetails = true" :class="{deactive: moreDetails}">
            <span> Xem thêm nội dung </span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-down"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="#4780c7"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </button>
          <button class="collapse-content" @click="moreDetails = false" :class="{active: moreDetails}">
            <span> Thu gọn nội dung </span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-up"
              width="16"
              height="16"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="#4780c7"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="6 15 12 9 18 15" />
            </svg>
          </button>
        </div>
        <!-- Phần thông số kĩ thuật -->
        <div class="pds__specifications css-357cbb">
          <div class="pds__title css-88daca">
            <p class="css-cdb9a5">Thông số kĩ thuật</p>
          </div>

          <div class="pds__s__content">
            <div
              class="css-eeaa32"
              v-for="(s, indexST) in specifications"
              :key="indexST"
            >
              <div class="name-specification css-01406a">{{ s.name }}</div>
              <div class="value-specification css-a288a0">{{ s.value }}</div>
            </div>
          </div>
          
        </div>
      </div>
    </div>

    <!-- Cùng thương hiệu -->
    <!-- <div class="prod-detail__same-brand">
      <div class="css-efadb6">
        <div class="css-9ad9ed">
          <p class="css-cdb9a5">Cùng thương hiệu</p>
        </div>
        <div class="css-00c4d0">
          <a href="" class="css-73cdde">
            Xem tất cả
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-chevron-right"
              width="20"
              height="20"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="#ae8585"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <polyline points="9 6 15 12 9 18" />
            </svg>
          </a>
        </div>
      </div>
      <div class="css-5d0d0b">
        <div class="css-483354">
          <a href="/prod-detail/56" class="css-2c7762">
            <div
              class="hp__pl__product product-card css-2e8efa d-flex flex-column align-content-center justify-content-center"
            >
              <div class="product-card__content" style="height: 100%">
                <div class="pl__prod-image css-506c78">
                  <picture
                    ><img
                      src="/Data/images/Product/Laptop/Apple/main-apple1.png"
                      alt="Flowers"
                      class="css-963f94"
                      style="height: 100%"
                  /></picture>
                </div>
                <div class="product-card__info">
                  <div class="pl__prod-name css-fde874">
                    Laptop APPLE MacBook Air 2020 MWTL2SA/A MWTL2SA/A (13.3"
                    Intel Core i3/8GB/256GB SSD/macOS/1.3kg)
                  </div>
                  <div class="pc__info__numb-prod-remain css-b38591">
                    Chỉ còn 12 sản phẩm
                  </div>
                  <div class="css-e678cc">
                    <div class="css-46c3ed">
                      <div class="css-3c7ce6">
                        <span class="price css-690a6b">
                          27.490.000
                          <span class="css-9f611a">đ</span></span
                        >
                        <div class="css-48812d">
                          <span class="promotion_price css-c5818a">
                            27.580.000
                            <span class="css-9f611a">đ</span></span
                          >
                          <span class="promotion_percen css-027579"> 0% </span>
                        </div>
                      </div>
                    </div>
                    <div class="css-950c09">
                      <div class="css-49039d free-ship">
                        <img
                          src="/Data/images/Product/Icon/free-delivery.svg"
                          alt=""
                          style="width: 45px; height: 32px"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="pc__info__gift css-8280ac">
                    <div class="css-41ab48">QUÀ TẶNG</div>
                    <div class="css-7bc7d3">
                      <div class="css-83b632">
                        <img
                          data-src=""
                          src="/Data/images/Product/Balo/mainImg-balo1.png"
                          alt="Chuột máy tính Logitech B175 (Đen)"
                          class="css-904f61"
                        />
                      </div>
                      <div class="css-83b632">
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
              </div>
            </div>
          </a>
        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
export default {
  props: ["product_detail"],
  data: function () {
    return {
      mainImg_relatedImg: null,
      specifications: [],
      moreDetails: false,
      moreSpecifications: false,
      showNumbProdsRemain: 15, // Những sản phẩm nào có số lượng tồn < 15 thì hiển thị thông báo
      freeShip: 500000, // Sản phẩm nào có giá bán > 500.000đ thì đc freesShip
    };
  },
  beforeMount: function () {
    this.mainImg_relatedImg = this.getMainImgRelatedImg(
      this.product_detail.product.Image,
      this.product_detail.product.MoreImages
    );
    this.specificationsDF(this.product_detail.PCS_PS);
    console.log("");
    console.log("Bảng thông số sau khi chuẩn hóa");
    console.log(this.specifications);
    console.log("");
  },
  mounted: function () {
    console.log("");
    console.log("ProductDetailComponent mounted.");
    console.log("");
    if($('.css-4c1e9d p').height() > 200) {
      $('.content-expansion').css('display','block');
    }else {
      $('.content-expansion').css('display','none');
    }
  },
  watch: {},
  methods: {
    moneyFormatVN: function (strMoney) {
      let arrStr = parseInt(strMoney).toString().split("");
      let len = arrStr.length - 1;
      for (let i = len - 1; i >= 0; i--) {
        arrStr[i] = (len - i) % 3 == 0 ? arrStr[i] + "." : arrStr[i];
      }
      return arrStr.join("");
    },
    getMainImgRelatedImg: function (mainImg, relatedImg) {
      let pathImg = mainImg.substr(
        0,
        mainImg.length - mainImg.split("/").pop().length
      );
      return [
        mainImg,
        ...relatedImg.split(",").map(function (img) {
          return pathImg + img;
        }),
      ];
    },
    specificationsDF: function (p_specifications) {
      // specification display format
      let sTypes = [
        "Thông tin tổng quan",
        "Thông tin chung",
        "Cấu hình chi tiết",
        "Thông tin khác",
      ];
      let typeID = 0;
      p_specifications.forEach(
        function (value) {
          if (value.TypeSpecifications != typeID) {
            this.specifications.push({
              name: sTypes[value.TypeSpecifications],
              value: "",
            });
            typeID = value.TypeSpecifications;
          }
          if (value.ParentID == 0 && value.Value != "" || value.ParentID == 0 && value.Value != null) {
            this.specifications.push({ name: value.Name, value: value.Value });
          }
        }.bind(this)
      );
      return sTypes;
    },
  },
};
</script>
