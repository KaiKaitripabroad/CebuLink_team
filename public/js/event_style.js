const dateList = document.getElementById("date-list");
const today = new Date();

// 最初に7日分を表示
let currentIndex = 0;
renderDates();

function renderDates() {
    dateList.innerHTML = "";
    for (let i = currentIndex; i < currentIndex + 31; i++) {
        let date = new Date(today);
        date.setDate(today.getDate() + i);

        let span = document.createElement("span");
        span.classList.add("date-item");
        span.textContent = date.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
        });

        // 曜日ごとに色分け
        let weekday = date.toLocaleDateString("en-US", { weekday: "short" });
        if (weekday === "Sat") {
            span.style.color = "blue"; // 土曜を青
        }
        if (weekday === "Sun") {
            span.style.color = "red"; // 日曜を赤
        }

        span.addEventListener("click", () => {
            document
                .querySelectorAll(".date-item")
                .forEach((el) => el.classList.remove("active"));
            span.classList.add("active");
            console.log("選択された日付:", date.toISOString().split("T")[0]);
        });

        dateList.appendChild(span);
    }
}

document.getElementById("prev").addEventListener("click", () => {
    if (currentIndex > 0) {
        currentIndex -= 1;
        renderDates();
    }
});

document.getElementById("next").addEventListener("click", () => {
    currentIndex += 1;
    renderDates();
});
