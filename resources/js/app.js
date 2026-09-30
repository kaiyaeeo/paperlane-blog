import Alpine from 'alpinejs';
import tinymce from 'tinymce';

// TinyMCE core & theme
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';

// Plugins
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/code';
import 'tinymce/plugins/image';

// Skin CSS
import 'tinymce/skins/ui/oxide/skin.css';

// Dark mode
window.toggleDarkMode = function () {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
};

window.tinymce = tinymce;
window.Alpine = Alpine;
Alpine.start();