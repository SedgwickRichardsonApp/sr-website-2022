export default {
  init() {},
  finalize() {
    setTimeout(()=> {
      if($('.works-grid').hasClass('has-view-all') && $('.tpl-work-results').hasClass('works-swipper')){
        $('.tpl-work-results').addClass('works-swipper');
      }else {
        $('.tpl-work-results').removeClass('works-swipper');
      }
    }, 1000);

  },
}
