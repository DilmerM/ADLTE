@extends('admin.app')

@section('title', 'Dashboard de Aventura')
@section('page-title', 'Dashboard de Aventura')

{{-- 1. ESTILOS CSS PARA TODOS LOS COMPONENTES --}}
@push('styles')
<style>
    /* Estilos generales y fuentes */
    .dashboard-font { font-family: 'SF Mono', 'Fira Code', 'Fira Mono', 'Roboto Mono', monospace; }
    .sans-serif-font { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; }

    /* --- ESTILOS PARA LA TERMINAL --- */
    .terminal-window {
        background-color: #282c34; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%; border: 1px solid #4a4a4a; height: 100%; display: flex; flex-direction: column;
    }
    .terminal-header {
        background-color: #e0e0e0; padding: 8px 12px; border-top-left-radius: 10px;
        border-top-right-radius: 10px; display: flex; align-items: center; border-bottom: 1px solid #c0c0c0;
    }
    .dot { height: 12px; width: 12px; border-radius: 50%; margin-right: 8px; }
    .dot.red { background-color: #ff5f56; }
    .dot.yellow { background-color: #ffbd2e; }
    .dot.green { background-color: #27c93f; }
    .terminal-body { padding: 1.5rem; color: #dcdcdc; font-size: 0.9rem; flex-grow: 1; }
    .terminal-body p { margin-bottom: 0.6em; }
    .terminal-animated-line { opacity: 0; transform: translateY(15px); transition: opacity 0.5s ease-out, transform 0.5s ease-out; }
    .terminal-animated-line.visible { opacity: 1; transform: translateY(0); }
    .activity-module { color: #33d9ff; }
    .call-to-action { font-weight: bold; color: #ffc107; }
    .typing-effect { display: inline-block; white-space: pre-wrap; word-break: break-word; overflow: hidden; border-right: .15em solid #00ff7f; animation: blink-caret .8s step-end infinite; }
    @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: #00ff7f; } }

    /* --- ESTILOS PARA BOX REVEAL --- */
    .box-reveal-container {
        background-color: #fff; border-radius: 10px; padding: 2.5rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        width: 100%; height: 100%; color: #333;
    }
    .box-reveal-wrapper { position: relative; opacity: 0; }
    .box-reveal-wrapper.is-visible { opacity: 1; }
    .box-reveal-wrapper::after {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: #2e8b57; /* Verde bosque */
        transform-origin: right;
    }
    .box-reveal-wrapper.is-visible::after {
        animation: reveal-box 0.8s cubic-bezier(0.65, 0, 0.35, 1) forwards;
    }
    .box-reveal-wrapper .box-content { opacity: 0; }
    .box-reveal-wrapper.is-visible .box-content { animation: fade-in 0.5s 0.4s forwards; }
    @keyframes reveal-box {
        0% { transform: scaleX(1); transform-origin: left; }
        50% { transform: scaleX(1); transform-origin: left; }
        100% { transform: scaleX(0); transform-origin: right; }
    }
    @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
    .highlight-green { color: #2e8b57; font-weight: 600; }
    .btn-explore {
        background-color: #2e8b57; color: white; font-weight: bold; padding: 0.8rem 1.5rem;
        border-radius: 8px; transition: background-color 0.3s, transform 0.3s;
    }
    .btn-explore:hover { background-color: #256d44; transform: translateY(-2px); }

    /* --- ESTILOS PARA LA GALERÍA DE IMÁGENES --- */
    .gallery-section { background-color: #f8f9fa; border-top: 1px solid #e9ecef; }
    .masonry-grid {
        column-count: 3; /* 3 columnas en pantallas grandes */
        column-gap: 1.5rem;
    }
    @media (max-width: 992px) { .masonry-grid { column-count: 2; } } /* 2 columnas en tablets */
    @media (max-width: 768px) { .masonry-grid { column-count: 1; } } /* 1 columna en móviles */

    .blur-fade-item {
        margin-bottom: 1.5rem; break-inside: avoid; opacity: 0;
        filter: blur(8px); transform: scale(0.9); transition: all 0.8s ease-in-out;
    }
    .blur-fade-item.is-visible { opacity: 1; filter: blur(0px); transform: scale(1); }
    .blur-fade-item img { width: 100%; height: auto; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
</style>
@endpush


{{-- 2. CONTENIDO HTML COMPLETO --}}
@section('content')
<div class="container-fluid py-3">
    {{-- FILA SUPERIOR: CONTIENE LOS DOS PANELES PRINCIPALES --}}
    <div class="row">
        {{-- COLUMNA IZQUIERDA: TARJETA DE BIENVENIDA (BOX REVEAL) --}}
        <div class="col-lg-6 mb-4 mb-lg-0 d-flex flex-column">
            <div class="box-reveal-container sans-serif-font">
                <div class="box-reveal-wrapper">
                    <h1 class="box-content display-4 fw-bold">Parques Forestales<span class="highlight-green">.</span></h1>
                </div>
                <div class="box-reveal-wrapper">
                    <h2 class="box-content h4 mt-3">El Pulmón de <span class="highlight-green">Honduras</span></h2>
                </div>
                <div class="box-reveal-wrapper">
                    <p class="box-content mt-4 fs-5">
                        → ¿Sabías que un parque forestal es el escenario perfecto para crear recuerdos inolvidables? Es un tesoro natural ideal para reconectar con la <span class="highlight-green">familia</span>, reír con los <span class="highlight-green">amigos</span> y encontrar tu propia <span class="highlight-green">paz</span>.
                    </p>
                </div>
                <div class="box-reveal-wrapper">
                    <div class="box-content mt-5">
                         {{-- Este botón ahora tiene un ID para el scroll suave --}}
                         <a href="#gallery-section" id="discover-button" class="btn btn-explore">Descubre tu Aventura</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: TERMINAL ANIMADA --}}
        <div class="col-lg-6 d-flex flex-column">
            <div class="terminal-window dashboard-font">
                <div class="terminal-header">
                    <div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div>
                </div>
                <div class="terminal-body">
                    <p id="command-line" class="text-white"></p>
                    <p class="terminal-animated-line text-success"><span>✔ Iniciando protocolo de bienvenida...</span></p>
                    <p class="terminal-animated-line text-success"><span>✔ Sincronizando con el ritmo de la naturaleza...</span></p>
                    <p class="terminal-animated-line text-success"><span>✔ Cargando mapa de senderos...</span></p>
                    <p class="terminal-animated-line text-success"><span>✔ Conexión establecida.</span></p>
                    <p id="welcome-message-1" class="mt-4"></p>
                    <p id="activity-header" class="text-white"></p>
                    <p class="terminal-animated-line activity-module"><span>> Senderismo y Exploración</span></p>
                    <p class="terminal-animated-line activity-module"><span>> Avistamiento de Aves</span></p>
                    <p class="terminal-animated-line activity-module"><span>> Fotografía de Paisajes</span></p>
                    <p class="terminal-animated-line activity-module"><span>> Zonas de Picnic Familiar</span></p>
                    <p id="call-to-action" class="call-to-action mt-4"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SECCIÓN INFERIOR: GALERÍA DE IMÁGENES --}}
<section id="gallery-section" class="gallery-section py-5 mt-4">
    <div class="container-fluid">
        <h2 class="text-center fw-bold mb-5 sans-serif-font">Galería de Aventuras</h2>
        <div class="masonry-grid">
            @php
                $images = [
                    'https://images.pexels.com/photos/167699/pexels-photo-167699.jpeg?auto=compress&cs=tinysrgb&w=800',
                    'https://images.pexels.com/photos/38136/pexels-photo-38136.jpeg?auto=compress&cs=tinysrgb&w=600&h=800',
                    'https://images.pexels.com/photos/302804/pexels-photo-302804.jpeg?auto=compress&cs=tinysrgb&w=800',
                    'https://images.pexels.com/photos/2356045/pexels-photo-2356045.jpeg?auto=compress&cs=tinysrgb&w=600&h=800',
                    'https://images.pexels.com/photos/2662116/pexels-photo-2662116.jpeg?auto=compress&cs=tinysrgb&w=800',
                    'https://images.pexels.com/photos/775201/pexels-photo-775201.jpeg?auto=compress&cs=tinysrgb&w=600&h=800',
                    'https://images.pexels.com/photos/142497/pexels-photo-142497.jpeg?auto=compress&cs=tinysrgb&w=800',
                    'https://images.pexels.com/photos/3408744/pexels-photo-3408744.jpeg?auto=compress&cs=tinysrgb&w=600&h=800',
                    'https://images.pexels.com/photos/417074/pexels-photo-417074.jpeg?auto=compress&cs=tinysrgb&w=800',
                ];
            @endphp
            @foreach ($images as $imageUrl)
                <div class="blur-fade-item">
                    <img src="{{ $imageUrl }}" alt="Imagen de un parque forestal o naturaleza">
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection


{{-- 3. SCRIPTS JAVASCRIPT COMPLETOS --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA PARA LA TERMINAL ANIMADA ---
    function runTerminalAnimation() {
        function typeWriter(elementId, text, initialDelay = 0, onComplete = () => {}) {
            setTimeout(() => {
                const element = document.getElementById(elementId);
                if (!element) return;
                element.classList.add('typing-effect'); let i = 0; const speed = 50;
                function type() {
                    if (i < text.length) { element.innerHTML += text.charAt(i); i++; setTimeout(type, speed); }
                    else { element.style.borderRight = 'none'; element.classList.remove('typing-effect'); onComplete(); }
                }
                type();
            }, initialDelay);
        }
        function animateTerminalLines() {
            const lines = document.querySelectorAll('.terminal-animated-line');
            let delay = 1000; const interval = 300;
            lines.forEach(line => { setTimeout(() => { line.classList.add('visible'); }, delay); delay += interval; });
            const finalDelay = delay;
            typeWriter('welcome-message-1', '¡Bienvenido(a) a nuestro santuario digital!', finalDelay, () => {
                typeWriter('activity-header', 'Prepárate. Actividades disponibles:', 100, () => {
                    typeWriter('call-to-action', 'Elige tu camino y... ¡deja que la naturaleza te sorprenda!', 2500);
                });
            });
        }
        typeWriter('command-line', '> establecer_conexion(parques_forestales);', 500, animateTerminalLines);
    }
    
    // --- LÓGICA PARA LA TARJETA CON REVELADO (BOX REVEAL) ---
    function runBoxRevealAnimation() {
        const revealElements = document.querySelectorAll(".box-reveal-wrapper");
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${index * 0.25}s`;
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        revealElements.forEach(el => { observer.observe(el); });
    }

    // --- LÓGICA PARA LA GALERÍA Y EL SCROLL SUAVE ---
    function runGalleryAndScroll() {
        const discoverButton = document.getElementById('discover-button');
        if (discoverButton) {
            discoverButton.addEventListener('click', function(event) {
                event.preventDefault();
                const targetSection = document.getElementById('gallery-section');
                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }
        const galleryItems = document.querySelectorAll(".blur-fade-item");
        if(galleryItems.length > 0) {
            const galleryObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        galleryObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            galleryItems.forEach((item, index) => {
                item.style.transitionDelay = `${index * 0.07}s`;
                galleryObserver.observe(item);
            });
        }
    }

    // ---- INICIO DE TODAS LAS FUNCIONES ----
    runTerminalAnimation();
    setTimeout(runBoxRevealAnimation, 1000); // Retraso de 3 segundos para la tarjeta
    runGalleryAndScroll();

});
</script>
@endpush