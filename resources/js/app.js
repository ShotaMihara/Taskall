import './bootstrap';

import toggleColorMode from "./darkmode"


// ダークモードのトグルボタンにイベントリスナーを追加
document
  .getElementById("js__toggle_color_mode_btn")
  .addEventListener("click", toggleColorMode)

document.addEventListener('DOMContentLoaded', function () {
    // フォームの送信イベントを監視
    const goalForm = document.getElementById('goalForm');
    if (goalForm) {
        goalForm.addEventListener('submit', function () {
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // ボタンを無効化
            submitButton.disabled = true;

            // ボタンのテキストを変更してスピナーを表示
            buttonText.textContent = 'タスクを作成中...';
            loadingSpinner.classList.remove('hidden');
        });
    }
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
