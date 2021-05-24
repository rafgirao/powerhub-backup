function alert() {
    swal.fire({
        title: 'Auto close alert!',
        text: 'I will close in 2 seconds.',
        timer: 2000,
        showCancelButton: false,
        showConfirmButton: false
    }).then(
        function () {
        },
        // handling the promise rejection
        function (dismiss) {
            if (dismiss === 'timer') {
                //console.log('I was closed by the timer')
            }
        }
    )
}
