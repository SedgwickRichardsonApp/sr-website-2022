export default {
  init() {
  },
  finalize() {
    function resumeScroll(){
      const top = $('.main-content-wrap').data('current-top');
      $('.main-content-wrap').removeClass('fix-position');
      $(window).scrollTop(top);
    }

    if($('body').hasClass('modal-open') || $('body').hasClass('menu-open')){
      if($('body').hasClass('menu-open') || $('body').hasClass('contact-modal-mode') || $('body').hasClass('people-modal-mode') || $('body').hasClass('jobs-modal-mode') || $('body').hasClass('search-modal-mode')){
        const top = $(window).scrollTop();
        const topPixel = `-${top}px`;
        $('.main-content-wrap').addClass('fix-position');
        $('.main-content-wrap').data('current-top', top);
        $('.main-content-wrap.fix-position').css({'top': topPixel});
      }else{
        resumeScroll();
      }
    }else{
      resumeScroll();
    }
  },
};
