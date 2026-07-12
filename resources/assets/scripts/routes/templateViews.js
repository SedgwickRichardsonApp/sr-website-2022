import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';
import helpers from '../util/helpers';
import scrollRevealJs from './modules/scrollReveal';
import scroll from './modules/scroll';

const ViewsSkeleton = () => {
  return (
    <div className="panel-body grid grid-flow-row grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 3xl:grid-cols-3 gap-x-9 gap-y-12">
      {
        Array.from(Array(12).keys()).map((i) => {
          return (
            <div key={i} className={'panel-item skeleton ' + (i === 0 ? 'featured' : '')}>
              <div className="view-image-wrapper skeleton-shine" />
              <div className="view-title skeleton-shine" />
            </div>
          );
        })
      }
    </div>
  );
};

class AppViews extends Component {
  constructor(props) {
    super(props);

    // Initial state
    this.initialState = {
      loading: true,
      allViews: [],
    };

    // Assign first state
    this.state = Object.assign({}, this.initialState);

    this.category = '';
    this.page = 0;

    const category = helpers.getParameterByName('type');
    if (category != null && category.length) {
      this.category = category;
    }

    // Bind "this"
    this.loadViews = this.loadViews.bind(this);

    // Cancel token source
    this.source = axios.CancelToken.source();
  }

  componentDidMount() {
    // Load views on first page load
    this.loadViews();

    $(document).on(constants.EVENT_VIEWS_TERM_FILTER_CHANGED, (e, category) => {
      this.category = category;
      this.loadViews();
      
    });

    $(document).on(constants.ACTION_GET_VIEWS, (e, page) => {
      this.page = page;
      this.loadViews();
    });

  }

  componentDidUpdate() {
    if(!this.state.loading){
      scrollRevealJs.finalize();
      scroll.finalize();
    }
  }

  loadViews() {
    // Reset state
    this.setState(this.initialState);

    // Params
    const data = {
      'action': constants.ACTION_GET_VIEWS,
      'language': SR['language'],
      'category': this.category,
      'page': this.page,
    };

    // Send request
    axios.post(window.SR['ajaxUrl'], qs.stringify(data), {
      cancelToken: this.source.token,
    }).then((axiosResponse) => {
      if (200 === axiosResponse.status) {
        const response = axiosResponse.data;

        if (response.success) {
          const views = response.data['views'];
          const viewsCount = response.data['views_count']
          const totalPosts = response.data['total_posts'];

          if (viewsCount > 0) {
            if(viewsCount === totalPosts){
              $('#view-more-views-button').addClass('hidden');
            }
            this.setState({
              loading: false,
              allViews: [...views],
            });
          } else {
            this.setState({
              loading: false,
              allViews: [],
            });
          }
        } else {
          this.setState({
            loading: false,
            allWorks: [],
          });
        }
      }
    }).catch((error) => {
      console.log(error);
    });
  }

  render() {
    const {
      loading,
      allViews,
    } = this.state;

    return (
      <Fragment>
         {
          loading && (
            <ViewsSkeleton />
          )
        }
        {
          !loading && allViews.length > 0 && (
            <div className="s-sequence-group panel-body grid grid-flow-row grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 3xl:grid-cols-3 gap-x-9 gap-y-12">
              {
                allViews.map((views, i) => {
                  return (
                    <div key={i} className={'panel-item cursor-view s-sequenced ' + views['class']}>
                      <a href={views['link']}>
                        <div className={`view-image-wrapper ${views['video_url'] ? 'thumbnail-video-wrapper' : ''}`}>
                          {
                            views['use_video'] && views['video_format'] == 'iframe' && (
                              <div className="acf-video-player iframe" dangerouslySetInnerHTML={{__html: views['video_iframe']}}>
                              </div>
                            )
                          }
                          {
                            views['use_video'] && views['video_format'] !== 'iframe' && (
                              <video
                                className="acf-video-player"
                                src={views['video_url']}
                                autoPlay
                                loop
                                muted
                                playsInline
                              >
                              </video>
                            )
                          }
                          { !views['use_video'] && (
                          <img
                            src={views['image']}
                            className="view-image"
                            loading="lazy"
                            decoding="async"
                            alt={views['title']} />
                          )}
                        </div>
                        <div className="view-author">
                          {views['author']}
                        </div>
                        <div className="view-title">
                          {views['title']}
                        </div>
                      </a>
                    </div>
                  );
                })
              }
            </div>
          )
        }
      </Fragment>
    );
  }
}

export default {
  init() {

  },
  finalize() {
    let page = 0;

    const viewsWrapper = $('#views-wrappers');

    if (viewsWrapper.length) {
      ReactDOM.render(<AppViews />, viewsWrapper[0]);
    }

    const tabsWrapper = $('#tabs-wrapper');
    if (tabsWrapper.length) {
      const tabItems = tabsWrapper.find('.tab-item');

      tabItems.each(function() {
        const thisTabItem = $(this);

        thisTabItem.on('click', function(e) {
          e.preventDefault();

          const _this = $(this);
          // page = 0;
          tabItems.removeClass('active');
          _this.addClass('active');
          handleTermFilterChange(_this);
        });
      });

      $(document).on(constants.EVENT_VIEWS_TAXONOMY_FILTER_CHANGED, () => {
        tabItems.removeClass('active');
      });
    }

    const handleTermFilterChange = function(element) {
      const target = element.data('target');
      const params = helpers.getParameters();

      if (target !== '') {
        params['type'] = target;
      } else {
        delete params['type'];
      }

      // Push params to url
      helpers.pushStateHistory(!$.isEmptyObject(params) ? '?' + $.param(params) : '');
      $(document).trigger(constants.EVENT_VIEWS_TERM_FILTER_CHANGED, [target]);
    };

    $(document).on('click', '#view-more-views-button', function(e) {
      e.preventDefault();
      const params = helpers.getParameters();
      if(params && params['type']){
        $(document).trigger(constants.EVENT_VIEWS_TERM_FILTER_CHANGED, [params['type']]);
      }else{
        page += 1;
        $(document).trigger(constants.ACTION_GET_VIEWS, page);
      }
    });
  },
};
