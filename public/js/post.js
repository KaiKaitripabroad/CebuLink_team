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
