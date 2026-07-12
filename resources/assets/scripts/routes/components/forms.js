export default {
  init() {
    // Floating label inputs
    const floatingLabel = $('.input-floating-label');
    if (floatingLabel.length) {
      floatingLabel.each(function() {
        const _this = $(this);
        const input = _this.find('input, textarea');
        const floatedClass = 'floated';

        input.bind('check_val', function () {
          if (input.val() !== '') {
            _this.addClass(floatedClass);
          } else {
            _this.removeClass(floatedClass);
          }
        }).on('focus', function () {
          _this.addClass(floatedClass);
        }).on('blur', function () {
          input.trigger('check_val');
        }).trigger('check_val');
      });
    }
  },
  finalize() {
  },
};
