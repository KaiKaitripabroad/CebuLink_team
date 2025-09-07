function toggleMenu() {
    document.getElementById("menu").classList.toggle("active");
}
function closeMenu() {
    document.getElementById("menu").classList.remove("active");
}
// メニュー外をクリックしたときにメニューを閉じる
document.addEventListener("click", function (event) {
    var menu = document.getElementById("menu");
    var menuToggle = document.querySelector(".menu-toggle");
    if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
        closeMenu();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // 必要なHTML要素を取得します
    const profileImage = document.getElementById("profileImage");
    const profileInput = document.getElementById("profileInput");

    // 1. プロフィール画像がクリックされた時の処理
    profileImage.addEventListener("click", function () {
        // 非表示になっているファイル選択用のinput要素をクリックさせます
        profileInput.click();
    });

    // 2. ファイルが選択された時の処理
    profileInput.addEventListener("change", function (event) {
        // 選択されたファイルを取得します
        const file = event.target.files[0];

        // ファイルが選択されている場合のみ処理を実行します
        if (file) {
            // FileReaderオブジェクトを作成します
            const reader = new FileReader();

            // ファイルの読み込みが完了した時の処理を定義します
            reader.onload = function (e) {
                // img要素のsrc属性を、読み込んだ画像データに書き換えます
                // これにより、画像のプレビューが表示されます
                profileImage.src = e.target.result;
            };

            // 選択されたファイルをDataURL形式で読み込みます
            reader.readAsDataURL(file);
        }
    });
});
