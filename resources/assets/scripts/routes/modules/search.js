import axios from 'axios';
import qs from 'qs';
import * as constants from '../../util/constants';
import cursor from './cursor';

export default {
  init() {
  },
  finalize() {
    // Search modal
    const searchModal = $('.search-modal');
    if (searchModal.length) {
      const searchInput = searchModal.find('.search-input');
      const resultsWrapper = searchModal.find('.results-wrapper');
      let text;

      $(document).on('click', '.search-modal-trigger', function(e) {
        e.preventDefault();
        

        setTimeout(function() {
          searchInput.focus();
        }, 500);

        if (!searchModal.hasClass('autocomplete-data-loaded')) {
          const data = {
            'action': constants.ACTION_GET_SEARCH_AUTOCOMPLETE_DATA,
            'language': SR['language'],
          };

          // Send request
          axios.post(window.SR['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
            if (200 === axiosResponse.status) {
              const response = axiosResponse.data;
              text = response.data.text;
              if (response.success) {
                resultsWrapper.data('feed', response.data.data);
                searchModal.removeClass('autocomplete-data-loading');
                searchModal.addClass('autocomplete-data-loaded');
                searchInput.trigger('input');
              }
            }
          }).catch((error) => {
            console.log(error);
          });
        }
      });

      let timeout = null;
      searchInput.on('input', function() {
        if (searchModal.hasClass('autocomplete-data-loaded')) {
          clearTimeout(timeout);
          const _this = $(this);
          const inputVal = _this.val();
          
          timeout = setTimeout(function () {
            if (inputVal.trim() === '') {
              resultsWrapper.html('');
            } else {
              const resultsWrapperFeed = resultsWrapper.data('feed');

              if (resultsWrapperFeed && resultsWrapperFeed.length > 0) {
                let resultsHtml = '';
                let hasOtherHeader = false;
                let otherCounts = 0;

                $.each(resultsWrapperFeed, function(i, item) {
                  const title = item.title;
                  const titleText = item.title_text;
                  const list = item.list;
                  const isHighlight = item.is_highlight;
                  const isOther = item.is_other;
                  
                  const results = list.filter(function(p) {
                    const input = inputVal.toLowerCase();
                    const matchExpertise = p.expertise ? p.expertise.findIndex((item) => input === item.toLowerCase()) >= 0 ? true : false : false;
                    const matchService = p.service ? p.service.findIndex((item) => input === item.toLowerCase()) >= 0 ? true : false : false;
                    const matchSector = p.sector ? p.sector.findIndex((item) => input === item.toLowerCase()) >= 0 ? true : false : false;
                    const matchLocation = p.location ? p.location.findIndex((item) => input === item.toLowerCase()) >= 0 ? true : false : false;

                    if(p.title.toLowerCase().indexOf(input) >= 0 || matchExpertise || matchService || matchSector || matchLocation || p.description.toLowerCase().indexOf(input) >= 0 || p.subtitle.toLowerCase().indexOf(input) >= 0) {
                      return true;
                    }else {
                      return false;
                    }
                  });

                  if (results.length > 0) {
                    let count = results.length;
                    let resultCategoryHtml = '';
                    
                    if (!isOther) {
                      resultCategoryHtml += `<div class="category-item ${( isHighlight ? 'highlight' : '' )}">
                                              <div class="heading">
                                                <div class="heading-wrap cursor-hover">
                                                  <span class="result-counts">${count}</span><span> ${text['results_in']}</span><strong>${titleText}</strong>
                                                </div>
                                              `; //heading-wrap
                      if(results.length > 3){
                        resultCategoryHtml += `<div class="view-result-button cursor-link" data-result="${title}" id="moreLink${title}">
                                                <span>${text['view_all_in']}</span>${titleText}</div>`;
                      }
                      resultCategoryHtml += '</div>'; //heading
                      resultCategoryHtml += '<div class="items-wrapper">';
                    } else {
                      otherCounts += count;
                      if(!hasOtherHeader){
                        hasOtherHeader = true;
                        resultCategoryHtml += `<div class="category-item other-result ${( isHighlight ? 'highlight' : '' )}">
                                                <div class="heading">
                                                  <div class="heading-wrap cursor-hover">
                                                    <span id="otherCounts"></span>
                                                    <span> ${text['other_search_results']}</span>
                                                  </div>
                                                </div>
                                                <div class="items-wrapper">
                                              `;
                      }
                    }

                    $.each(results, function(j, result) {
                      let cursor = 'cursor-hover';
                      switch (title) {
                        case 'Work': cursor = result.cursor_icon; break;
                        case 'Views': cursor = 'cursor-view'; break;
                        case 'People':
                        case 'Jobs': cursor = 'cursor-staff'; break;
                        default: cursor = 'cursor-link'; break;
                      }

                      if(j == 3 && !isOther){
                        resultCategoryHtml += '</div>'; //items-wrapper
                        resultCategoryHtml += `<div id="moreResult${title}" class="items-wrapper more-result collasped" data-result="${title}" >`;
                      }
                      resultCategoryHtml += `<div class="result-item">
                                              <a class="" href="${result.link}" target="_blank">
                                            `;

                      if (isHighlight) {
                        resultCategoryHtml += '<div class="result-item-image-wrapper">';
                        if (result.image.length > 0) {
                          resultCategoryHtml += `<img src="${result.image}" class="cursor-view ${cursor}">`;
                        }
                        resultCategoryHtml += '</div>'; //result-item-image-wrapper
                      }

                      if (result.title.length > 0) {
                        resultCategoryHtml += `<div class="result-item-title cursor-link">${result.title}</div>`;
                      }

                      if (result.subtitle.length > 0) {
                        resultCategoryHtml += `<div class="result-item-subtitle cursor-link">${result.subtitle}</div>`;
                      }

                      if (result.description.length > 0) {
                        resultCategoryHtml += `<div class="result-item-description cursor-link">${result.description}</div>`;
                      }

                      resultCategoryHtml += '</a>'; //result.link
                      resultCategoryHtml += '</div>'; //result-item

                      if(results.length > 3 && j+1 == results.length && !isOther){
                        resultCategoryHtml += '</div>'; //more-result
                      }
                    });

                    if(!isOther || (isOther && i+1 == resultsWrapperFeed.length)){
                      resultCategoryHtml += '</div>'; //items-wrapper
                      if(!isOther && results.length > 3){
                        resultCategoryHtml += `<div class="view-result-button mobile-link" data-result="${title}" id="moreLinkMobile${title}">
                                                <span>${text['view_all_in']}</span>${titleText}</div>`;
                      }
                      resultCategoryHtml += '</div>'; //category-item
                    }

                    resultsHtml += resultCategoryHtml;
                  }
                });
                
                if (resultsHtml.length === 0) {
                  resultsHtml = `<div class="heading cursor-hover">0 ${text['results']}</div>`;
                }

                resultsWrapper.html(resultsHtml);
                $('#otherCounts').text(otherCounts);
                cursor.finalize();
              }
            }
          }, 1000);
        } else {
          searchModal.addClass('autocomplete-data-loading');
        }
      });
    }
    
    $(document).on('click', '.view-result-button', function(e) {
      const result = $(this).data('result');
      $('#moreResult'+result).removeClass('collasped');
      $('#moreLink'+result).addClass('clicked');
      $('#moreLinkMobile'+result).addClass('clicked');
    });
  },
};
