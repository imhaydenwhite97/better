document.getElementById('userProfileTrigger').addEventListener('click', () => {
    document.getElementById('userMenu').classList.toggle('active');
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    const menu = document.getElementById('userMenu');
    const trigger = document.getElementById('userProfileTrigger');
    
    if (!menu.contains(e.target) && !trigger.contains(e.target)) {
        menu.classList.remove('active');
    }
});
