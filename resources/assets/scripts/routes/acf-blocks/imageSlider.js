/* global Swiper */
import scrollRevealJs from '../modules/scrollReveal';

export default {
  init() {
    const imageSliderBlock = document.querySelectorAll('.image-slider-block .swiper-container');
    for(let i=0; i < imageSliderBlock.length; i++ ) {
      imageSliderBlock[i].classList.add('swiper-container-' + i);
      new Swiper('.swiper-container-' + i, {
        slidesPerView: 1.4545,
        spaceBetween: 0,
        speed: 1000,
        centeredSlides: true,
        resistance: false,
        resistanceRatio:0,
        loop: true,
        navigation: {
          nextEl: $(imageSliderBlock[i]).find('.swiper-button-next').get(0),
          prevEl: $(imageSliderBlock[i]).find('.swiper-button-prev').get(0),
        },
      });
    }
  },
  finalize() {
    scrollRevealJs.finalize();
  },
};
