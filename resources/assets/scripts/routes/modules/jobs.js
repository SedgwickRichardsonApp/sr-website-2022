import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import axios from 'axios';
import qs from 'qs';
import cursor from './cursor';
import bodyScroll from './bodyScroll';

const JobsSkeleton = () => {
  return (
    <div className="job-details-wrapper skeleton">
      <div className="job-meta-wrapper skeleton"></div>
      <div className="job-content-wrapper skeleton">
        <div className="job-title skeleton-shine" />
        <div className="job-description skeleton-shine" />
      </div>
    </div>
  );
};


class Jobs extends Component {
  constructor(props) {
    super(props);

    // Initial state
    this.initialState = {
      loading : true,
      jobTitle: '',
      location: '',
      workType: '',
      url: '',
      date    : '',
      content : '',
      jobsId  : props.jobsId,
      contactDescription: '',
      jobContactEmail: '',
    };

    // Bind "this"
    this.fetchContent = this.fetchContent.bind(this);

    // Cancel token source
    this.source = axios.CancelToken.source();

    // Assign first state
    this.state = Object.assign({}, this.initialState);
  }

  componentDidMount() {
    this.fetchContent(this.props.jobsId);
  }

  componentDidUpdate(prevProps) {
    if (prevProps.jobsId !== this.props.jobsId) {
      this.fetchContent(this.props.jobsId);
    }
    if(!this.state.loading){
      $('.jobs-modal .modal-body').addClass('loaded');
    }else{
      $('.jobs-modal .modal-body').removeClass('loaded');
    }
    cursor.finalize();
  }

  fetchContent(jobsId) {
    this.setState({
      loading : true,
      jobTitle: '',
      location: '',
      workType: '',
      url: '',
      date    : '',
      content : '',
      contactDescription: '',
      jobContactEmail: '',
    });

    const modalTitle = $('.jobs-modal-title .title');

    // Params
    const data = {
      'action'  : 'get_job_details',
      'jobs_id' : jobsId,
    };

    // Send request
    axios.post(window.SR['ajaxUrl'], qs.stringify(data), {
      cancelToken: this.source.token,
    }).then((axiosResponse) => {
      if (200 === axiosResponse.status) {
        const response = axiosResponse.data;

        if (response.success) {
          const {
            jobTitle,
            location,
            workType,
            url,
            date,
            content,
            contactDescription,
            jobContactEmail,
            i18n,
          } = response.data;

          this.setState({
            loading: false,
            jobTitle,
            location,
            workType,
            url,
            date,
            content,
            contactDescription,
            jobContactEmail,
            i18n,
          });
        }
      }
    }).catch((error) => {
      console.error(error);
    });
  }

  render() {
    const {
      loading,
      jobTitle,
      location,
      workType,
      url,
      date,
      content,
      contactDescription,
      jobContactEmail,
      i18n,
    } = this.state;

    let lang = '/' + $('html').data('lang');
    lang = lang !== '/en' ? '/' + $('html').data('lang') : '';
    window.history.pushState('', url, lang + '/jobs/' + url);

    return (
      <Fragment>
        {
          !loading && (
            <div className="job-details-wrapper">
              <div className="job-meta-wrapper">
                <div className="job-meta">
                  <div className="job-location">{ location }</div>
                  <div className="job-work-type">{ workType }</div>
                  <div className="job-date">{ i18n['pub_date'] } { date }</div>
                </div>
              </div>
              <div className="job-content-wrapper">
                <h1 className="page-subtitle">{ i18n['work_with_us'] }</h1>
                <h1 className="page-title">{ jobTitle }</h1>
                <div className="content" dangerouslySetInnerHTML={{__html: content}}></div>

                <div className="contact-wrapper">
                  <div className="contact-description" >{ contactDescription }</div>
                  <div className="email-container">
                    <span className="email cursor-copy-email element-desktop" data-text={ jobContactEmail }>
                      { jobContactEmail }
                    </span>
                    <a className="email cursor-copy-email element-mobile" href={'mailto:' + jobContactEmail }>
                      { jobContactEmail }
                    </a>
                  </div>
                </div>
              </div>
            </div>
          )
        }
        {
          loading && (
            <JobsSkeleton />
          )
        }
      </Fragment>
    );
  }
}

Jobs.propTypes = {
  jobsId: PropTypes.number,
};

export default {
  init() {
  },
  finalize() {
    // Jobs modal
    let lang = $('html').data('lang');
    lang = lang !== '/en' ? '/' + $('html').data('lang') : '';

    const jobsModal = $('.jobs-modal');
    if (jobsModal.length) {
      $(document).on('click', '.jobs-modal-trigger', function(e) {
        e.preventDefault();


        const jobsId = parseInt( $(this).data('id') );
        const jobTitle = $(this).data('job-title');
        const location = $(this).data('location');
        const jobText = $(this).data('job-text');

        const jobsWrapper = $('.jobs-modal').find('.details');

        $('.jobs-modal-title .title').text(jobTitle + ' ' + jobText + ' ' + location);
        ReactDOM.render(<Jobs jobsId={jobsId} jobTitle={jobTitle} location={location} />, jobsWrapper[0]);
      });
    }

    $(document).on('click', '.right-side-modal.jobs-modal .modal-content .modal-close', function() {
      window.history.pushState('', '', lang + '/careers/');
    });

    $(document).on('click', '.right-side-modal.jobs-modal .modal-overlay', function() {
      window.history.pushState('', '', lang + '/careers/');
    });
  },
};
