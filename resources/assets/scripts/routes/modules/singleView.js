import cursor from '../modules/cursor';

export default {
  init() {

  },
  finalize() {
    if($('body').hasClass('single-cpt-views')){
      const content = $('.cpt-views-content .content-wrapper');
      content.find('a').addClass('cursor-link');
      cursor.finalize();
    }
  },
}
