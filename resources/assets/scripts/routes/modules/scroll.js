import helpers from '../../util/helpers';

export default {
  init() {

  },
  finalize() {
    // set opacity 1 if ScrollReveal failed
    let loadedSequence = false;
    const revealComponent = $('.s-reveal');
    if(revealComponent.length){
      revealComponent.each(function () {
        showRevealComponent($(this));
      });
      helpers.onWindowEvents(() => {
        revealComponent.each(function () {
          showRevealComponent($(this));
        });
      }, 0, 1, 1, 1);
    }

    function showRevealComponent(_this){
      if(!$(_this).hasClass('.s-revealed')){
        const elemTop = _this.position().top;
        const elemBottom = elemTop + _this.outerHeight();
        const viewTop = $(window).scrollTop();
        const viewBottom = viewTop+$(window).height();
        if( ( (viewTop < elemTop && viewBottom > elemTop ) || (viewTop < elemBottom && viewBottom > elemBottom) ) && $(_this).css('opacity') == '0' ){
          setTimeout(() => {
            $(_this).css('opacity', '1');
            $(_this).css('transform', 'matrix(1, 0, 0, 1, 0, 0)');
          }, 800);
        }
      }
    }

    const sequencedComponent = $('.s-sequenced');
    if(sequencedComponent.length && !$('body').hasClass('template-about')){
      sequencedComponent.each(function () {
        showSequencedComponent($(this));
      });
      helpers.onWindowEvents(() => {
        if(!loadedSequence){
          checkLoadedSequence();
          sequencedComponent.each(function () {
            showSequencedComponent($(this));
          });
        }
      }, 0, 1, 1, 1);
    }

    function checkLoadedSequence() {
      const sequencedComponent = $('.s-sequenced');
      if(sequencedComponent.length){
        sequencedComponent.each(function () {
          if($(this).css('opacity') == '1' && $(this).css('transform') == 'matrix(1, 0, 0, 1, 0, 0)'){
            loadedSequence = true;
          }else{
            loadedSequence = false;
          }
        });
      }
    }
    
    function showSequencedComponent(_this){
      if(!$(_this).hasClass('.s-revealed')){
        const elemTop = _this.position().top;
        const elemBottom = elemTop + _this.outerHeight();
        const viewTop = $(window).scrollTop();
        const viewBottom = viewTop+$(window).height();
        if( ( (viewTop < elemTop && viewBottom > elemTop ) || (viewTop < elemBottom && viewBottom > elemBottom) ) && $(_this).css('opacity') == '0' ){
          setTimeout(() => {
            $(_this).css('opacity', '1');
            $(_this).css('transform', 'matrix(1, 0, 0, 1, 0, 0)');
          }, 800);
        }
      }
    }

    // Change header color
    const header = document.getElementsByClassName('header')[0];
    const headerTransparent = document.getElementsByClassName('js-header-transparent');
    const headerBlack = document.getElementsByClassName('js-header-black');
    const firstSection = $('body .wrap .content-wrap section')[0];

    if($(firstSection).hasClass('js-header-white')){
      header.classList.remove('header-black');
      header.classList.add('header-white');
    }else if($(firstSection).hasClass('js-header-black')){
      header.classList.add('header-black');
      header.classList.remove('header-white');
    } else if($(firstSection).hasClass('js-header-transparent')){
      header.classList.remove('header-black');
      header.classList.remove('header-white');
    }

    if (headerTransparent.length || headerBlack.length) {
      helpers.onWindowEvents(() => {
        const isElementsInView = function (elements) {
          if ( elements.length ) {
            for (let i = 0; i < elements.length; i++) {
              const start = elements[i].offsetTop - header.offsetHeight / 2;
              const end = elements[i].offsetTop + elements[i].clientHeight - header.offsetHeight / 2;
              if (window.scrollY >= start && window.scrollY <= end) {
                return true;
              }
            }
          }

          return false;
        }

        const isTransparentInView = isElementsInView(headerTransparent);
        const isBlackInView = isElementsInView(headerBlack);
        if (isTransparentInView) {
          header.classList.remove('header-white');
          header.classList.remove('header-black');
        } else if (isBlackInView) {
          header.classList.remove('header-white');
          header.classList.add('header-black');
        } else {
          header.classList.remove('header-black');
          header.classList.add('header-white');
        }
      }, 0, 1, 1, 1);
    }

    // Change section bg static color
    // const sectionBgColors = $('section');
    // if (sectionBgColors.length) {
    //   sectionBgColors.each(function () {
    //     if($('body').hasClass('template-homepage')){
          
    //       helpers.onWindowEvents(() => {
    //         const _this = $(this);
    //         const bgClass = _this.data('background-color') == '#0a0a10' ? 'js-bg-black' : undefined;
    //         const elementTop = _this.position().top - ($(window).height() * 0.65);
    //         const elementBottom = _this.position().top + _this.outerHeight();
    //         const viewportTop =  $(window).scrollTop() ;
    //         if( elementTop <= viewportTop && elementBottom > viewportTop){
    //           if(bgClass){
    //             $('.content-wrap').addClass('js-bg-black');
    //             $('.content-wrap').addClass('js-header-black');
    //           }else{
    //             $('.content-wrap').removeClass('js-bg-black');
    //             $('.content-wrap').removeClass('js-header-black');
    //           }
    //         }
    //       }, 0, 1, 1, 1);
    //     }
        
    //   });
    // }

    // Change Home Contact section bg color
    // const blueBgSection = $('.template-homepage section.tpl-homepage-contact');
    // const viewsSection = $('.template-homepage section.tpl-homepage-views');//$('body').height() + 500;

    // if (blueBgSection.length) {
    //   helpers.onWindowEvents(() => {
    //     const elementTop = blueBgSection.position().top - ($(window).height() * 0.7);
    //     const nextSectionTop = viewsSection.position().top - ($(window).height() * 0.5);
    //     const viewportTop = $(window).scrollTop();
    //     if(!$('body').hasClass('modal-open')){
    //       // if( elementTop <= viewportTop && viewsSection > viewportTop){
    //       if( elementTop <= viewportTop && nextSectionTop >= viewportTop){
    //         $('body').addClass('js-body-bg-blue');
    //         $('body').addClass('js-bg-blue');
    //         $('.content-wrap').addClass('js-bg-blue');
    //         $('.content-wrap').addClass('js-header-blue');

    //         $('body').removeClass('js-body-bg-black');
    //         $('body').removeClass('js-bg-black');
    //         $('.content-wrap').removeClass('js-bg-black');
    //         $('.content-wrap').removeClass('js-header-black');
    //       }else {
    //         $('body').removeClass('js-body-bg-blue');
    //         $('body').removeClass('js-bg-blue');
    //         $('.content-wrap').removeClass('js-bg-blue');
    //         $('.content-wrap').removeClass('js-header-blue');

    //       }
    //     }
    //   }, 0, 1, 1, 1);
    // }

    // Change Home testimonials section bg color to BLACK
    const blackBgSection = $('.template-homepage section.tpl-homepage-testimonials');
    const clientSection = $('.template-homepage section.tpl-homepage-clients');

    if (blackBgSection.length) {
      helpers.onWindowEvents(() => {
        const elementTop = blackBgSection.position().top - ($(window).height() * 0.7);
        const nextSectionTop = clientSection.position().top - ($(window).height());
        const viewportTop = $(window).scrollTop();
        if(!$('body').hasClass('modal-open')){
          if( elementTop <= viewportTop && nextSectionTop >= viewportTop){
            $('body').addClass('js-body-bg-black');
            $('body').addClass('js-bg-black');
            $('.content-wrap').addClass('js-bg-black');
            $('.content-wrap').addClass('js-header-black');
          }else {
            $('body').removeClass('js-body-bg-black');
            $('body').removeClass('js-bg-black');
            $('.content-wrap').removeClass('js-bg-black');
            $('.content-wrap').removeClass('js-header-black');
          }
        }
      }, 0, 1, 1, 1);
    }

    // Change Home footer section bg color to Black
    const BlackBgSection = $('.template-homepage section.newsletter-section');
    const footerSection = $('body').height();

    if (BlackBgSection.length) {
      helpers.onWindowEvents(() => {
        const elementTop = BlackBgSection.position().top - ($(window).height() * 0.7);
        const viewportTop = $(window).scrollTop();
        
        if(!$('body').hasClass('modal-open')){
          if( elementTop <= viewportTop ){
            $('body').addClass('js-body-bg-black');
            $('body').addClass('js-bg-black');
            $('.content-wrap').addClass('js-bg-black');
            $('.content-wrap').addClass('js-header-black');
          }else {
            // $('body').removeClass('js-body-bg-black');
            // $('body').removeClass('js-bg-black');
            // $('.content-wrap').removeClass('js-bg-black');
            // $('.content-wrap').removeClass('js-header-black');
            // $('body').removeClass('js-body-bg-blue');
            // $('body').removeClass('js-bg-blue');
            // $('.content-wrap').removeClass('js-bg-blue');
            // $('.content-wrap').removeClass('js-header-blue');
          }
        }
      }, 0, 1, 1, 1);
    }
    
    //about page black header and footer to fix safari bouncing white bg
    const aboutPage = $('.page-template-template-about');

    if (aboutPage.length) {
      helpers.onWindowEvents(() => {
        const viewportTop = $(window).scrollTop();
        const abtHeroSection = $('.tpl-about-hero').height();
        const viewportBottom = viewportTop + $(window).height();
        const abtFooterSection = $('body').height() - $('.newsletter-section').height() - $('.js-header-black.black-section').height();

        if(!$('body').hasClass('modal-open')){
          if( abtHeroSection >= viewportBottom && abtFooterSection > viewportTop) {
            $('body').addClass('js-body-bg-black');
          }else if(abtFooterSection <= viewportTop && abtHeroSection <= viewportBottom) {
            $('body').addClass('js-body-bg-black');
          }
          else {
            $('body').removeClass('js-body-bg-black');
          }
        }
      }, 0, 1, 1, 1);
    }

    // //expertise page black header and footer to fix safari bouncing white bg
    const expertisePage = $('.page-template-template-expertise');

    if (expertisePage.length) {
      helpers.onWindowEvents(() => {
        const viewportTop = $(window).scrollTop();
        const eptHeroSection = $('.tpl-expertise-hero').height();
        const viewportBottom = viewportTop + $(window).height();
        const eptFooterSection = $('body').height() - $('.newsletter-section').height() - $('.js-header-black.black-section').height();
        if(!$('body').hasClass('modal-open')){
          if( eptHeroSection >= viewportBottom && eptFooterSection > viewportTop) {
            $('body').addClass('js-body-bg-black');
          }
          else if(eptFooterSection <= viewportTop && eptHeroSection <= viewportBottom) {
            $('body').addClass('js-body-bg-black');
          }
          else {
            $('body').removeClass('js-body-bg-black');
          }
        }
      }, 0, 1, 1, 1);
    }

    if(!$('body').hasClass('single-cpt-work') && !$('body').hasClass('page-template-template-about') && !$('body').hasClass('page-template-template-expertise') ){
      if ($('.newsletter-section').length) {
        helpers.onWindowEvents(() => {
          const pageFooterSection = $('body').height() - $('.newsletter-section').height() - $('.js-header-black.black-section').height();
          const viewportTop = $(window).scrollTop();
          if(!$('body').hasClass('modal-open')){
            if( pageFooterSection <= viewportTop){
              $('body').addClass('js-body-bg-black');
            }else {
              $('body').removeClass('js-body-bg-black');
            }
          }
        }, 0, 1, 1, 1);
      }
    }

    if($('body').hasClass('single-cpt-work') ){
      if ($('.newsletter-section').length) {
        helpers.onWindowEvents(() => {
          const pageFooterSection = $('body').height() - ( $('body').height() - $('.content.content-wrap').height() );
          const viewportTop = $(window).scrollTop() + $(window).height();

          if(!$('body').hasClass('modal-open')){
            if( pageFooterSection <= viewportTop){
              $('body').addClass('js-body-bg-black');
            }else {
              $('body').removeClass('js-body-bg-black');
            }
          }
        }, 0, 1, 1, 1);
      }
    }

    //Sticky Menu: Expertise page
    // const stickyMenuSection = $('.page-template-template-expertise .hero-title');
    let stickyMenuSection;
    if($('html').hasClass('mobile') && window.innerWidth <= 1024){
      stickyMenuSection = $('.tpl-expertise-content .content-wrapper');//$('.page-template-template-expertise .hero-title');
    }else{
      stickyMenuSection = $('.tpl-expertise-content .content-wrapper');
    }

    if (stickyMenuSection.length) {
      stickyMenuSection.each(function () {
        const _this = $(this);
        helpers.onWindowEvents(() => {
          const windowHeight = _this.outerHeight();
          const newsletterTop = $('.newsletter-section').offset().top;
          const menuHeight = $('.navigation-items-wrapper').height();
          const footerTop = newsletterTop + windowHeight;
          const viewportBottom = $(window).scrollTop() + windowHeight + menuHeight + 150;

          if( _this.position().top < $(window).scrollTop() && viewportBottom < footerTop){
            $('.navigation-wrapper').addClass('custom-sticky-menu');
          }else{
            $('.navigation-wrapper.custom-sticky-menu').removeClass('custom-sticky-menu');
          }
        }, 0, 1, 1, 1);
      });
    }

    //Srticky Menu: Privacy page
    const stickyMenuPrivacy = $('.privacy-legal-content .content-wrapper');
    if (stickyMenuPrivacy.length) {
      stickyMenuPrivacy.each(function () {
        const _this = $(this);
        helpers.onWindowEvents(() => {
          const windowHeight = _this.outerHeight();
          const newsletterTop = $('.newsletter-section').offset().top;
          const menuHeight = $('.privacy-menu-wrap').height();
          const elementTop = _this.position().top;
          const viewportTop =  $(window).scrollTop();
          const footerTop = newsletterTop + windowHeight;
          const viewportBottom = $(window).scrollTop() + windowHeight + menuHeight + 150;

          if( elementTop < viewportTop  && viewportBottom < footerTop){
            $('.privacy-menu-wrap').addClass('custom-sticky-menu');
          }else{
            $('.privacy-menu-wrap.custom-sticky-menu').removeClass('custom-sticky-menu');
          }
        }, 0, 1, 1, 1);
      });

      // Highlight privacy page menu-item 
      const menuItem = $('.terms-title');
      const menuItemArr = [];
      if (menuItem.length) {
        menuItem.each(function () {
          menuItemArr.push({id: '#link-'+$(this).attr('id'), top: $(this).offset().top });
        });
  
        helpers.onWindowEvents(() => {
          const viewportTop = $(window).scrollTop();
          const viewportRange = $(window).scrollTop() + ( $(window).height() / 2);
  
          $('.menu-item-link').removeClass('current-item');
          for(let i=0; i < menuItemArr.length; i++){
            if( menuItemArr[i].top > viewportTop && menuItemArr[i].top < viewportRange ){
              $(menuItemArr[i].id).addClass('current-item');
              return;
            }
          }
        }, 0, 1, 1, 1);
      }
    }

    // Change section color #228-restquest-disable
    // const sectionCustomColors = $('.section-custom-colors');
    // if (sectionCustomColors.length) {
    //   helpers.onWindowEvents(() => {
    //     let elementTop = 0;
    //     let elementBottom = 0;
    //     let viewportTop = 0;
    //     let viewportBottom = 0;
    //     sectionCustomColors.each(function () {
    //       const _this = $(this);
    //       elementTop += _this.offset().top;
    //       elementBottom += elementTop + _this.outerHeight();
    //       viewportTop += $(window).scrollTop();
    //       viewportBottom += viewportTop + $(window).height();

    //       const backgroundColor = _this.data('background-color');
    //       const textColor = _this.data('text-color');

    //       if ( elementTop < ( viewportBottom - 150)) {
    //         _this.css('background-color', backgroundColor);
    //         _this.css('color', textColor);
    //         _this.css('border-color', textColor);
    //       } else {
    //         _this.css('background-color', '');
    //         _this.css('color', '');
    //         _this.css('border-color', '');
    //       }
    //     });
    //   }, 0, 1, 1, 1);
    // }

    // Show/Hide Sub navigation if available
    const bodyContentNav = $('.body-wrapper .content-nav');
    const subNav = $('.subnav-container');

    if (bodyContentNav.length) {
      helpers.onWindowEvents(() => {
        let bodyContentNavTop = bodyContentNav.offset().top;
        let bodyContentNavBottom = bodyContentNavTop + bodyContentNav.outerHeight();

        let viewportTop = $(window).scrollTop();
        let alreadyPassed = (bodyContentNavBottom > viewportTop) ? true : false;

        if (!alreadyPassed) {
          header.classList.add('subnav-active');
          subNav.fadeIn();
        } else {
          header.classList.remove('subnav-active');
          subNav.fadeOut();
        }
      }, 1, 1, 1, 1);
    }
  },
};
