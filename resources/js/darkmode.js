// ダークモードにするボタン
var toggleDarkModeIcon = document.getElementById("js__toggle_dark_mode_icon");
// ライトモードにするボタン
var toggleLightModeIcon = document.getElementById("js__toggle_light_mode_icon");
// ボタン全体
// 画面読み込み時の初期状態
const colorMode = localStorage.getItem("color-mode")
if (
  colorMode === "dark" ||
  ((!colorMode || colorMode.trim() === "") && //ローカルストレージに保存無い（ライトモードじゃ無い）
    window.matchMedia("(prefers-color-scheme: dark)").matches) //デバイスの設定がdark
) {
  toggleLightModeIcon.classList.remove("hidden") //ダークモード時、表示
  if (!colorMode || colorMode.trim() === "") {
    localStorage.setItem("color-mode", "dark")
  }
} else {
  toggleDarkModeIcon.classList.remove("hidden") //ライトモード時、表示
  if (!colorMode || colorMode.trim() === "") {
    localStorage.setItem("color-mode", "light")
  }
}

//カラーモードの切り替え、ローカルストレージで状態管理
function toggleColorMode() {
  toggleDarkModeIcon.classList.toggle("hidden")
  toggleLightModeIcon.classList.toggle("hidden")

  //状態の変更と、htmlにdarkクラスの付け外し
  if (localStorage.getItem("color-mode") === "light") {
    document.documentElement.classList.add("dark")
    localStorage.setItem("color-mode", "dark")
  } else {
    document.documentElement.classList.remove("dark")
    localStorage.setItem("color-mode", "light")
  }
}

export default toggleColorMode