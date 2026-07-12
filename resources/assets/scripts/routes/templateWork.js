import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';
import helpers from '../util/helpers';
import cursor from './modules/cursor';
import scrollRevealJs from './modules/scrollReveal';
import worksSwipper from './modules/worksSwipper';
import scroll from './modules/scroll';

const WorksSkeleton = () => {
  return (
    <div className="works-grid">
      {
        Array.from(Array(12).keys()).map((i) => {
          return (
            <div key={i} className="work-item-col">
              <div className="work-item skeleton">
                <div className="work-item-image-wrapper skeleton-shine" />
                <div className="work-item-title skeleton-shine" />
                <div className="work-item-client-name skeleton-shine" />
              </div>
            </div>
          );
        })
      }
    </div>
  );
};

class AppWorks extends Component {
  constructor(props) {
    super(props);

    // Initial state
    this.initialState = {
      loading: true,
      allWorks: [],
    };

    // Assign first state
    this.state = Object.assign({}, this.initialState);

    this.taxonomy = '';
    this.term = '';
    this.page = 0;

    const taxonomy = helpers.getParameterByName('filter');
    if (taxonomy != null && taxonomy.length) {
      this.taxonomy = taxonomy;
      $('#view-more-work-button').addClass('hidden');
    }

    const term = helpers.getParameterByName('term');
    if (term != null && term.length) {
      this.term = term;
      $('#view-more-work-button').addClass('hidden');
    }

    // Bind "this"
    this.loadWorks = this.loadWorks.bind(this);

    // Cancel token source
    this.source = axios.CancelToken.source();
  }

  componentDidMount() {
    // Load works on first page load
    this.loadWorks();

    $(document).on(constants.EVENT_WORKS_TAXONOMY_FILTER_CHANGED, (e, taxonomy) => {
      this.taxonomy = taxonomy;
      this.term = '';
      this.loadWorks();
    });

    $(document).on(constants.EVENT_WORKS_TERM_FILTER_CHANGED, (e, term) => {
      if (this.term !== term) {
        this.term = term;
        this.loadWorks();
      }
    });

    $(document).on(constants.EVENT_WORKS_FILTER_CHANGED, (e, taxonomy, term) => {
      this.taxonomy = taxonomy;
      this.term = term;
      this.loadWorks();
    });

    $(document).on(constants.ACTION_GET_WORKS, (e, page) => {
      this.page = page;
      this.loadWorks();
    });
    
  }

  componentDidUpdate() {
    if(!this.state.loading){
      cursor.finalize();
      scrollRevealJs.finalize();
      scroll.finalize();
    }
  }

  loadWorks() {
    // Reset state
    this.setState(this.initialState);

    // Params
    const data = {
      'action': constants.ACTION_GET_WORKS,
      'language': SR['language'],
      'taxonomy': this.taxonomy,
      'term': this.term,
      'page': this.page,
    };

    // Send request
    axios.post(window.SR['ajaxUrl'], qs.stringify(data), {
      cancelToken: this.source.token,
    }).then((axiosResponse) => {
      if (200 === axiosResponse.status) {
        const response = axiosResponse.data;

        if (response.success) {
          const worksCount = response.data['works_count'];
          const works = response.data['works'];
          const totalPosts = response.data['total_posts']

          if (worksCount > 0) {
            if(worksCount === totalPosts){
              $('#view-more-work-button').addClass('hidden');
            }
            this.setState({
              loading: false,
              allWorks: [...works],
            });
          } else {
            this.setState({
              loading: false,
              allWorks: [],
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
      allWorks,
    } = this.state;

    return (
      <Fragment>
        {
          !loading && allWorks.length > 0 && (
            <div>
              {
                allWorks.map((workGroup, i) => {
                  return (
                    <div key={i} className="work-group-wrapper">
                      {
                        workGroup['title'].length > 0 && (
                          <div className="work-group-title-wrapper">
                            <div className="h6 work-group-title">
                              {workGroup['title']}
                            </div>
                            {
                              workGroup['show_view_all_link'] && (
                                <div className="work-group-view-all-link"
                                     data-value={workGroup['id']}
                                >
                                  {SR['translations']['viewAll']}
                                </div>
                              )
                            }
                          </div>
                        )
                      }
                      {
                        workGroup['works'].length > 0 && (
                          <div className={`works-grid ${workGroup['show_view_all_link'] ? 'has-view-all' : 's-sequence-group'}`}>
                            {
                              workGroup['works'].map((work, j) => {
                                return (
                                  <div key={j} className={`work-item-col ${workGroup['show_view_all_link'] ? '' : 's-sequenced'} `}>
                                    <a href={work['link']} className="work-item">
                                      <div className={`work-item-image-wrapper cursor-view ${work['cursor_icon']} ${work['video_url'] ? 'thumbnail-video-wrapper' : ''} `}>
                                        {
                                          work['use_video'] && work['video_format'] == 'iframe' && (
                                            <div className="acf-video-player iframe" dangerouslySetInnerHTML={{__html: work['video_iframe']}}>
                                            </div>
                                          )
                                        }
                                        {
                                          work['use_video'] && work['video_format'] != 'iframe' && (
                                            <video
                                              className="acf-video-player"
                                              src={work['video_url']}
                                              autoPlay
                                              loop
                                              muted
                                              playsInline
                                            >
                                            </video>
                                          )
                                        }
                                        {
                                          work['second_featured_img'] && work['second_featured_img'].length > 0 && !work['use_video'] && (
                                            <img src={work['second_featured_img']}
                                                 className="work-item-image"
                                                 loading="lazy"
                                                 decoding="async"
                                                 alt={work['title']}
                                            />
                                          )
                                        }
                                      </div>
                                      {
                                        work['client_name'].length > 0 && (
                                          <div className="work-item-client-name">
                                            {work['client_name']}
                                          </div>
                                        )
                                      }
                                      {
                                        work['title'].length > 0 && (
                                          <div className="work-item-title">
                                            {work['title']}
                                          </div>
                                        )
                                      }
                                    </a>
                                  </div>
                                );
                              })
                            }
                          </div>
                        )
                      }
                    </div>
                  );
                })
              }
            </div>

          )
        }
        {
          loading && (
            <WorksSkeleton />
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
    // Render results
    let page = 0;
    const worksWrapper = $('#works-wrapper');
    if (worksWrapper.length) {
      ReactDOM.render(<AppWorks />, worksWrapper[0]);
    }

    const workTaxonomiesFilter = $('#work-taxonomies-filter');
    if (workTaxonomiesFilter.length) {
      const filterName = workTaxonomiesFilter.find('.filter-item');
      const filterList = $('.filter-item-terms-wrapper');
      
      workTaxonomiesFilter.hover(function(e) {
        e.preventDefault();
        const params = helpers.getParameters();
        filterName.hover(function(e){
          const _this = $(this);
          const value = _this.data('value');
          const target = _this.data('target');
          const thisList = workTaxonomiesFilter.find($(target));

          filterList.removeClass('active');
          filterName.removeClass('active');
          
          thisList.addClass('active');
          _this.addClass('active');
        });
      }, function(){
        const params = helpers.getParameters();
        filterList.removeClass('active');
        filterName.removeClass('active');
        if(params['filter']){
          $('.filter-item-terms-wrapper.'+params['filter']).addClass('active');
          $('.filter-item.'+params['filter']).addClass('active');
          if(params['term']){
            $('.term-item.'+params['term']+' .item-name').addClass('active');
          }
        }
      });

      const filterItems = workTaxonomiesFilter.find('.filter-item');
      const filterItemTermsWrapper = workTaxonomiesFilter.find('.filter-item-terms-wrapper');

      filterItems.each(function() {
        const thisFilterItem = $(this);

        if (thisFilterItem.hasClass('active')) {
          const target = thisFilterItem.data('target');
          const value = thisFilterItem.data('value');

          if (target) {
            const targetElem = $(target);

            if (targetElem.length) {
              const itemContent = targetElem.get(0);
              $(itemContent).addClass('active');
            }
          }

          if( value == 'expertise' || value ==  'location' || value == 'sector' ){
            $('.tpl-work-results').addClass('works-swipper');
          }else {
            $('.tpl-work-results').removeClass('works-swipper');
          }
        }

        thisFilterItem.on('click', function(e) {
          e.preventDefault();

          const _this = $(this);
          const value = _this.data('value');
          const target = _this.data('target');
          const params = helpers.getParameters();

          filterItems.removeClass('active');
          _this.addClass('active');

          if( value == 'expertise' || value ==  'location' || value == 'sector' ){
            $('.tpl-work-results').addClass('works-swipper');
            $('#view-more-work-button').addClass('hidden');
          }else {
            $('.tpl-work-results').removeClass('works-swipper');
            $('#view-more-work-button').removeClass('hidden');
          }

          $('.filter-item-terms-wrapper .term-item .item-name').removeClass('active');

          if (target) {
            const targetElem = $(target);

            if (targetElem.length) {
              const itemContent = targetElem.get(0);
              if($(itemContent).hasClass('active')){
                $(itemContent).removeClass('active');
              } else {
                filterItemTermsWrapper.each(function(index, element) {
                  $(element).removeClass('active');
                });
                $(itemContent).addClass('active');
              }
            }
          }

          delete params['term'];
          if (value !== '') {
            params['filter'] = value;
          } else {
            delete params['filter'];
          }

          // Push params to url
          helpers.pushStateHistory(!$.isEmptyObject(params) ? '?' + $.param(params) : '');
          $(document).trigger(constants.EVENT_WORKS_TAXONOMY_FILTER_CHANGED, [value]);
        });
      });
    }

    const handleTermFilterChange = function(params) {
      // Push params to url
      helpers.pushStateHistory(!$.isEmptyObject(params) ? '?' + $.param(params) : '');
      $(document).trigger(constants.EVENT_WORKS_FILTER_CHANGED, [params['filter'], params['term']]);
    };

    const workTermsFilter = $('.filter-item-terms-wrapper');
    if (workTermsFilter.length) {
      const termItems = workTermsFilter.find('.term-item');

      termItems.each(function() {
        const thisTermItem = $(this);

        thisTermItem.on('click', function(e) {
          e.preventDefault();

          const params = helpers.getParameters();
          const _this = $(this);
          const parent = _this.data('parent');

          if (parent !== '') {
            params['filter'] = parent;
          }
          params['term'] = _this.data('value');
          termItems.find('.item-name').removeClass('active');
          _this.find('.item-name').addClass('active');
          handleTermFilterChange(params);
        });
      });
    }

    $(document).on('click', '.work-group-view-all-link', function(e) {
      e.preventDefault();
      const params = helpers.getParameters();
      const _this = $(this);
      params['term'] = _this.data('value');
      $('.filter-item-terms-wrapper .term-item .item-name.'+params['term']).addClass('active');
      handleTermFilterChange(params);
      $(window).scrollTop(0);
      worksSwipper.finalize();
    });

    $(document).on('click', '#view-more-work-button', function(e) {
      e.preventDefault();
      page += 1;
      $(document).trigger(constants.ACTION_GET_WORKS, page);
    });

    worksSwipper.finalize();
  },
};
