/* global _ */
/*
  Version: 1.0
  Author: Rock Solid Digital
*/

(function($) {
  const body = $('body');

  let screen_admin_min = 783;
  let adminBarHeight = 0;

  const onWindowEvents = function(foo, isReady, isLoad, isResize, isScroll) {
    if (isReady) {
      $(document).ready(foo);
    }

    if (isLoad) {
      $(window).bind('load', foo);
    }

    if (isResize) {
      const throttleResizing = _.throttle(foo, 100);
      $(window).bind('resize', throttleResizing);
    }

    if (isScroll) {
      const throttleScroll = _.throttle(foo, 10);
      $(window).bind('scroll', throttleScroll);
    }
  };

  onWindowEvents(() => {
    if (body.hasClass('admin-bar')) {
      if ($(window).width() > screen_admin_min) {
        adminBarHeight = 32;
      }
      else {
        adminBarHeight = 46;
      }
    }
  }, 1, 1, 1, 0);

  $.fn.goToElement = function(event, offset, animate) {
    if (typeof event !== 'undefined') {
      event.preventDefault();
    }
    if (typeof offset === 'undefined') {
      offset = 0;
    }
    if (typeof animate === 'undefined') {
      animate = true;
    }
    if ($(this).length) {
      let offsetTop = $(this).offset().top + offset;
      let scrollTop = offsetTop - adminBarHeight;

      if (animate) {
        let args = {
          scrollTop,
        };
        $('html, body, .overlay-wrap').animate(args, 'slow');
      } else {
        $('html, body, .overlay-wrap').scrollTop(scrollTop);
      }
    }
    return this;
  };

}(jQuery));
