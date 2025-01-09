import './bootstrap';

import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    timer: 5000,
    timerProgressBar: true
})

window.Toast = Toast
