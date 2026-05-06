const root = document.documentElement;
const sidebar = document.getElementById('adminSidebar');
const sidebarToggle = document.getElementById('sidebarToggle');
const themeToggle = document.getElementById('themeToggle');

if (sidebar && sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('is-open');
    });
}

const applyTheme = (theme) => {
    root.classList.toggle('dark', theme === 'dark');
};

if (themeToggle) {
    const saved = localStorage.getItem('admin-theme');
    if (saved) {
        applyTheme(saved);
    }

    themeToggle.addEventListener('click', () => {
        const next = root.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(next);
        localStorage.setItem('admin-theme', next);
    });
}
