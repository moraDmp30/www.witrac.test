import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
 
Alpine.store('toast', {
    openAlertBox: false,
    alertBackgroundColor: '',
    alertMessage: '',
    successIcon: '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    infoIcon: '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    warningIcon: '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    dangerIcon: '<svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 mr-2 text-white"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>',
    showAlert(type, message) {
        switch (type) {
            case 'success':
                this.alertBackgroundColor = 'bg-green-500'
                this.alertMessage = `${this.successIcon} ${message}`;
                break
            case 'info':
                this.alertBackgroundColor = 'bg-blue-500'
                this.alertMessage = `${this.infoIcon} ${message}`
                break
            case 'warning':
                this.alertBackgroundColor = 'bg-yellow-500'
                this.alertMessage = `${this.warningIcon} ${message}`
                break
            case 'danger':
                this.alertBackgroundColor = 'bg-red-500'
                this.alertMessage = `${this.dangerIcon} ${message}`
                break
        }
        this.openAlert();
    },
    openAlert() {
        this.openAlertBox = true;
    },
    closeAlert() {
        this.openAlertBox = false;
    },
    isAlertOpen() {
        return this.openAlertBox;
    }
});

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
                const svg = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">'+
                    '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                    '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>'+
                    '</svg>';
                button.classList.add('disabled');
                button.innerHTML = svg+' Running...';

                axios.post('/run-command/'+commandId)
                .then(function (response) {
                    Alpine.store('toast').showAlert('info', 'Command #'+commandId+' is running...');
                })
                .catch(function (error) {
                    button.classList.remove('disabled');
                    button.innerHTML = 'Run';
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                });  
            }
        });
    }
});

Alpine.start();
