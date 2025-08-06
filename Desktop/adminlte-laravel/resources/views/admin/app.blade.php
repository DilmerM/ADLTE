{{-- En resources/views/layouts/app.blade.php (o tu vista principal) --}}

@extends('adminlte::page')

@section('title', $title ?? 'Dashboard')

@section('content_header')
    <h1>@yield('page-title', 'Admin Panel')</h1>
@stop

@section('content')
    {{-- El contenido dinámico de tus otras páginas (dashboard, perfil, etc.) irá aquí --}}
    @yield('content')
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
    @stack('styles')
@stop


{{-- ================================================================== --}}
{{-- SECCIÓN DE JAVASCRIPT PRINCIPAL --}}
{{-- ================================================================== --}}
@section('js')

    {{-- 1. Dependencias globales (disponibles para todas las páginas) --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- 2. Script global para funciones de la plantilla (icono de navbar, logout) --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- LÓGICA PARA MOSTRAR ICONO DE PERFIL EN NAVBAR ---
        try {
            const userData = JSON.parse(localStorage.getItem('userData'));
            const rightNavbar = document.querySelector('.navbar-nav.ml-auto');
            
            if (rightNavbar && userData && userData.ruta_foto_perfil) {
                if (!document.getElementById('navbarProfileIcon')) {
                    const listItem = document.createElement('li');
                    listItem.classList.add('nav-item');
                    
                    const img = document.createElement('img');
                    img.id = 'navbarProfileIcon';
                    img.src = `{{ url('/') }}/${userData.ruta_foto_perfil}`;
                    img.classList.add('img-circle');
                    img.style.cssText = 'width: 28px; height: 28px; margin-top: 5px; margin-right: 15px; border: 1px solid #6c757d;';
                    
                    listItem.appendChild(img);
                    rightNavbar.prepend(listItem);
                }
            }
        } catch(e) {
            console.log("No se pudo crear el icono de perfil (puede que el usuario no haya iniciado sesión).");
        }

        // --- LÓGICA PARA EL BOTÓN DE CERRAR SESIÓN ---
        // AdminLTE usualmente añade un botón de logout, pero si tienes uno personalizado con el id 'logout-button', esto funcionará.
        const logoutButton = document.getElementById('logout-button');
        if (logoutButton) {
            logoutButton.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?', text: "¿Quieres cerrar la sesión actual?", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, ¡cerrar sesión!', cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem('authToken');
                        localStorage.removeItem('userData');
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        }
    });
    </script>

    {{-- 3. Aquí se inyectarán los scripts de las páginas hijas (como perfil.blade.php) --}}
    @stack('scripts') 
@stop