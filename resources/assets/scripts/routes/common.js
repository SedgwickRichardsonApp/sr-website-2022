import * as constants from '../util/constants';
import helpers from '../util/helpers';

// Modules
import contactPageForm from './modules/contactPageForm';
import contactForm from './modules/contactForm';
import customForm from './templateCustomForm';
import cursor from './modules/cursor';
import emailAutocomplete from './modules/emailAutocomplete';
import header from './modules/header';
import newsletter from './modules/newsletter';
import scroll from './modules/scroll';
import people from './modules/people';
import jobs from './modules/jobs';
import scrollRevealJs from './modules/scrollReveal';
import search from './modules/search';
import viewRestrictionForm from './modules/viewRestrictionForm';
import singleView from './modules/singleView';

// Components
import forms from './components/forms';
import modals from './components/modals';

// ACF Blocks
import imageSlider from './acf-blocks/imageSlider';
import imageColumns from './acf-blocks/imageColumns';
import srVideo from './acf-blocks/srVideo';


export default {
  init() {
    $('html').removeClass('en zh vi');
    const lang = $('html').attr('lang');
    if(lang == 'zh-CN'){
      $('html').addClass('zh');
      $('html').attr('data-lang', 'zh');
    }else if(lang == 'vi-VN'){
      $('html').addClass('vi');
      $('html').attr('data-lang', 'vi');
    }else{
      $('html').addClass('en');
      $('html').attr('data-lang', 'en');
    }

    // JavaScript to be fired on all pages
    if($('.cky-consent-container').hasClass('cky-hide')){
      $('.smart-page-loader').css('display','none');
    }else{
      setTimeout(() => {
        $('.smart-page-loader').css('display','none');
        // $('.cky-modal').addClass('cky-modal-open');
      }, 5000);
    }

    // Check if ipadOS
    if(navigator.maxTouchPoints > 1){
      $('html').addClass('mobile');
    }

    //for smooth go to scroll
    const gotoscroll = $('.goto-scroll');
    if (gotoscroll.length) {
      gotoscroll.each(function () {
        $(this).on('click', function (e) {

          const targetID = $(this).data('target');
          $('#' + targetID).goToElement(e);
        });
      });
    }

    if(!$('body').hasClass('tpl-homepage')){
      $('body').addClass('js-bg-black');
    }

    // Components
    forms.init();
    modals.init();

    // ACF Blocks
    imageSlider.init();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired

    /**
     * Balance elements
     */
    helpers.onWindowEvents(() => {
      helpers.equalHeightElements($('.balance-elements'), false, 30);
    }, 1, 1, 1, 0);

    $(document).on(constants.EVENT_BALANCE_ELEMENTS, () => {
      helpers.equalHeightElements($('.balance-elements'), false, 30);
    });

    $(document).on('wpcf7mailsent', function(event) {
      let formId = event.detail.unitTag;
      viewRestrictionForm.formSubmitted(formId);
      contactPageForm.formSubmitted(formId);
      contactForm.formSubmitted(formId);
      customForm.formSubmitted(formId);
    });

    $(document).on('wpcf7submit', function(event) {
      // let status = event.detail.status;
      contactPageForm.formResponsed();
      contactForm.formResponsed();
      viewRestrictionForm.formResponsed();
      newsletter.formResponsed();
      customForm.formResponsed();
    });


    $('.cursor-link.cursor-dot-copy').on('click', function(e) {
      $('body').addClass('copied-prompt');

      setTimeout(()=>{
        $('body').removeClass('copied-prompt');
      }, 2000);
    });

    $('.cursor-copy-address').on('click', function(e) {
      $('body').addClass('copied-prompt copied-address-prompt');

      setTimeout(()=>{
        $('body').removeClass('copied-prompt copied-address-prompt');
      }, 2000);
    });

    // Modules
    contactPageForm.finalize();
    contactForm.finalize();
    customForm.finalize();
    cursor.finalize();
    emailAutocomplete.finalize();
    header.finalize();
    newsletter.finalize();
    scroll.finalize();
    people.finalize();
    jobs.finalize();
    search.finalize();
    scrollRevealJs.finalize();
    viewRestrictionForm.finalize();
    imageSlider.finalize();
    imageColumns.finalize();
    srVideo.finalize();
    singleView.finalize();
  },
};
