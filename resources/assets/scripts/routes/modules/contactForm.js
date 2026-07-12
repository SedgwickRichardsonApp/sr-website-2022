import * as constants from '../../util/constants';
import cursor from './cursor';

export default {
  init() {

  },
  finalize() {
    const contactForm = $('.contact-form');
    if (contactForm.length) {
      const contactFormWrapper = $('.contact-modal .contact-form-wrapper');
      const contactThankYou = $('.contact-modal .contact-thank-you');
      const contactSubmitButton = $('.contact-modal .submit-button');

      $('.contact-form input').addClass('cursor-hover');
      $('.contact-form textarea').addClass('cursor-hover');
      cursor.finalize();

      contactSubmitButton.on('click', function(e) {
        e.preventDefault();

        const contactFormSubmit = $('.contact-form input.wpcf7-submit[type="submit"]');
        contactFormSubmit.trigger('click');
        $(this).addClass('disabled');

        $(window).keydown(function(event){
          if( event.keyCode == 13 && contactSubmitButton.hasClass('disabled') ) {
            event.preventDefault();
            return false;
          }
        });
      });

      $(document).on(constants.EVENT_CONTACT_MODAL_CLOSED, function() {
        contactFormWrapper.show();
        contactThankYou.hide();
      });
    }
  },
  formSubmitted(formId) {
    // EN: wpcf7-f187-o1 | ZH: wpcf7-f7566-o1 | VI: wpcf7-f7066-o1
    //f(formId == 'wpcf7-f187-o1' || formId == 'wpcf7-f7566-o1' || formId == 'wpcf7-f7066-o1' || formId == 'wpcf7-f187-o3' || formId == 'wpcf7-f187-o4'){
    let contactStatus = $('.contact-form .wpcf7-form').data('status');
    if(contactStatus == 'submitting' || contactStatus == 'restting' || contactStatus == 'sent' || contactStatus == 'mail_sent'){
      $('.contact-modal .contact-form-wrapper').hide();
      $('.contact-modal .contact-thank-you').show();
    }
    //}
  },
  formResponsed() {
    $('.contact-modal .submit-button').removeClass('disabled');
  },
};
