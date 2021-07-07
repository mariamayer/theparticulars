// for ie
import 'babel-polyfill';
// foundation zurb js
import 'bootstrap'

// data interchange from foundation
import './modules/interchange';

// owl
import 'owl.carousel';

window.bsBreakpoints = require('bs-breakpoints');

// sticky
require("waypoints/lib/jquery.waypoints.js");
require("waypoints/lib/shortcuts/sticky.js");

// jquery cookie
// import 'js-cookie';
// window.fancySquareCookies = require('js-cookie');

// images loaded
// enque on pages if needed
// masonry
// enque on pages if needed

// axios
window.axios = require('axios');

// pages
import './pages.js'
