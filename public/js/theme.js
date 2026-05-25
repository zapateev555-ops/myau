(function () {
    var STORAGE_KEY = 'md-theme';
    var root = document.documentElement;

    function applyTheme(theme) {
        if (theme === 'dark') {
            root.setAttribute('data-theme', 'dark');
        } else {
            root.removeAttribute('data-theme');
        }
    }

    function currentTheme() {
        return root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    }

    applyTheme(localStorage.getItem(STORAGE_KEY) === 'dark' ? 'dark' : 'light');

    function bindThemeToggles() {
        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            if (btn.dataset.themeBound) return;
            btn.dataset.themeBound = '1';
            btn.setAttribute('aria-pressed', currentTheme() === 'dark' ? 'true' : 'false');
            btn.addEventListener('click', function () {
                var next = currentTheme() === 'dark' ? 'light' : 'dark';
                localStorage.setItem(STORAGE_KEY, next);
                applyTheme(next);
                document.querySelectorAll('[data-theme-toggle]').forEach(function (b) {
                    b.setAttribute('aria-pressed', next === 'dark' ? 'true' : 'false');
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindThemeToggles);
    } else {
        bindThemeToggles();
    }
})();
