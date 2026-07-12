import * as constants from '../../util/constants';
import helpers from '../../util/helpers';
import bodyScroll from '../modules/bodyScroll';

export default {
  init() {
    const body = $('body');

    const setupCloseListeners = function(closeEvent, modalClass, closeBtnClass) {
      const closeListener = function(e) {
        e.preventDefault();
        
        if(body.hasClass('view-restriction-modal-mode')){
          body.removeClass(modalClass);
          body.addClass('view-restriction-modal-mode');
        }else{
          body.removeClass(modalClass);
          body.removeClass('modal-open');
        }

        bodyScroll.finalize();
        helpers.stopBodyScrolling(false);
        $(document).trigger(closeEvent);
      };

      $(document).on('click', `.${closeBtnClass}`, closeListener);
      $(document).on('click', `body.${modalClass} .modal-overlay`, closeListener);
      bodyScroll.finalize();

      $(document).on('keyup', function(e) {
        if (e.key == 'Escape') {
          closeListener(e);
        }
      });
    };

    // Contact modal
    const contactModal = $('.contact-modal');
    if (contactModal.length) {
      $(document).on('click', '.contact-modal-trigger', function(e) {
        e.preventDefault();

        body.addClass('contact-modal-mode');
        body.addClass('modal-open');
        helpers.stopBodyScrolling(true);
        bodyScroll.finalize();
      });

      setupCloseListeners(
        constants.EVENT_CONTACT_MODAL_CLOSED,
        'contact-modal-mode',
        'contact-modal-close'
      );
    }

    // People modal
    const peopleModal = $('.people-modal');
    if (peopleModal.length) {
      $(document).on('click', '.people-modal-trigger', function(e) {
        e.preventDefault();
        if(!$(this).hasClass('disabled')){
          body.addClass('people-modal-mode');
          body.addClass('modal-open');
          helpers.stopBodyScrolling(true);
          bodyScroll.finalize();
        }
      });

      setupCloseListeners(
        constants.EVENT_PEOPLE_MODAL_CLOSED,
        'people-modal-mode',
        'people-modal-close'
      );
    }

    // Jobs modal
    const jobsModal = $('.jobs-modal');
    if (jobsModal.length) {
      $(document).on('click', '.jobs-modal-trigger', function(e) {
        e.preventDefault();

        body.addClass('jobs-modal-mode');
        body.addClass('modal-open');
        helpers.stopBodyScrolling(true);
        bodyScroll.finalize();
      });

      setupCloseListeners(
        constants.EVENT_JOBS_MODAL_CLOSED,
        'jobs-modal-mode',
        'jobs-modal-close'
      );
    }

    // Search modal
    const searchModal = $('.search-modal');
    if (searchModal.length) {
      $(document).on('click', '.search-modal-trigger', function(e) {
        e.preventDefault();

        body.addClass('search-modal-mode');
        body.addClass('modal-open');
        helpers.stopBodyScrolling(true);
        bodyScroll.finalize();
      });

      setupCloseListeners(
        constants.EVENT_SEARCH_MODAL_CLOSED,
        'search-modal-mode',
        'search-modal-close'
      );
    }
  },
  finalize() {

  },
};
