/* global TweenLite, TweenMax */
import helpers from '../../util/helpers';

export default {
  init() {

  },
  finalize() {
    if(!$('html').hasClass('mobile')){
      const cursorsWrapper = $('.cursors-wrapper'), inter = 30, speed = 0;

      if (cursorsWrapper.length) {
        cursorsWrapper.html('');
        for (let i = 0; i < 30; i++) {
          cursorsWrapper.append('<div class="cursor"><div class="dot"></div></div>')
        }

        const cursor = $('.cursor');

        $(window).on('mousemove pointermove', function (e) {
          cursor.each(function (index) {
            const _this = $(this);
            TweenLite.to(_this, 0.05, {
              css: {
                left: e.clientX,
                top: e.clientY,
              },
              delay: 0+(index / 750),
            });
          });
        });

        cursor.each(function () {
          const _this = $(this);
          TweenMax.set(_this, {
            autoAlpha: 1,
            delay: 0,
          });
        });

        const changeCursor = function(selector, type) {
          if (selector.length) {
            selector.each(function() {
              const thisSelector = $(this);
              thisSelector.hover(() => {
                cursorsWrapper.addClass(`cursor-${type}`);
                switch (type) {
                  case 'link':
                  case 'hover':
                    cursorsWrapper.addClass('only-one');
                    break;
                  case 'copy':
                  case 'copy-email':
                  case 'dot-copy':
                  case 'copy-address': {
                    const text = thisSelector.data('text');
                    if (text) {
                      thisSelector.on('click', function(e) {
                        e.preventDefault();

                        helpers.copyToClipboard(text);
                        cursorsWrapper.addClass('copied');

                        return false;
                      });
                    }
                    break;
                  }
                  default:
                    break;
                }
              }, () => {
                cursorsWrapper.removeClass(`cursor-${type}`);

                switch (type) {
                  case 'link':
                  case 'hover':
                    cursorsWrapper.removeClass('only-one');
                    break;
                  case 'copy':
                  case 'copy-email':
                  case 'dot-copy':
                  case 'copy-address':
                    cursorsWrapper.removeClass('copied');
                    break;
                  default:
                    break;
                }
              });
            });
          }
        };

        changeCursor($('.cursor-hover'), 'hover');
        changeCursor($('.cursor-link'), 'link');
        changeCursor($('.cursor-hover-dark'), 'hover-dark');
        changeCursor($('.cursor-star'), 'star');
        changeCursor($('.cursor-smile'), 'smile');
        changeCursor($('.cursor-sad'), 'sad');
        changeCursor($('.cursor-staff'), 'staff');
        changeCursor($('.cursor-circle'), 'circle');
        changeCursor($('.cursor-slider'), 'slider');
        changeCursor($('.cursor-view'), 'view');
        changeCursor($('.cursor-invert'), 'invert');
        changeCursor($('.cursor-brand-building'), 'brand-building');
        changeCursor($('.cursor-employer-branding'), 'employer-branding');
        changeCursor($('.cursor-investment-branding'), 'investment-branding');
        changeCursor($('.cursor-place-branding'), 'place-branding');
        changeCursor($('.cursor-sustainability'), 'sustainability');
        changeCursor($('.cursor-dots-matrix'), 'dots-matrix');
        changeCursor($('.cursor-xl-brand-building'), 'xl-brand-building');
        changeCursor($('.cursor-xl-employer-branding'), 'xl-employer-branding');
        changeCursor($('.cursor-xl-investment-branding'), 'xl-investment-branding');
        changeCursor($('.cursor-xl-place-branding'), 'xl-place-branding');
        changeCursor($('.cursor-xl-sustainability'), 'xl-sustainability');
        // changeCursor($('.cursor-copy'), 'copy');
        changeCursor($('.cursor-dot-copy'), 'dot-copy');
        changeCursor($('.cursor-copy-email'), 'copy-email');
        changeCursor($('.cursor-copy-address'), 'copy-address');
        changeCursor($('.cursor-exclusion'), 'exclusion');
        changeCursor($('.cursor-hue'), 'hue');
        changeCursor($('.cursor-lighten'), 'lighten');
        changeCursor($('.cursor-normal'), 'normal');
        changeCursor($('.cursor-screen'), 'screen');
      }
    }
  },
};
