import helpers from '../../util/helpers';
import bodyScroll from './bodyScroll';

export default {
  init() {

  },
  finalize() {
    const header = $('header');
    const body = $('body');

    // Current menu item
    const menuItem = $('.menu-item');
    if(menuItem.length){
      menuItem.on('click', function (e) {
        menuItem.removeClass('current-menu-item');
        $(this).addClass('current-menu-item');
      });
    }

    // Language selector
    const languageSelector = header.find('.language-selector');
    if (languageSelector.length) {
      const active = languageSelector.find('.active');

      active.on('click', function (e) {
        e.preventDefault();

        languageSelector.toggleClass('open');
      });
    }

    // Hamburger
    const menu = $('.mobile-menu');
    const hamburger = header.find('.hamburger');
    const mobileHamburger = menu.find('.mobile-hamburger');

    const hamburgerFunction = function (){
      menu.toggleClass('open');
      body.toggleClass('menu-open');
      $('.mobile-hamburger').toggleClass('open');
      $('header .hamburger').toggleClass('open');
      bodyScroll.finalize();
    }

    if (hamburger.length) {
      hamburger.on('click', function (e) {
        e.preventDefault();
        hamburgerFunction($(this));
      });

      mobileHamburger.on('click', function (e) {
        e.preventDefault();
        hamburgerFunction();
      });

      // helpers.onWindowEvents(() => {
      //   hamburger.removeClass('open');
      //   mobileHamburger.removeClass('open');
      //   menu.removeClass('open');
      //   body.removeClass('menu-open');
      // }, 1, 1, 1, 0);
    }

    if (header.length) {
      header.each(function () {
        const thisHeader = $(this);
        let lastScroll = $(window).scrollTop();

        // Scroll Passed/Beyond in case
        helpers.onWindowEvents(() => {
          const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
          let headerHeight = 120;

          if (vw < helpers.viewBreakpoints('lg')) {
            headerHeight = 70;
          }

          if ($(window).scrollTop() >= headerHeight) {
            thisHeader.addClass('scroll-passed');
          } else {
            thisHeader.removeClass('scroll-passed');
          }

          // .scroll-beyond
          if ($(window).scrollTop() >= headerHeight) {
            if (lastScroll - $(window).scrollTop() > 0) {
              // Scrolled up;
              thisHeader.removeClass('scroll-beyond');
              
            } else if (lastScroll - $(window).scrollTop() < 0) {
              // Scrolled down
              thisHeader.addClass('scroll-beyond');
              $('header .language-selector').removeClass('open');
            }
          } else {
            thisHeader.removeClass('scroll-beyond');
          }
          lastScroll = $(window).scrollTop();

        }, 1, 1, 1, 1);
      });
    }
  },
};
