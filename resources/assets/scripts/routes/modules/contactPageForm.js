import * as constants from '../../util/constants';
import cursor from './cursor';

export default {
  init() {

  },
  finalize() {
    const contactForm = $('.contact-form2');
    if (contactForm.length) {
      const contactFormWrapper = $('.tpl-contact-form .contact-form-wrapper');
      const contactThankYou = $('.tpl-contact-form .contact-thank-you');
      const contactSubmitButton = $('.tpl-contact-form .submit-button');

      $('.contact-form2 input').addClass('cursor-hover');
      $('.contact-form2 textarea').addClass('cursor-hover');
      cursor.finalize();

      contactSubmitButton.on('click', function(e) {
        e.preventDefault();

        const contactFormSubmit = $('.contact-form2 input.wpcf7-submit[type="submit"]');
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
    //if(formId == 'wpcf7-f187-o1' || formId == 'wpcf7-f7566-o1' || formId == 'wpcf7-f7066-o1' || formId == 'wpcf7-f187-o3' || formId == 'wpcf7-f187-o4'){
    let contactStatus = $('.contact-form2 .wpcf7-form').data('status');
    if(contactStatus == 'submitting' || contactStatus == 'restting' || contactStatus == 'sent' || contactStatus == 'mail_sent'){
      $('.tpl-contact-form .contact-form-wrapper').hide();
      $('.tpl-contact-form .contact-thank-you').show();
    }
    //}
  },
  formResponsed() {
    $('.tpl-contact-form .submit-button').removeClass('disabled');
  },
};
