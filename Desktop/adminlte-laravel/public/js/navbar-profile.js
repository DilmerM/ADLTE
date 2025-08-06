// public/js/navbar-profile.js

document.addEventListener('DOMContentLoaded', function() {
    try {
        const userData = JSON.parse(localStorage.getItem('userData'));
        // Obtenemos la URL base de una etiqueta meta que configuraremos en el siguiente paso
        const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
        const rightNavbar = document.querySelector('.navbar-nav.ml-auto');

        if (rightNavbar && userData && userData.ruta_foto_perfil) {

            if (document.getElementById('navbarProfileIcon')) return;

            const listItem = document.createElement('li');
            listItem.classList.add('nav-item');

            const img = document.createElement('img');
            img.id = 'navbarProfileIcon';
            // Usamos la URL base para construir la ruta completa de la imagen
            img.src = `${baseUrl}/${userData.ruta_foto_perfil}`;
            img.classList.add('img-circle');
            img.style.cssText = 'width: 28px; height: 28px; margin-top: 5px; margin-right: 15px; border: 1px solid #6c757d;';

            listItem.appendChild(img);
            rightNavbar.prepend(listItem);
        }
    } catch(e) {
        // Falla silenciosamente si no hay datos o hay un error.
    }
});