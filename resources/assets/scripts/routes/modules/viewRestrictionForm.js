import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import axios from 'axios';
import qs from 'qs';
import * as constants from '../../util/constants';
import helpers from '../../util/helpers';
import cursor from '../modules/cursor';
import scrollRevealJs from '../modules/scrollReveal';


const ContentSkeleton = () => {
  return (
    <div>
      <div className="skeleton">
        <div className="skeleton-shine" />
      </div>
      <div className="skeleton">
        <div className="skeleton-shine" />
      </div>
      <div className="skeleton">
        <div className="skeleton-shine" />
      </div>
    </div>
  );
};

class RestrictedContent extends Component {
  constructor(props) {
    super(props);

    // Initial state
    this.initialState = {
      loading: true,
      restrictedContent: '',
      viewId: props.viewId,
    };

    // Assign first state
    this.state = Object.assign({}, this.initialState);

    // Bind "this"
    this.fetchContent = this.fetchContent.bind(this);

    // Cancel token source
    this.source = axios.CancelToken.source();
  }

  componentDidMount() {
    if (this.props.viewId) {
      $('.view-restriction-wrap').addClass('registered');
      this.fetchContent(this.props.viewId);
    }
  }

  componentDidUpdate() {
    if(!this.state.loading) {
      const content = $('.cpt-views-content .content-wrapper .restricted-content');
      content.find('a').addClass('cursor-link');
      cursor.finalize();
    }
  }

  fetchContent(viewId) {
    // Reset state
    this.setState(this.initialState);

    // Params
    const data = {
      'action': constants.ACTION_GET_VIEW_RESTRICTION_REVEAL_TYPE_CONTENT,
      'language': SR['language'],
      'view_id': this.props.viewId,
    };

    // Send request
    axios.post(window.SR['ajaxUrl'], qs.stringify(data), {
      cancelToken: this.source.token,
    }).then((axiosResponse) => {
      if (200 === axiosResponse.status) {
        const response = axiosResponse.data;

        if (response.success) {
          const content = response.data['content'];

          if (content.length > 0) {
            this.setState({
              loading: false,
              restrictedContent: content,
            });
          } else {
            this.setState({
              loading: false,
              restrictedContent: '',
            });
          }
        }
      }
    }).catch((error) => {
      console.log(error);
    });
  }

  render() {
    const {
      loading,
      restrictedContent,
    } = this.state;

    return (
      <Fragment>
        {
          !loading && restrictedContent.length > 0 && (
            <div dangerouslySetInnerHTML={{__html: restrictedContent}}></div>
          )
        }
        {
          loading && (
            <ContentSkeleton />
          )
        }
      </Fragment>
    );
  }
}

RestrictedContent.propTypes = {
  viewId: PropTypes.number,
};

export default {
  init() {

  },
  finalize() {
    const viewContent = $('.cpt-views-content');
    if (viewContent.length) {
      const contentWrap = $('.view-restriction-wrap');
      const _this = $('.cpt-views-content');
      contentWrap.removeClass('expanded');

      helpers.onWindowEvents(() => {
        const contentBottom = _this.position().top + _this.outerHeight();
        const windowBottom = $(window).scrollTop() + $(window).height() - 200;
        if(!contentWrap.hasClass('registered')){
          if(!contentWrap.hasClass('expanded') && windowBottom >= contentBottom){
            contentWrap.addClass('expanded');
          }
        }
      }, 0, 1, 1, 1);
    }

    const viewRestrictionForm = $('.view-restriction-form');
    if (viewRestrictionForm.length) {
      const relatedViews = $('.cpt-views-related-views');
      const viewRestrictionModal = viewRestrictionForm.closest('.view-restriction-wrap');
      const modalClose = viewRestrictionModal.find('.view-restriction-close');
      const viewRestrictionFormWrapper = $('.view-restriction-form-wrapper');
      const viewRestrictionThankYou = viewRestrictionFormWrapper.next('.view-restriction-thank-you');
      const restrictionSubmitButton = $('.view-restriction-form .submit-button');

      viewRestrictionForm.find('input').addClass('cursor-hover');
      viewRestrictionForm.find('textarea').addClass('cursor-hover');
      $('#viewPageTitle').val($('#viewRestrictionForm').data('page-title'));
      $('#viewResponsePdf').val($('#viewRestrictionForm').data('pdf-url'));
      
      // scrollRevealJs.finalize();
      cursor.finalize();

      modalClose.on('click', function(e) {
        $('.view-restriction-wrap').addClass('hidden');
      });

      restrictionSubmitButton.on('click', function(e) {
        e.preventDefault();

        const restrictionFormSubmit = viewRestrictionForm.find('input.wpcf7-submit[type="submit"]');

        restrictionFormSubmit.trigger('click');
        $(this).addClass('disabled');
        $(window).keydown(function(event){
          if( event.keyCode == 13 && restrictionSubmitButton.hasClass('disabled') ) {
            event.preventDefault();
            return false;
          }
        });
      });
    }
  },
  formSubmitted(formId) {
    const formIdArray = ['wpcf7-f1031-o3', 'wpcf7-f1025-o3', 'wpcf7-f1030-o3', 'wpcf7-f7563-o3', 'wpcf7-f7565-o3', 'wpcf7-f7564-o3', 'wpcf7-f7061-o3', 'wpcf7-f1025-o3', 'wpcf7-f7063-o3' ];
    // Reveal: EN: wpcf7-f1031-o3 | ZH: wpcf7-f7563-o3 | VI: wpcf7-f7061-o3
    // PDF Request: EN: wpcf7-f1025-o3 | ZH: wpcf7-f7565-o3 | VI: wpcf7-f1025-o3
    // PDF auto Response: EN: wpcf7-f1030-o3 | ZH: wpcf7-f7564-o3 | VI: wpcf7-f7063-o3
    
    if(formIdArray.includes(formId) ){
      const viewRestrictionForm = $('.view-restriction-form');
      const relatedViews = $('.cpt-views-related-views');
      const viewRestrictionModal = viewRestrictionForm.closest('.view-restriction-wrap');
      const modalClose = viewRestrictionModal.find('.view-restriction-close');
      const viewRestrictionFormWrapper = $('.view-restriction-form-wrapper');
      const viewRestrictionThankYou = viewRestrictionFormWrapper.next('.view-restriction-thank-you');
      const restrictionSubmitButton = $('.view-restriction-form .submit-button');
      if (viewRestrictionThankYou.length) {
        let restrictedStatus = $('.view-restriction-form .wpcf7-form').data('status');
        if(restrictedStatus == 'submitting' || restrictedStatus == 'restting' || restrictedStatus == 'sent'){
          if (relatedViews.length) {
            relatedViews.show();
          }

          modalClose.show();
          viewRestrictionFormWrapper.hide();
          viewRestrictionThankYou.show();
        }

        $(document).on(constants.EVENT_VIEW_RESTRICTION_MODAL_CLOSED, function() {
          viewRestrictionFormWrapper.show();
          viewRestrictionThankYou.hide();
        });
      } else {
        let restrictedStatus = $('.view-restriction-form .wpcf7-form').data('status');
        if(restrictedStatus == 'submitting' || restrictedStatus == 'restting' || restrictedStatus == 'sent'){
          if (relatedViews.length) {
            relatedViews.show();
          }

          modalClose.trigger('click');

          helpers.docCookies.setItem('registered_restriction', viewId, Infinity);
          
          let viewId = viewRestrictionFormWrapper.data('view-id');

          if (viewId) {
            const contentWrapper = $('.cpt-views-content .content-wrapper');

            const restrictedContentWrapper = $('.restricted-content');
            ReactDOM.render(<RestrictedContent viewId={viewId} />, restrictedContentWrapper[0]);
          }
        }
      }
    }
  },
  formResponsed() {
    $('.view-restriction-form .submit-button').removeClass('disabled');
  },
};
