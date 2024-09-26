import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import type { App } from 'vue';
import type { PluginOptions } from 'vue-toastification';

const options: PluginOptions = {};

export default {
  install(app: App) {
    app.use(Toast, options);
  },
};
