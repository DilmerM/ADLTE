<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parques Forestales - Descubre la Naturaleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
<style>

/* --- ESTILOS PARA EL CARRUSEL DE COMENTARIOS --- */
.scroller-wrapper {
    overflow: hidden;
    -webkit-mask: linear-gradient(90deg, transparent, white 20%, white 80%, transparent);
    mask: linear-gradient(90deg, transparent, white 20%, white 80%, transparent);
}

.scroller-inner {
    display: flex;
    gap: 1rem; /* Espacio entre tarjetas */
    padding-block: 1rem;
    width: max-content; /* Asegura que el contenedor se ajuste al contenido */
    animation: scroll 30s linear infinite;
}

.scroller-wrapper:hover .scroller-inner {
    animation-play-state: paused; /* Pausa la animación al pasar el ratón */
}

@keyframes scroll {
    to {
        transform: translateX(calc(-50% - 0.5rem)); /* Mueve la mitad del contenedor */
    }
}

.comment-card {
    width: 350px; /* Ancho fijo para cada tarjeta */
    flex-shrink: 0; /* Evita que las tarjetas se encojan */
}

.comment-card .card-body {
    display: flex;
    flex-direction: column;
}

.comment-card .card-text {
    flex-grow: 1; /* Ocupa el espacio disponible */
    font-style: italic;
}

.comment-author {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
}

.comment-author img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}
    /* Sección del Héroe (Parallax) */
.hero-section {
    position: relative; /* Contenedor para las capas absolutas */
    height: 100vh; /* Ocupa toda la altura de la pantalla */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Oculta las partes de las imágenes que se salen */
    color: white;
}
.dic{
     position: relative; /* Contenedor para las capas absolutas */
    height: 100vh; /* Ocupa toda la altura de la pantalla */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Oculta las partes de las imágenes que se salen */
    color: white;
    background-color: rgb(250, 243, 208);
}
.parallax-layer {
  
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Asegura que la imagen cubra todo el contenedor */
    object-position: bottom; /* Alinea la imagen en la parte inferior de su caja */
    
    /* AÑADIDO: Transición suave para la animación de entrada */
    transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
/* Asignamos un z-index diferente a cada capa para el orden correcto */
.parallax-layer:nth-of-type(1) { z-index: -7; } /* fondo */

.parallax-layer:nth-of-type(1) { z-index: -6; } /* fondo */

.parallax-layer:nth-of-type(1) { z-index: -5; } /* Capa Cielo (más lejana) */
.parallax-layer:nth-of-type(2) { z-index: -4; } /* Montaña Lejos */
.parallax-layer:nth-of-type(3) { z-index: -3; } /* Montaña cerca */
.parallax-layer:nth-of-type(4) { z-index: -2;  } /* Capa agua */
.parallax-layer:nth-of-type(5) { z-index: -1; } /* Capa Tierra (más cercana) */
.parallax-layer.from-top {
  transform: translateY(-100%);
}

/* Esta regla busca la PRIMERA capa y le aplica el z-index */
.parallax-layer:nth-of-type(1) { 
  z-index: -6; 
}

.hero-content {
    position: relative; /* Para que esté por encima de las capas parallax */
    z-index: 1;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7); /* Sombra para que el texto sea legible */
}

/* --- INICIO: Transiciones de Entrada (Controladas por JS) --- */

/* Posiciones iniciales de las capas (fuera de la pantalla) */
.parallax-layer.from-left {
  transform: translateX(-100%);
}
.parallax-layer.from-right {
  transform: translateX(100%);
}
.parallax-layer.from-top {
  transform: translateY(-100%);
}

/* Cuando JS añade la clase 'is-visible', las capas van a su posición final */
.parallax-layer.is-visible {
  transform: translate(0, 0);
}

/* --- FIN: Transiciones de Entrada --- */



/* --- ESTILOS PARA EL NUEVO FOOTER --- */
.main-footer {
    background-color: #212529; /* Un poco más oscuro que bg-dark */
    color: #adb5bd; /* Texto gris claro, más suave que el blanco puro */
    padding: 60px 0 20px 0;
    margin-top: 40px; /* Espacio para separarlo del contenido superior */
}

.footer-heading {
    color: #ffffff;
    margin-bottom: 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.footer-text {
    font-size: 0.9rem;
    line-height: 1.6;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #adb5bd;
    text-decoration: none;
    transition: all 0.3s ease;
}

.footer-links a:hover, .footer-links a:focus {
    color: #ffffff;
    padding-left: 5px; /* Pequeño efecto al pasar el ratón */
}

.main-footer .social-icons .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #495057;
    color: #ffffff;
    font-size: 1.2rem;
    margin-right: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.main-footer .social-icons .social-icon:hover {
    background-color: #198754; /* Color verde de éxito de Bootstrap */
    transform: translateY(-3px); /* Efecto de elevación */
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.footer-bottom {
    border-top: 1px solid #343a40;
    padding-top: 20px;
    margin-top: 40px;
    text-align: center;
    font-size: 0.85rem;
}

/* Alineación de iconos en la sección de contacto */
.main-footer .footer-text .iconify {
    vertical-align: middle;
    margin-right: 8px;
    font-size: 1.2rem;
}
 /* Estilos para Desktop */
    .hero-panels-container {
        display: flex;
        width: 100%;
        height: 100vh; 
        overflow: hidden;
        position: relative;
    }
    .hero-panel {
        background-size: cover;
        background-position: center;
        flex: 1;
        position: relative;
        cursor: pointer;
        transition: flex 0.7s cubic-bezier(0.61, .04, .36, .98);
    }
    .hero-panel:hover {
        flex: 5; 
    }
    .hero-panel h3 {
        font-size: 2rem;
        color: white;
        position: absolute;
        bottom: 20px;
        left: 20px;
        margin: 0;
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.5s ease, transform 0.5s ease;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
    }
    .hero-panel:hover h3 {
        opacity: 1;
        transform: translateY(0);
    }
    .hero-panel::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        transition: opacity 0.7s ease;
    }
    .hero-panel:hover::after {
        opacity: 0; 
    }
    .hero-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        color: white;
        text-align: center;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        width: 90%;
        max-width: 800px;
    }

    /* --- AJUSTES PARA MÓVIL --- */
    @media (max-width: 768px) {
        .hero-panels-container {
            /* Los paneles ahora son fijos y no hay scroll */
            flex-direction: column;
            height: 100vh;
            overflow: hidden; /* No hay scroll */
        }
        .hero-panel {
            flex: 1; /* Los 3 paneles visibles se reparten el espacio */
        }
        .hero-panel:hover {
            flex: 1; /* Se mantiene la desactivación de la expansión */
        }
        .hero-panel h3 {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Oculta el 4to y 5to panel en móvil */
        .hero-panel:nth-of-type(n+4) {
            display: none;
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }
        .hero-content h1 {
            font-size: 2.5rem;
        }
        .hero-content .lead {
            font-size: 1.2rem;
            margin-top: 1rem;
        }
    }

    .park-card {
        position: relative;
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        cursor: pointer;
        height: 400px;
    }

    .park-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .park-card .park-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .park-card:hover .park-card-img {
        transform: scale(1.1);
    }

    .park-card .park-card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2rem 1.5rem 1.5rem;
        color: white;
        background: linear-gradient(to top, rgba(0,0,0,0.95) 10%, rgba(0,0,0,0) 100%);
        /* La clave del efecto: El contenido está "escondido" debajo, mostrando solo el título */
        transform: translateY(calc(100% - 4.5rem)); 
        transition: transform 0.5s ease;
    }

    /* Al pasar el ratón, el contenido se desliza hacia arriba para mostrarse completo */
    .park-card:hover .park-card-content {
        transform: translateY(0);
    }

    .park-card .park-card-title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }

    /* El texto y el botón están ocultos por defecto */
    .park-card .park-card-text {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        opacity: 0;
        transition: opacity 0.5s ease 0.1s;
    }

    /* Se hacen visibles cuando la tarjeta está activa */
    .park-card:hover .park-card-text {
        opacity: 1;
    }

    .park-card .park-card-btn {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.5s ease 0.2s;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
    }

    /* Se hacen visibles cuando la tarjeta está activa */
    .park-card:hover .park-card-btn {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* --- RESPONSIVIDAD --- */
    /* En pantallas más pequeñas (tablet/móvil), el efecto hover no es ideal. */
    /* Por eso, hacemos que el contenido sea visible por defecto. */
    @media (max-width: 992px) {
        .park-card .park-card-content {
            transform: translateY(0);
        }
        .park-card .park-card-text,
        .park-card .park-card-btn {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Parques Forestales</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#descubre">Descubre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> 
 
<section id="inicio" class="hero-panels-container">
    
    <!-- Contenido superpuesto (título y botón) -->
    <div class="hero-content">
        <h1>Explora la Belleza de la Naturaleza</h1>
        <p class="lead">Sumérgete en la tranquilidad de nuestros parques forestales y reconecta con el medio ambiente.</p>
         <a href="{{ route('login') }}" class="btn btn-success btn-lg">Empieza a Explorar</a>
    </div>

    <!-- Paneles de fondo -->
    <div class="hero-panel" style="background-image: url('https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=2070');">
        <h3>Bosque Místico</h3>
    </div>
    <div class="hero-panel" style="background-image: url('https://images.unsplash.com/photo-1473773508845-188df298d2d1?q=80&w=1974');">
        <h3>Ríos Serenos</h3>
    </div>
    <div class="hero-panel" style="background-image: url('https://images.unsplash.com/photo-1501854140801-50d01698950b?q=80&w=1950');">
        <h3>Valles Verdes</h3>
    </div>
    <div class="hero-panel" style="background-image: url('https://images.unsplash.com/photo-1426604966848-d7adac402bff?q=80&w=2070');">
        <h3>Senderos Ocultos</h3>
    </div>
    <div class="hero-panel" style="background-image: url('https://images.unsplash.com/photo-1470240731273-7821a6eeb6bd?q=80&w=2070');">
        <h3>Amanecer Dorado</h3>
    </div>
</section>


<section id="descubre" class="section-padding mt-5" >
    <div class="container">
        <h2 class="text-center mb-5">Nuestros Parques Más Populares</h2>
        <!-- La clase 'row-cols-md-2' asegura 2 columnas en pantallas medianas y grandes -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            
            <!-- Parque 1 -->
            <div class="col">
                <div class="park-card">
                    <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=2070" class="park-card-img" alt="Bosque Encantado">
                    <div class="park-card-content">
                        <h5 class="park-card-title">Bosque Encantado</h5>
                        <p class="park-card-text">Un paraíso de biodiversidad con senderos serpenteantes y vistas impresionantes.</p>
                        <a href="#" class="btn btn-success park-card-btn">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Parque 2 -->
            <div class="col">
                <div class="park-card">
                    <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=2070" class="park-card-img" alt="Valle Escondido">
                    <div class="park-card-content">
                        <h5 class="park-card-title">Valle Escondido</h5>
                        <p class="park-card-text">Hogar de cascadas cristalinas y una flora y fauna única. Ideal para la fotografía.</p>
                        <a href="#" class="btn btn-success park-card-btn">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Parque 3 -->
            <div class="col">
                <div class="park-card">
                    <img src="https://images.unsplash.com/photo-1532274402911-5a369e4c4bb5?q=80&w=2070" class="park-card-img" alt="Cumbres Verdes">
                    <div class="park-card-content">
                        <h5 class="park-card-title">Cumbres Verdes</h5>
                        <p class="park-card-text">Montañas majestuosas y bosques densos, perfectos para el senderismo y la aventura.</p>
                        <a href="#" class="btn btn-success park-card-btn">Ver Detalles</a>
                    </div>
                </div>
            </div>

            <!-- Parque 4 -->
            <div class="col">
                <div class="park-card">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070" class="park-card-img" alt="Lago Espejo">
                    <div class="park-card-content">
                        <h5 class="park-card-title">Lago Espejo</h5>
                        <p class="park-card-text">Aguas tranquilas que reflejan picos majestuosos. Un lugar perfecto para la calma.</p>
                        <a href="#" class="btn btn-success park-card-btn">Ver Detalles</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

    <section id="beneficios" class="section-padding bg-light mt-5">
        <div class="container">
            <h2 class="text-center mb-5">Beneficios de Visitar un Parque Forestal</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">🌳</div>
                    <h3>Salud y Bienestar</h3>
                    <p>Reduce el estrés, mejora el estado de ánimo y fomenta la actividad física.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">🌿</div>
                    <h3>Educación Ambiental</h3>
                    <p>Aprende sobre ecosistemas, flora y fauna, y la importancia de la conservación.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon">📸</div>
                    <h3>Fotografía y Arte</h3>
                    <p>Captura paisajes impresionantes y encuentra inspiración en la belleza natural.</p>
                </div>
            </div>
        </div>
    </section>

   <section id="contacto" class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Lo que dicen nuestros visitantes</h2>
        </div>
        <div class="scroller-wrapper">
            <div class="scroller-inner">
                <div class="card comment-card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">"¡Una experiencia inolvidable! El aire puro y los paisajes del Bosque Encantado me recargaron de energía. Totalmente recomendado."</p>
                        <div class="comment-author">
                            <img src="https://i.pravatar.cc/150?img=1" alt="Avatar de Ana">
                            <div>
                                <h6 class="card-title mb-0">Ana Gómez</h6>
                                <small class="text-muted">Visitante frecuente</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card comment-card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">"Perfecto para una escapada de fin de semana. Los senderos están muy bien señalizados y el personal es muy amable."</p>
                        <div class="comment-author">
                            <img src="https://i.pravatar.cc/150?img=2" alt="Avatar de Carlos">
                            <div>
                                <h6 class="card-title mb-0">Carlos Ruiz</h6>
                                <small class="text-muted">Fotógrafo aficionado</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card comment-card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">"Llevé a mis hijos a Cumbres Verdes y aprendieron muchísimo sobre la naturaleza. ¡Una gran lección de vida fuera del aula!"</p>
                        <div class="comment-author">
                            <img src="https://i.pravatar.cc/150?img=3" alt="Avatar de Sofía">
                            <div>
                                <h6 class="card-title mb-0">Sofía Méndez</h6>
                                <small class="text-muted">Madre de familia</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card comment-card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">"La paz que se respira en el Valle Escondido no tiene precio. Ideal para meditar y desconectar del ruido de la ciudad."</p>
                        <div class="comment-author">
                            <img src="https://i.pravatar.cc/150?img=4" alt="Avatar de Javier">
                            <div>
                                <h6 class="card-title mb-0">Javier Torres</h6>
                                <small class="text-muted">Entusiasta del senderismo</small>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="card comment-card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">"La organización es impecable y los parques están muy bien cuidados. Se nota el amor y el respeto por el medio ambiente."</p>
                        <div class="comment-author">
                            <img src="https://i.pravatar.cc/150?img=5" alt="Avatar de Laura">
                            <div>
                                <h6 class="card-title mb-0">Laura Peña</h6>
                                <small class="text-muted">Bióloga</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- ===== NUEVO FOOTER MEJORADO ===== -->
<footer class="main-footer">
    <div class="container">
        <div class="row">
            <!-- Columna de la Marca -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Parques Forestales</h5>
                <p class="footer-text">Conectando personas con la naturaleza, un sendero a la vez. Protegiendo nuestros pulmones verdes para las futuras generaciones.</p>
            </div>

            <!-- Columna de Enlaces Rápidos -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Explorar</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#descubre">Descubre</a></li>
                    <li><a href="#beneficios">Beneficios</a></li>
                    <li><a href="#contacto">Opiniones</a></li>
                </ul>
            </div>

            <!-- Columna de Contacto (Opcional) -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                 <h5 class="footer-heading">Contacto</h5>
                 <ul class="list-unstyled footer-text">
                    <li><span class="iconify" data-icon="mdi:map-marker-outline"></span> Sede Central, Honduras</li>
                    <li><span class="iconify" data-icon="mdi:phone-outline"></span> +504 1234-5678</li>
                    <li><span class="iconify" data-icon="mdi:email-outline"></span> info@parquesforestales.hn</li>
                 </ul>
            </div>

            <!-- Columna de Redes Sociales -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="footer-heading">Síguenos</h5>
                <div class="social-icons">
                    <a href="#" aria-label="LinkedIn" class="social-icon"><span class="iconify" data-icon="mdi:linkedin"></span></a>
                    <a href="#" aria-label="GitHub" class="social-icon"><span class="iconify" data-icon="mdi:github"></span></a>
                    <a href="#" aria-label="Instagram" class="social-icon"><span class="iconify" data-icon="mdi:instagram"></span></a>
                    <a href="#" aria-label="X (Twitter)" class="social-icon"><span class="iconify" data-icon="ri:twitter-x-fill"></span></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Parques Forestales. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>

        <script src="script.js"></script>

<script>

document.addEventListener('scroll', function() {
    // Obtiene la posición actual del scroll vertical
    const scrollY = window.scrollY;
    // Selecciona todas las capas del parallax
    const layers = document.querySelectorAll('.parallax-layer');

    layers.forEach(layer => {
        const speed = layer.getAttribute('data-speed');
        const yPos = -(scrollY * speed); // Calcula el desplazamiento negativo para que suban
        layer.style.transform = `translateY(${yPos}px)`; // Aplica la transformación
    });
});
document.addEventListener('DOMContentLoaded', () => {

  const parallaxLayers = document.querySelectorAll('.parallax-layer');

  setTimeout(() => {
    parallaxLayers.forEach((layer, index) => {
      setTimeout(() => {
        layer.classList.add('is-visible');
      }, index * 100);
    });
  }, 100);

  window.addEventListener('scroll', () => {
    const scrollValue = window.scrollY;

    parallaxLayers.forEach(layer => {
      const speed = layer.dataset.speed;
      const displacement = -scrollValue * speed;
      
      layer.style.transform = `translateY(${displacement}px)`;
    });
  });

});


    // Script para el carrusel infinito de comentarios
    document.addEventListener('DOMContentLoaded', () => {
        const scrollerInner = document.querySelector('.scroller-inner');
        if (scrollerInner) {
            const scrollerContent = Array.from(scrollerInner.children);
            
            scrollerContent.forEach(item => {
                const duplicatedItem = item.cloneNode(true);
                duplicatedItem.setAttribute('aria-hidden', true);
                scrollerInner.appendChild(duplicatedItem);
            });
        }
    });
</script>
</body>

</html>