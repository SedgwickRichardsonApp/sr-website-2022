export default {
  init() {},
  finalize() {
    const emailInput = $('.wpcf7-email');

    const domains = [
      'yahoo.com', 'gmail.com', 'google.com',
      'hotmail.com', 'me.com', 'aol.com',
      'mac.com', 'live.com', 'comcast.com',
      'googlemail.com', 'msn.com', 'hotmail.co.uk',
      'yahoo.co.uk', 'facebook.com', 'verizon.net',
      'att.net', 'gmz.com', 'mail.com',
    ];

    let datalist = null;

    const addElements = function () {
      const datalistId = 'email_options_' + emailInput.attr('name');

      //create empty datalist
      datalist = $('<datalist />', {
        id: datalistId,
      }).insertAfter(emailInput);

      // correlate to input
      emailInput.attr('list', datalistId);
    };

    const addDatalist = function (value) {
      let i;
      let newOptionsString = '';

      // loop over all the domains in our array
      for (i=0; i<domains.length; i++) {
        newOptionsString += '<option value="' +
        value + '@' +
        domains[i] +
        '">';
      }

      // add all the <option>s to the datalist
      datalist.html(newOptionsString);
    };

    const emptyDatalist = function () {
      datalist.empty();
    };

    emailInput.on('keyup', function () {
      const el = $(this);
      let	value = el.val();

      // email has @
      if (value.indexOf('@') != -1) {
        value = value.split('@')[0];

        addDatalist(value);
      } else {
        // empty list
        emptyDatalist();
      }
    });

    addElements();
  },
};
