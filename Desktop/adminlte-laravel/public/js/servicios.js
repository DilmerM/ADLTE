// Manejo de la vista previa de la imagen
document.getElementById('imagenServicio').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImagen');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
        
        // Actualizar el label con el nombre del archivo
        const label = document.querySelector('.custom-file-label');
        label.textContent = file.name;
    } else {
        preview.src = '';
        preview.style.display = 'none';
        const label = document.querySelector('.custom-file-label');
        label.textContent = 'Seleccionar imagen';
    }
});
