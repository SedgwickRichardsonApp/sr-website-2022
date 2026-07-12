/* global Swiper, anime */

export default {
  init() {
    const viewsSection = $('.tpl-homepage-views');
    if( viewsSection.length ){
      const viewsSwiperContainer = viewsSection.find('.swiper-container').get(0);
      if (viewsSwiperContainer) {
        new Swiper(viewsSwiperContainer, {
          slidesPerView: 1.2,
          spaceBetween: 18.68,
          speed: 1000,
          resistance: false,
          resistanceRatio:0,
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
            nextEl: viewsSection.find('.swiper-button-next').get(0),
            prevEl: viewsSection.find('.swiper-button-prev').get(0),
          },
        });
      }
    }

    const clientsSection = $('.tpl-homepage-clients');
    const clientsSwiperContainer = clientsSection.find('.clients-swiper-container').get(0);
    if (clientsSwiperContainer) {
      new Swiper(clientsSwiperContainer, {
        speed: 1000,
        resistance: false,
        resistanceRatio:0,
        scrollbar: {
          el: '.swiper-scrollbar',
          draggable: true,
        },
        breakpoints: {

        },
      });
    }

    const testimonialsSection = $('.tpl-homepage-testimonials');
    const testimonialsSwiperContainer = testimonialsSection.find('.testimonials-swiper-container').get(0);
    if (testimonialsSwiperContainer) {
      new Swiper(testimonialsSwiperContainer, {
        speed: 1000,
        resistance: false,
        resistanceRatio:0,
        draggable: false,
        spaceBetween: 200,
        navigation: {
          nextEl: testimonialsSection.find('.swiper-nav-next').get(0),
          prevEl: testimonialsSection.find('.swiper-nav-prev').get(0),
        },
      });
    }
  },
  finalize() {
    const heroSection = $('.tpl-homepage-hero');
    const firstTimeout = $('.cky-consent-container').hasClass('cky-hide') ? 0 : 5000;
    const isVi = $('html').hasClass('vi');
    const isZh = $('html').hasClass('zh');
    const isEn = $('html').hasClass('en');

    if (heroSection.length) {
      const heroTitle = heroSection.find('.hero-title.desktop');
      const heroMobile = heroSection.find('.hero-title.mobile');
      // const heroSubheading = heroSection.find('.hero-subheading.desktop p');

      if (heroTitle.length) {
        let words = heroTitle.text().trim().split(' ');

        if(isZh){
          words = heroTitle.text().trim().split('');
        }

        heroTitle.text('');
        if(isVi) {
          heroMobile.text('');
        }
      
        setTimeout(()=> {
          for (let i = 0; i < words.length; i++) {
            if(isZh && i == 23){
              heroTitle.append('<br />');
            }

            if(isVi && i <= 5 ){
              heroTitle.append(` <span class="word font-500 cursor-hover">${words[i]}</span>`)
            } else if(isVi && i === 6){
              heroTitle.append('<br />');
              heroTitle.append(` <span class="word font-500 cursor-hover">${words[i]}</span>`);
            }else if(isVi && i === 10) {
              heroTitle.append('<br />');
              heroTitle.append(` <span class="word cursor-hover">${words[i]}</span>`);
            }else if(isVi && i > 6){
              heroTitle.append(` <span class="word cursor-hover">${words[i]}</span>`);
            }
            
            if(isVi && i <= 6 ){
              heroMobile.append(` <span class="word font-500 cursor-hover">${words[i]}</span>`)
            } else if(isVi && i > 6){
              heroMobile.append(` <span class="word cursor-hover">${words[i]}</span>`);
            }

            if(isEn && i <= 3){
              heroTitle.append(` <span class="word font-500 cursor-hover">${words[i]}</span>`);
            }else if(isEn && i > 3){
              heroTitle.append(` <span class="word cursor-hover">${words[i]}</span>`);
            }
            // heroTitle.append(` <span class="word cursor-hover">${words[i]}</span>`);
          }

          setTimeout(()=>{
            anime({
              loop: false,
              targets: '.tpl-homepage-hero .hero-title .word',
              translateY: [40, 0],
              opacity: [0, 1],
              easing: 'easeOutExpo',
              duration: 1400,
              delay: function(el, i){ return 66 * i },
            });
          }, 500);

          /*** If subheadings split by words, use below ***/
          // heroSubheading.each(function (){
          //   let subline = $(this).text().trim().split(' ');
          //   console.log(subline);
          //   $(this).text('');
          //   for (let s = 0; s < subline.length; s++) {
          //     $(this).append(` <span class="word">${subline[s]}</span>`);
          //   }
          // });

          setTimeout(()=>{
            anime({
              loop: false,
              targets: '.tpl-homepage-hero .hero-subheading p',
              translateY: [40, 0],
              opacity: [0, 1],
              easing: 'easeOutExpo',
              duration: 1500,
              delay: function(el, s){ return 500 * s },
            });
          }, 1500);
        }, firstTimeout);
      }
    }

    // $('.expertise-item').hover(() => {
    //   $('.tpl-homepage-expertise').addClass('invert-colors');
    // }, () => {
    //   $('.tpl-homepage-expertise').removeClass('invert-colors');
    // });

  },
};
