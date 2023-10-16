import './bootstrap';

import Alpine from 'alpinejs';

// import { Chart } from 'chart.js';
window.Alpine = Alpine;

Alpine.start();

// import '@fortawesome/fontawesome-free/css/all.min.css'


import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    timer: 5000,
    timerProgressBar: true
})




window.Toast = Toast




// window.Chart = Chart;
