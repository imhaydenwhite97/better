document.addEventListener('DOMContentLoaded', () => {
    // Header scroll handling
    let lastScroll = 0;
    const header = document.querySelector('.mobile-header');
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > lastScroll && currentScroll > 60) {
            header.classList.add('hidden');
        } else {
            header.classList.remove('hidden');
        }
        lastScroll = currentScroll;
    });

    // Menu navigation
    const drawerItems = document.querySelectorAll('.drawer-item');
    const menuOverlays = document.querySelectorAll('.menu-overlay');
    const closeButtons = document.querySelectorAll('.close-menu');
    
    drawerItems.forEach(item => {
        item.addEventListener('click', () => {
            const menuId = `${item.dataset.menu}-menu`;
            const targetMenu = document.getElementById(menuId);
            if (targetMenu) {
                menuOverlays.forEach(menu => menu.classList.remove('active'));
                targetMenu.classList.add('active');
            }
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const menu = button.closest('.menu-overlay');
            menu.classList.remove('active');
        });
    });
});
