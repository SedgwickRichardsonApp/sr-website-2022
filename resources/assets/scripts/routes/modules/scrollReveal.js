/* global ScrollReveal */

export default {
  init() {
  },
  finalize() {
    setTimeout(() => {
      const sequenceGroup = $('.s-sequence-group');
      if (sequenceGroup.length) {
        sequenceGroup.each((index, group) => {
          const _this = $(group);
          const items = _this.find('.s-sequenced');
          ScrollReveal().reveal(items, {
            delay: 0, //300, 
            origin: 'bottom',
            distance: '30px',
            duration: 600,
            interval: 100, //300,
            reset: false,
            afterReveal: function (i) {
              $(i).addClass('s-revealed');
            },
          });
        });
      }

      const revealGroup = $('.s-reveal');
      if (revealGroup.length) {
        revealGroup.each((index, item) => {
          ScrollReveal().reveal(item, {
            delay: 0, //300, 
            origin: 'bottom',
            distance: '30px',
            duration: 600,
            interval: 100, //300, 
            reset: false,
            afterReveal: function (i) {
              $(i).addClass('s-revealed');
            },
          });
        });
      }

      const teamGroup = $('.s-team-group');
      if (teamGroup.length) {
        teamGroup.each((index, team) => {
          const _this = $(team);
          const items = _this.find('.s-sequenced');
          ScrollReveal().reveal(items, {
            delay: 200, //300, 
            origin: 'bottom',
            distance: '30px',
            duration: 600,
            interval: 200, //300,
            reset: false,
            afterReveal: function (i) {
              $(i).addClass('s-revealed');
            },
          });
        });
      }
    }, 0);
    // console.log(window.sr.store.elements);
    // // const srItems = window.sr;
    
    // setTimeout(() => {
    //   $.each(window.sr.store.elements, (e, element) => {
    //     // console.log(element);
    //     let styles = [element.styles.inline.generated];
    
    //     if (element.visible) {
    //       console.log(element);
    //       styles.push(element.styles.opacity.computed);
    //       styles.push(element.styles.transform.generated.final);
    //       element.revealed = true;
    //     } else {
    //       styles.push(element.styles.opacity.generated);
    //       styles.push(element.styles.transform.generated.initial);
    //       element.revealed = false;
    //     }
    //     element.node.setAttribute('style', styles.filter((s) => s !== '').join(' '));
    //     // console.log(styles);
    //     // console.log(element);
    //   });
    // }, 1000);
  },
};
