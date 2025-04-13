import './bootstrap';

import toggleColorMode from "./darkmode"

  
// フォームの送信時にボタンを無効化し、スピナーを表示する
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
        
    // タスクの状態を切り替えるフォーム送信処理
    window.submitToggleForm = function (taskId) {
        // localStorage から color-mode を取得して隠しフィールドに設定
        const colorMode = localStorage.getItem('color-mode');
        document.getElementById(`color-mode-${taskId}`).value = colorMode;

        // フォームを送信
        document.getElementById(`toggle-form-${taskId}`).submit();
    };

    // ダークモードのトグルボタンにイベントリスナーを追加
    document
    .getElementById("js__toggle_color_mode_btn")
    .addEventListener("click", toggleColorMode)

    // ページ読み込み時に color-mode を適用
    const colorMode = localStorage.getItem('color-mode');
    if (colorMode === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
