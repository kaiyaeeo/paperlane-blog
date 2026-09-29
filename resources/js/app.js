import Alpine from 'alpinejs';
import tinymce from 'tinymce';

// TinyMCE core & theme
import 'tinymce/icons/default';
import 'tinymce/themes/silver';
import 'tinymce/models/dom';

// Plugins (hanya yang benar-benar ada di node_modules/tinymce/plugins)
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/code';
import 'tinymce/plugins/image';

// Skin CSS
import 'tinymce/skins/ui/oxide/skin.css';

window.tinymce = tinymce;
window.Alpine = Alpine;
Alpine.start();