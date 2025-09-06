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
