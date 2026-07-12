// import external dependencies
import 'jquery'

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import templateContact from './routes/templateContact';
import templateCareers from './routes/templateCareers';
import templateExpertise from './routes/templateExpertise';
import templateHomepage from './routes/templateHomepage';
import templateViews from './routes/templateViews';
import templateWork from './routes/templateWork';
import templatePrivacy from './routes/templatePrivacy';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Contact
  templateContact,
  //careers
  templateCareers,
  // Expertise
  templateExpertise,
  // Homepage
  templateHomepage,
  // Views,
  templateViews,
  // Work
  templateWork,
  // Privacy
  templatePrivacy,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
