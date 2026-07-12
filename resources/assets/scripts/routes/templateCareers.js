/* global Typed, Swiper */

export default {
  init() {
    const heroSection = $('.tpl-contact-hero');

    if( heroSection.length ) {
      const helloWordsWrapper = heroSection.find('.hello-words-wrapper');
      const dataWords = helloWordsWrapper.data('words').split('||');

      new Typed('.hello-word-title > span', {
        strings: dataWords,
        typeSpeed: 100,
        backSpeed: 40,
        loop: true,
      });

      const heroSwiperContainer = heroSection.find('.swiper-container').get(0);

      if (heroSwiperContainer) {
        new Swiper(heroSwiperContainer, {
          autoplay: {
            delay: 6000,
            disableOnInteraction: false,
          },
          speed: 600,
          slidesPerView: 1,
          loop: true,
          effect: 'fade',
          resistance: false,
          resistanceRatio:0,
          fadeEffect: {
            crossFade: true,
          },
        });
      }
    }

    const officesSection = $('.tpl-contact-offices');

    if( officesSection.length ){
      const officesSwiperContainer = officesSection.find('.swiper-container').get(0);

      if (officesSwiperContainer) {
        new Swiper(officesSwiperContainer, {
          // spaceBetween: 15,
          slidesPerView: 1.18,
          resistance: false,
          resistanceRatio:0,
          spaceBetween: 18.68,
          scrollbar: {
            el: '.swiper-scrollbar',
            draggable: true,
          },
          pagination: {
            el: '.swiper-pagination',
            type: 'progressbar',
          },
          breakpoints: {
            768: {
              spaceBetween: 38.5,
              slidesPerView: 3,
            },
          },
          navigation: {
            nextEl: officesSection.find('.swiper-button-next').get(0),
            prevEl: officesSection.find('.swiper-button-prev').get(0),
          },
        });
      }
    }
  },
  finalize() {},
};
