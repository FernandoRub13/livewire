import Swal from 'sweetalert2';

Livewire.on('alert', (type, title, text) => {
  Swal.fire({
    title: title,
    text: text,
    icon: type,
    confirmButtonText: 'Cerrar'
  })
});