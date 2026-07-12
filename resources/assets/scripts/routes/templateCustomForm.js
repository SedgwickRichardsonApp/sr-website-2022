import * as constants from '../util/constants';
import cursor from './modules/cursor';

export default {
  init() {

  },
  finalize() {
    const customForm = $('.custom-form');
    
    if (customForm.length) {
      const customSubmitButton = $('.custom-form-element .submit-button');

      $('.custom-form-element input').addClass('cursor-hover');
      $('.custom-form-element textarea').addClass('cursor-hover');
      cursor.finalize();
      
      customSubmitButton.on('click', function(e) {
        e.preventDefault();

        const customFormSubmit = $('.custom-form-element input.wpcf7-submit[type="submit"]');
        customFormSubmit.trigger('click');
        $(this).addClass('disabled');
        
        $(window).keydown(function(event){
          if( event.keyCode == 13 && customSubmitButton.hasClass('disabled') ) {
            event.preventDefault();
            return false;
          }
        });
      });
    }
  },
  formSubmitted(formId) {
    // Local dev: wpcf7-f13972-o2
    // EN: wpcf7-f17376-o2 | ZH: wpcf7-f17377-o2  | VI: wpcf7-f17378-o2
    if(formId == 'wpcf7-f13972-o2' || formId == 'wpcf7-f17376-o2' || formId == 'wpcf7-f17377-o2' || formId == 'wpcf7-f17378-o2'){
      let customFormStatus = $('.custom-form-element .wpcf7-form').data('status');
      if(customFormStatus == 'submitting' || customFormStatus == 'restting' || customFormStatus == 'sent'){
        $('.custom-form-content .custom-form-wrapper').removeClass('cf-show');
        $('.custom-form-content .custom-form-wrapper').addClass('cf-hide');
        $('.custom-form-content .custom-form-thank-you').removeClass('cf-hide');
        $('.custom-form-content .custom-form-thank-you').addClass('cf-show');
        $(window).scrollTop(top);
      }
    }
  },
  formResponsed() {
    $('.custom-form-element .submit-button').removeClass('disabled');
  },
};
