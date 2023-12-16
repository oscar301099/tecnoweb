document.addEventListener("DOMContentLoaded", function () {
    const modoActual = localStorage.getItem('modo') || 'dia';
    aplicarModo(modoActual);
});

function aplicarModo(modo) {
    document.body.style.filter = `brightness(${modo === 'dia' ? '100%' : '70%'})`;
}