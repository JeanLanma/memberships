const successAlert = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#0ea5e9',
    })
}

const errorAlert = (title, text) => {
    Swal.fire({
        title: title,
        text: text,
        icon: 'error',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#0ea5e9',
    })
}

const Alert = (title, text) => {

    Swal.fire({
        title: title,
        text: text,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#0ea5e9',
    })


}

const useAlert = (title, message, type = null) => {

    const alerts = {
        'success': successAlert,
        'error': errorAlert
    }

    return alerts[type](title, message) ?? Alert(title, message);

}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'white',
    customClass: {
      popup: 'colored-toast'
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
})

const successToast = async (title) => {
    return await Toast.fire({
        icon: 'success',
        title: title
    })
}