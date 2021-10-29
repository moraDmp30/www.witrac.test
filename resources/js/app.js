require('./bootstrap');

import Alpine from 'alpinejs';
import Swal from 'sweetalert2'

window.Alpine = Alpine;
 
Alpine.store('commands', {
    run(button, commandId) {
        if (button.classList.contains('disabled')) {
            return false;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to stop this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, run command!'
        }).then((result) => {
            if (result.isConfirmed) {
                button.classList.add('disabled');
                button.innerHtml = 'Running..';
                Livewire.emit('run-command');
            }
        });
    }
});

Alpine.start();