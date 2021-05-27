require('./bootstrap');

import Vue from 'vue'
window.Vue = Vue;

let axios = require('axios');
window.axios = axios;

require('./components/purchase.js');
require('./components/edit-purchase.js');
require('./components/sales.js');
require('./components/edit-sales.js');
require('./components/sales-report.js');
require('./components/purchase-report.js');
