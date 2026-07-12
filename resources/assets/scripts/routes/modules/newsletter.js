import cursor from './cursor';

export default {
  init() {

  },
  finalize() {
    const newsletterForm = $('.newsletter-section .newsletter-form');
    if (newsletterForm.length) {
      const newsSubmitButton = $('.newsletter-section .submit-button');
      
      $('.newsletter-form input').addClass('cursor-hover');
      cursor.finalize();
      
      newsSubmitButton.on('click', function(e) {
        e.preventDefault();
        const newsFormSubmit = $('.newsletter-section input.wpcf7-submit[type="submit"]');

        newsFormSubmit.trigger('click');
        $(this).addClass('disabled');
        $(window).keydown(function(event){
          if( event.keyCode == 13 && newsSubmitButton.hasClass('disabled') ) {
            event.preventDefault();
            return false;
          }
        });
      });
    }
  },
  formResponsed() {
    $('.newsletter-section .submit-button').removeClass('disabled');
  },
};
