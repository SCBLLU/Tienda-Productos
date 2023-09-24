let isMenuOpen = false;

const navSlide = () => {
    const burger = document.querySelector(".burger");
    const nav = document.querySelector(".nav-links");
    const navLinks = document.querySelectorAll(".nav-links a");

    burger.addEventListener("click", () => {
        isMenuOpen = !isMenuOpen; // Cambia el estado del menú

        if (isMenuOpen) {
            // Abre el menú
            nav.classList.add("nav-active");
            document.body.style.overflowY = "hidden"; // Oculta el scroll vertical
        } else {
            // Cierra el menú
            nav.classList.remove("nav-active");
            document.body.style.overflowY = "scroll"; // Restaura el scroll vertical
        }

        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = "";
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.5}s`;
            }
        });
        burger.classList.toggle("toggle");
    });
};

navSlide();
