/* global Swiper */
import cursor from './modules/cursor';

export default {
  init() {
    const contentSection = $('.tpl-expertise-content');
    if (contentSection.length) {
      const swiperContainer = contentSection.find('.related-works-wrapper .swiper-container').get(0);

      if (swiperContainer) {
        new Swiper(swiperContainer, {
          slidesPerView: 1.2,
          spaceBetween: 0,
          speed: 1000,
          resistance: false,
          resistanceRatio:0,
          breakpoints: {
            768: {
              slidesPerView: 1.5,
            },
          },
          navigation: {
            nextEl: contentSection.find('.related-works-wrapper .swiper-button-next').get(0),
            prevEl: contentSection.find('.related-works-wrapper .swiper-button-prev').get(0),
          },
        });
      }

      const viewsContainer = contentSection.find('.related-views-wrapper .swiper-container').get(0);

      if (viewsContainer) {
        new Swiper(viewsContainer, {
          slidesPerView: 1.2,
          spaceBetween: 0,
          speed: 1000,
          resistance: false,
          resistanceRatio:0,
          breakpoints: {
            768: {
              slidesPerView: 1.5,
            },
          },
          navigation: {
            nextEl: contentSection.find('.related-views-wrapper .swiper-button-next').get(0),
            prevEl: contentSection.find('.related-views-wrapper .swiper-button-prev').get(0),
          },
        });
      }
    }
  },
  finalize() {
    //Expertise page sticky menu draggable 
    const draggableMenu = document.querySelector('.navigation-wrapper.mobile-navigation');
    const csMenu = $('.navigation-wrapper.mobile-navigation');
    if(csMenu){
      let isDown = false;
      let startX;
      let scrollLeft;
  
      draggableMenu.addEventListener('mousedown', (e) => {
        isDown = true;
  
        startX = e.pageX - csMenu.offset().left;
        scrollLeft = csMenu.scrollLeft();
      });
      draggableMenu.addEventListener('mouseleave', () => {
        isDown = false;
      });
      draggableMenu.addEventListener('mouseup', () => {
        isDown = false;
      });
      draggableMenu.addEventListener('mousemove', (e) => {
        if(!isDown) { return; }
        e.preventDefault();
        const x = e.pageX - csMenu.offset().left;
        const walk = (x - startX) * 3; //scroll-fast
        csMenu.scrollLeft(scrollLeft - walk);
      });
    }

    if($('body').hasClass('template-expertise')){
      const contactLink = $('.tpl-expertise-content .content-wrapper .p-normal.contact-link');
      contactLink.find('a').addClass('cursor-link contact-modal-trigger');
      // const invertHero = $('.cursor-wrap.creating-value');
      // invertHero.addClass('cursor-link');
      cursor.finalize();
    }
  },
};
