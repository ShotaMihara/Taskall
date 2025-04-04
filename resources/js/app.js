import './bootstrap';

import toggleColorMode from "./darkmode"

//追記
document
  .getElementById("js__toggle_color_mode_btn")
  .addEventListener("click", toggleColorMode)

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
