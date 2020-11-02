class CommonClient {
  constructor(distTBHeaderBottom) {
    this.heightHBWhenScrolled = 75; // HB : header-bottom
    this.spaceScrollbarHBFixed = 10;
  }

  // Cập nhật trạng thái hiện thị của các phần tử con: logo, menu, các tiêu đề của đơn hàng... trong header-bottom
  updateDispChildElemsInHB(heightHB, css_d_title) {
    $('.css-2b3b80').css('height', heightHB);
    $('.css-7b8572 .title').css('display', css_d_title);
  }

  // Lắng nghe sự kiện scroll trên window để cập nhật header bottom 
  triggerScrollEvOnWindow() {
    let objCCl = this;
    let heightHB = document.querySelector('.css-2b3b80').offsetHeight;
    let lastScrollTop = 0;
    window.addEventListener('scroll', function(e){
      let top = window.pageYOffset;
      if (lastScrollTop > top && top < objCCl.spaceScrollbarHBFixed) {
        if($('.css-0fb746').html() != null) {
          $('.css-ba45e7').trigger('click');
        }
        objCCl.updateDispChildElemsInHB(heightHB, "block");
      } else if (lastScrollTop < top) {
        objCCl.updateDispChildElemsInHB(objCCl.heightHBWhenScrolled, "none");
      }
      lastScrollTop = top;
    });
  }
}

let objCommonClient = new CommonClient(document.querySelector('.css-82517a').offsetHeight);
objCommonClient.triggerScrollEvOnWindow();
