// scripts.js
document.addEventListener("DOMContentLoaded", function() {
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");
    const rootElement = document.documentElement;

    function handleScroll() {
        const scrollTotal = rootElement.scrollHeight - rootElement.clientHeight;
        if (rootElement.scrollTop / scrollTotal > 0.2) {
            
            scrollToTopBtn.style.display = "block";
        } else {
           
            scrollToTopBtn.style.display = "none";
        }
    }

    function scrollToTop() {
        rootElement.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }

    scrollToTopBtn.addEventListener("click", scrollToTop);
    document.addEventListener("scroll", handleScroll);
});

function mostrarVentanaEmergente() {
    document.getElementById('ventanaEmergente').style.display = 'block';
  }
  
  function cerrarVentanaEmergente() {
    document.getElementById('ventanaEmergente').style.display = 'none';
  }
  
  