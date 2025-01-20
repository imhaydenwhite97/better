document.addEventListener("DOMContentLoaded", () => {
    // Device detection for interaction handling
    function isTouchDevice() {
        const touchDevice = window.matchMedia('(hover: none) and (pointer: coarse)');
        return touchDevice.matches;
    }

    // Add touch-device class if needed
    if (isTouchDevice()) {
        document.body.classList.add('touch-device');
    }

    // Desktop Navigation - with existence check
    function initializeNavigation() {
        const menuItems = document.querySelectorAll(".menu-item");
        const header = document.querySelector(".desktop-header");

        if (!menuItems.length || !header) {
            setTimeout(initializeNavigation, 100);
            return;
        }

        // Mega Menu functionality
        menuItems.forEach((menuItem) => {
            const megaMenu = menuItem.querySelector(".mega-menu");
            let timeout;

            if (megaMenu) {
                menuItem.addEventListener("mouseenter", () => {
                    clearTimeout(timeout);
                    megaMenu.classList.add("active");
                    header.classList.add("has-active-menu");
                });

                menuItem.addEventListener("mouseleave", () => {
                    timeout = setTimeout(() => {
                        megaMenu.classList.remove("active");
                        header.classList.remove("has-active-menu");
                    }, 200);
                });
            }
        });
    }

    // Start the initialization
    initializeNavigation();
});
