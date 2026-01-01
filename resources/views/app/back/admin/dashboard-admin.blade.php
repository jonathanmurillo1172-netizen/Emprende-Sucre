@extends('layouts.template-back')

@section('scripts')

@section('scrip-final')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/alerta-logout-admin.js') }}"></script>
    @if (session('swal_success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Operación Exitosa!',
                text: "{{ session('swal_success') }}",
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif
    @if (session('swal_login'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Bienvenido!',
                text: "{{ session('swal_login') }}",
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4f46e5'
            });
        </script>
    @endif
@endsection
