import React, { Component, Fragment } from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import axios from 'axios';
import qs from 'qs';
import linkedinLogo from '../../../images/socials/linkedin-black.svg';
import arrowRight from '../../../images/icons/arrow-right-black.svg';
import { findIndex, isNil } from 'lodash';
import cursor from './cursor';
import bodyScroll from './bodyScroll';

class People extends Component {
  constructor(props) {
    super(props);

    // Initial state
    this.initialState = {
      loading: true,
      content: '',
      image: '',
      linkedIn: '',
      location: '',
      name: '',
      position: '',
      workingSince: '',
      currentId: props.peopleId,
      i18n: '',
    };

    // Bind "this"
    this.fetchContent = this.fetchContent.bind(this);
    this.getPrevNextIds = this.getPrevNextIds.bind(this);

    const { previousId, nextId } = this.getPrevNextIds(props.peopleId);
    this.initialState.previousId = previousId;
    this.initialState.nextId = nextId;

    // Cancel token source
    this.source = axios.CancelToken.source();

    // Assign first state
    this.state = Object.assign({}, this.initialState);
  }

  componentDidMount() {
    this.fetchContent(this.props.peopleId);
  }

  componentDidUpdate(prevProps) {
    if (prevProps.peopleId !== this.props.peopleId) {
      this.fetchContent(this.props.peopleId);
    }
    if(!this.state.loading){
      $('.people-modal .details').addClass('loaded');
    }else{
      $('.people-modal .details').removeClass('loaded');
    }
    cursor.finalize();
  }

  fetchContent(peopleId) {
    this.setState({
      loading: true,
      content: '',
      image: '',
      linkedIn: '',
      location: '',
      name: '',
      position: '',
      workingSince: '',
      url: '',
      i18n: '',
    });

    // Params
    const data = {
      'action': 'get_people_content',
      'people_id': peopleId,
    };

    // Send request
    axios.post(window.SR['ajaxUrl'], qs.stringify(data), {
      cancelToken: this.source.token,
    }).then((response) => {
      const {
        content,
        image,
        linked_in: linkedIn,
        location,
        name,
        position,
        working_since: workingSince,
        url: url,
        i18n,
      } = response.data.data;

      const { previousId, nextId } = this.getPrevNextIds(peopleId);

      this.setState({
        loading: false,
        content,
        image,
        linkedIn,
        location,
        name,
        position,
        workingSince,
        url,
        currentId: peopleId,
        previousId,
        nextId,
        i18n,
      });
    }).catch((error) => {
      console.error(error);
    });
  }

  getPrevNextIds(currentId) {
    const { team } = this.props;

    const idx = findIndex(team, (person) => Number(person.id) === Number(currentId));

    let previousId = null;
    let nextId = null;

    if (idx !== 0) {
      previousId = team[idx - 1].id;
    }

    if (idx !== team.length - 1) {
      nextId = team[idx + 1].id;
    }

    return {
      previousId,
      nextId,
    };
  }

  render() {
    const {
      content,
      image,
      linkedIn,
      location,
      name,
      position,
      workingSince,
      url,
      previousId,
      nextId,
      loading,
      i18n,
    } = this.state;

    let lang = '/' + $('html').data('lang');
    lang = lang !== '/en' ? '/' + $('html').data('lang') : '';
    window.history.pushState('', url, lang + '/people/' + url);

    return (
      <Fragment>
        <div className="people-info-wrapper">
          <div className="work-info">
            <p className="location">
              { location }
            </p>
            <p className="since">
              { workingSince }
            </p>
          </div>
        </div>

        <div className="people-content-wrapper">
          <div className="image-wrapper">
            {
              image && <img src={image} alt="people" />
            }
          </div>

          <div className="text-wrapper">
            <div className="name">
              { name }
            </div>

            <div className="title">
              { position }
            </div>

            <div className="description" dangerouslySetInnerHTML={{__html: content}}></div>

            { linkedIn && (
              <div className="link desktop">
                <span className="logo cursor-link">
                  <img src={linkedinLogo} />
                </span>
                <a href={linkedIn} className="linkedin cursor-link" target="_blank" rel="noreferrer">
                  { i18n['add_linkedin'] }
                </a>
              </div>
            )}
          </div>
        </div>

        <div className="people-footer-wrapper">
        { linkedIn && (
          <div className="link mobile">
            <span className="logo">
              <img src={linkedinLogo} />
            </span>
            <a href={linkedIn} className="linkedin" target="_blank" rel="noreferrer">
            { i18n['add_linkedin'] }
            </a>
          </div>
        ) }
          <div className="nav">
          { !isNil(previousId) && (
            <a className="arrow prev cursor-link" onClick={() => isNil(previousId) || loading? null : this.fetchContent(previousId)}>
              <img src={arrowRight} />
            </a>
          )}
          { !isNil(nextId) && (
            <a className="arrow next cursor-link" onClick={() => isNil(nextId) || loading? null : this.fetchContent(nextId)}>
              <img src={arrowRight} />
            </a>
          )}
          </div>
        </div>
      </Fragment>
    );
  }
}

People.propTypes = {
  peopleId: PropTypes.number,
  team: PropTypes.array,
};

export default {
  init() {
  },
  finalize() {
    // People modal
    let lang = '/' + $('html').data('lang');
    lang = lang !== '/en' ? '/' + $('html').data('lang') : '';
    const peopleModal = $('.people-modal');
    if (peopleModal.length && $('body').hasClass('template-about') ) {
      //let teamMembers = $('.team-members-grid').data('team-members');
      let teamMembers =  $('.team-members-grid').map(function() {
        return $(this).data('team-members');
      }).get();

      teamMembers = teamMembers.filter((member) => member.content !== 0);

      $(document).on('click', '.people-modal-trigger', function(e) {
        e.preventDefault();
        if(!$(this).hasClass('disabled')){
          const link = $(this);
          const peopleId = parseInt(link.data('id'));
          const contentWrapper = $('.people-modal .details');
          ReactDOM.render(<People peopleId={peopleId} team={teamMembers} />, contentWrapper[0]);
        }
      });
    }

    $(document).on('click', '.right-side-modal.people-modal .modal-content .modal-close', function() {
      window.history.pushState('', '', lang + '/about/');
    });

    $(document).on('click', '.right-side-modal.people-modal .modal-overlay', function() {
      window.history.pushState('', '', lang + '/about/');
    });
  },
};
