<template>
  <div @mouseleave = 'changeHoverStateOnMI()'  class="active-menu-panel css-baa804">
    <div class="css-8d193e">
      <div class="css-249347">
        <!-- cấp hai -->
        <div v-for="s_t_pt in secondary_tertiary_pt" :key = "s_t_pt.fatherLv.ID" class="css-83bd92">
          <div class="css-ae6801">
            <a class="css-a8bec4">
              <span class="css-ebe02b"> {{ s_t_pt.fatherLv.Name }} </span>
              <span size="12" class="css-b6dcc8">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="100%" height="100%" viewBox="0 0 24 24" stroke-width="2.5" stroke="#1435c3" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <polyline points="9 6 15 12 9 18" />
                </svg>
              </span>
            </a>
          </div>

          <div class="css-f411ff">
            <!-- Cấp ba -->
            <div class="css-6ac2a3" v-for="pt_pc in s_t_pt.childLv" v-bind:key="pt_pc.ID">
              <span class="css-62f2d3"></span>
              <span class="css-1892a4"> {{ pt_pc.Name }} </span>
            </div>
          </div>
        </div>
      </div>

      <div class="css-a834e0">
        <div class="css-c1b633">
          <picture>
            <img class="lazyload css-86d845" alt="" data-src="https://lh3.googleusercontent.com/RNmpYzBF5IlwaKyb53jsrA8EddCDgIV2YCVjNBm2RrLoATS2RtvI3RVPtzPiW_hqlaqUpGPND55US4t7uN-t=w600-rw" src="https://lh3.googleusercontent.com/RNmpYzBF5IlwaKyb53jsrA8EddCDgIV2YCVjNBm2RrLoATS2RtvI3RVPtzPiW_hqlaqUpGPND55US4t7uN-t=w600-rw" loading="lazy" decoding="async">
          </picture>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['secondary_tertiary_pt'],
    methods: {
      changeHoverStateOnMI: function() {
        this.$emit('changeh-hover-state-menuitem')
      }
    },
    mounted() {
      console.log('Component mounted.')
    }
  }
</script>