import Swal from 'sweetalert2'
import { getColor } from './style'

export const confirm = (action, {
  title = 'Are you sure?',
  ...options
} = {}) => Swal.fire({
  title,
  showCancelButton: true,
  reverseButtons: true,
  confirmButtonText: 'Yes',
  cancelButtonText: 'No',
  icon: 'warning',
  confirmButtonColor: getColor('bs-danger'),
  showLoaderOnConfirm: true,
  allowOutsideClick: false,
  preConfirm: action,
  ...options
})

export const notify = (message, success, options = {}) => Toast.fire({
  text: message,
  icon: success ? 'success' : 'error',
  title: 'Notification',
  ...options,
})

export const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3500,
  didOpen: toast => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  },
})
