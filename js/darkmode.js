const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
const themeToggleBtn = document.getElementById('theme-toggle');
const logoLight = document.querySelector('.logo-light');
const logoDark = document.querySelector('.logo-dark');

function toggleTheme() {
    const isDarkMode = document.documentElement.classList.contains('dark');
    if (isDarkMode) {
        logoLight.classList.remove('hidden');
        logoDark.classList.add('hidden');
    } else {
        logoLight.classList.add('hidden');
        logoDark.classList.remove('hidden');
    }
}

function toggleTheme2() {
    const isDarkMode = document.documentElement.classList.contains('dark');
    if (isDarkMode) {
        logoLight.classList.add('hidden');
        logoDark.classList.remove('hidden');
    } else {
        logoLight.classList.remove('hidden');
        logoDark.classList.add('hidden');
    }
}

function toggleIcons() {
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');
}

function toggleColorTheme() {
    const isDarkMode = document.documentElement.classList.contains('dark');
    const newColorTheme = isDarkMode ? 'light' : 'dark';
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('color-theme', newColorTheme);
}

if (localStorage.getItem('color-theme') === 'dark' || (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
    themeToggleDarkIcon.classList.add('hidden');
    toggleTheme(); 
} else {
    themeToggleDarkIcon.classList.remove('hidden');
    themeToggleLightIcon.classList.add('hidden');
    toggleTheme(); 
}

themeToggleBtn.addEventListener('click', () => {
    toggleIcons();
    toggleTheme2()
    toggleColorTheme();
});
