import './bootstrap';

import Alpine from 'alpinejs';
import toastManager from './components/toast';
import cvForm from './components/cvForm';

Alpine.data('toastManager', toastManager);
Alpine.data('cvForm', cvForm);

window.Alpine = Alpine;

Alpine.start();
