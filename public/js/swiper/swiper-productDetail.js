class ProductImage {
    constructor(isRunImg, widthThumb, spaceBetweenThumb) {
        this.isRunImg = isRunImg;
        this.widthThumb = widthThumb;
        this.spaceBetweenThumb = spaceBetweenThumb;
        this.vSlidesPerView = Math.ceil(Math.ceil($(".gallery-top").width()) / (this.widthThumb + this.spaceBetweenThumb));
        this.galleryThumbs;
        this.galleryTop;
        console.log($(".gallery-top").width())
    }

    triggerEMouseenterOnThumb() {
        console.log("da dc trigger")
        let objProdImg = this;
        $('.gallery-thumbs .swiper-wrapper .swiper-slide').mouseenter(function(e) {
            if (!objProdImg.isRunImg || $(this).index() == objProdImg.vSlidesPerView - 1) { return; }
            objProdImg.galleryTop.slideTo($(this).index());
            console.log("index cua slide")
            console.log($(this).index())
        });
    }

    viewPhotoInModalForm() {
        $('.pad__dip__part-pictures').click(function() {
            if ($(".container-pp-mis__add-bgColor").html() == null) {
                this.galleryThumbs.params.slidesPerView = 'auto';
                this.galleryThumbs.allowTouchMove = true;
                $(this.galleryThumbs.slides[this.vSlidesPerView - 1]).removeClass('gt__ss__numb-slides-remain');
                this.runTgClassOnPartImage(false);
            }
        }.bind(this));
    }

    closeImgInModalForm() {
        $('.gt__cei__icon-times').click(function() {
            this.galleryThumbs.params.slidesPerView = this.vSlidesPerView;
            this.galleryThumbs.allowTouchMove = false;
            this.f_showNumbSlidesRemain();
            this.galleryThumbs.update();
            if (this.galleryThumbs.clickedIndex > this.vSlidesPerView - 1) {
                this.galleryTop.slideTo(this.vSlidesPerView - 1);
            }
            this.runTgClassOnPartImage(true);
        }.bind(this));
    }

    f_showNumbSlidesRemain() {
        let prodSlideNumb = this.galleryTop.slides.length;
        if (this.vSlidesPerView < prodSlideNumb) {
            $(this.galleryThumbs.slides[this.vSlidesPerView - 1]).addClass('gt__ss__numb-slides-remain').attr('data-numbSlidesRemain', `+${prodSlideNumb - this.vSlidesPerView}`);
        }
        console.log("")
        console.log("So slide con lại: " + prodSlideNumb)
        console.log("")
    }

    runTgClassOnPartImage(p_isRunImg) {
        $(".pad__dip__part-pictures").toggleClass("pad__dip_pp-max-height");
        $(".dip__container-pp-mis").toggleClass("container-pp-mis__add-bgColor");
        $(".pad__dip__part-pictures .gallery-top").toggleClass("pp__gt__enlarge-image");
        $(".pad__dip__part-pictures .gallery-top .swiper-zoom-container").each(function() {
            $(this).toggleClass("gt__swiper-slide__bImage");
        });
        $(".pad__dip__part-pictures .gallery-top .swiper-button-next").toggleClass("gt__ei__swiper-btn-next");
        $(".pad__dip__part-pictures .gallery-top .swiper-button-prev").toggleClass("gt__ei__swiper-btn-prev");
        $(".pad__dip__part-pictures .gallery-thumbs").toggleClass("pp__ei__gallery-thumbs");

        $(".gt__ei__swiper-btn-next").removeClass('swiper-button-disabled');
        $(".gt__ei__swiper-btn-prev").removeClass('swiper-button-disabled');

        this.isRunImg = p_isRunImg;
        this.galleryThumbs.update();
        this.galleryTop.update();
        this.galleryTop.navigation.update();
    }
}

let productImage = new ProductImage(true, 75, 10);
productImage.galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: productImage.spaceBetweenThumb,
    slidesPerView: productImage.vSlidesPerView,
    freeMode: true,
    allowTouchMove: false,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    slideToClickedSlide: true,
    /*navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    watchOverflow: true,*/
});
productImage.galleryTop = new Swiper('.gallery-top', {
    mousewheel: true,
    observer: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: productImage.galleryThumbs
    }
});
productImage.f_showNumbSlidesRemain();
productImage.triggerEMouseenterOnThumb();
productImage.viewPhotoInModalForm();
productImage.closeImgInModalForm();