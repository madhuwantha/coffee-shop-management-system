

require('../base/base');

require('../includes/veltrix_v2/plugins/select2/js/select2.min');
const Swal = require('../includes/veltrix_v2/plugins/sweet-alert2/sweetalert2.min');
global.Swal = Swal;

// stylesheet
require('../includes/veltrix_v2/plugins/select2/css/select2.min.css');
require('../includes/veltrix_v2/plugins/sweet-alert2/sweetalert2.min.css');

// require('../includes/veltrix_v2/pages/form-advanced.init.js');
require('./createController');