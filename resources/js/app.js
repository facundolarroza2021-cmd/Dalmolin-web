import './bootstrap';
import Swiper from 'swiper/bundle'; // Importa el bundle completo (incluye css y módulos)
import 'swiper/css/bundle'; // Importa los estilos
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Swiper = Swiper; // <--- ESTA LÍNEA ES LA CLAVE