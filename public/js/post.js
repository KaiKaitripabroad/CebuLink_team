document
    .getElementById("imageUpload")
    .addEventListener("change", function (event) {
        const preview = document.getElementById("preview");
        const plusIcon = document.querySelector(".plus-icon");
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
            plusIcon.style.display = "none"; // ＋を非表示
        } else {
            preview.style.display = "none";
            plusIcon.style.display = "block"; // ＋を再表示
        }
    });

// 🔽 タグ選択処理（ここに追加）
const tagButtons = document.querySelectorAll(".tag");
const hiddenInput = document.getElementById("selected-tags");
let selectedTags = [];

tagButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const tag = button.dataset.tag;

        if (selectedTags.includes(tag)) {
            selectedTags = selectedTags.filter((t) => t !== tag);
            button.classList.remove("selected");
        } else {
            if (selectedTags.length < 2) {
                selectedTags.push(tag);
                button.classList.add("selected");
            } else {
                alert("タグは最大2つまで選択できます");
            }
        }

        hiddenInput.value = selectedTags.join(",");
    });
});

// 住所から地図表示
function codeAddress() {
    const inputAddress = document.getElementById("address").value;

    geocoder.geocode({ address: inputAddress }, (results, status) => {
        if (status === "OK") {
            map.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);

            // 結果を表示
            document.getElementById("result").textContent =
                results[0].formatted_address;

            // ★ 緯度・経度を hidden input に入れる
            document.getElementById("latitude").value =
                results[0].geometry.location.lat();
            document.getElementById("longitude").value =
                results[0].geometry.location.lng();
        } else {
            alert("ジオコーディング失敗: " + status);
        }
    });
}
