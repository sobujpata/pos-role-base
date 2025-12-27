// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();
// import 'jquery';
import 'summernote/dist/summernote-lite';
import 'summernote/dist/summernote-lite.css';

// Optional: Set up Summernote globally if needed
// import $ from 'jquery';
// window.$ = window.jQuery = $;

// Setup axios CSRF token
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}
