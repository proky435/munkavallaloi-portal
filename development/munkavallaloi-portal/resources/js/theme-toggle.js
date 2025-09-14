// Theme Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    
    // Check for saved theme preference or default to 'light'
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Apply the current theme
    if (currentTheme === 'dark') {
        htmlElement.classList.add('dark');
        updateToggleIcon(true);
    } else {
        htmlElement.classList.remove('dark');
        updateToggleIcon(false);
    }
    
    // Theme toggle event listener
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isDark = htmlElement.classList.contains('dark');
            
            if (isDark) {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                updateToggleIcon(false);
            } else {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                updateToggleIcon(true);
            }
        });
    }
    
    function updateToggleIcon(isDark) {
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        
        if (sunIcon && moonIcon) {
            if (isDark) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }
    }
});
