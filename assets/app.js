/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// require('./base/base');
// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

require('./base/base');
require('./includes/veltrix_v2/js/bootstrap.bundle.min');
require('./includes/veltrix_v2/js/metismenu.min');
require('./includes/veltrix_v2/js/jquery.slimscroll');
require('./includes/veltrix_v2/js/waves.min');

require('./includes/veltrix_v2/js/app');

// stylesheet
require('./includes/veltrix_v2/css/bootstrap.min.css');
require('./includes/veltrix_v2/css/metismenu.min.css');
require('./includes/veltrix_v2/css/icons.css');
require('./includes/veltrix_v2/css/style.css');



