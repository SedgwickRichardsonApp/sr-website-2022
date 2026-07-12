export default {
  init() {},
  finalize() {
    // Click and jump to item
    const menuItems = $('.menu-item-link');
    if(menuItems){
      menuItems.on('click', function (e) {
        menuItems.removeClass('current-item');
        $(this).addClass('current-item');
        $('html, body').stop().animate({
          scrollTop: $($(this).data('href')).offset().top - 120,
        }, 300);
      });
    }
  },
}
