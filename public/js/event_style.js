// DOMの読み込みが完了してから処理を開始
document.addEventListener("DOMContentLoaded", function () {
    const dateList = document.getElementById("date-list");
    const today = new Date();
    const selectedDateElement = document.getElementById("selected-date");
    const eventListContainer = document.querySelector(".event-list"); // イベントリストの親要素を取得

    let currentIndex = 0;
    renderDates();

    function renderDates() {
        dateList.innerHTML = "";
        for (let i = currentIndex; i < currentIndex + 31; i++) {
            let date = new Date(today);
            date.setDate(today.getDate() + i);

            let span = document.createElement("span");
            span.classList.add("date-item");

            const dateStringForDisplay = date.toLocaleDateString("en-US", {
                month: "short",
                day: "numeric",
            });
            span.textContent = dateStringForDisplay;

            // サーバーに送るための日付フォーマット (YYYY-MM-DD) をdata属性に保存
            const dateStringForApi = date.toISOString().split("T")[0];
            span.dataset.date = dateStringForApi;

            let weekday = date.toLocaleDateString("en-US", {
                weekday: "short",
            });
            if (weekday === "Sat") {
                span.style.color = "blue";
            }
            if (weekday === "Sun") {
                span.style.color = "red";
            }

            // 日付クリック時のイベントリスナー
            span.addEventListener("click", () => {
                // 他の日付のアクティブ状態を解除
                document
                    .querySelectorAll(".date-item")
                    .forEach((el) => el.classList.remove("active"));
                // クリックした日付をアクティブにする
                span.classList.add("active");

                // h1 の日付表示を更新
                selectedDateElement.textContent = dateStringForDisplay;

                // ★ Laravelにイベント情報を問い合わせる関数を呼び出す
                fetchEvents(span.dataset.date);
            });

            dateList.appendChild(span);
        }
    }

    /**
     * 指定された日付のイベントをサーバーから取得し、表示を更新する関数
     * @param {string} date - 'YYYY-MM-DD' 形式の日付文字列
     */
    function fetchEvents(date) {
        // 読み込み中であることをユーザーに知らせる（任意）
        eventListContainer.innerHTML = `<p style="text-align: center; width: 100%;">読み込み中...</p>`;

        // fetch APIを使って、Laravelのルートにリクエストを送信
        fetch(`/events/filter?date=${date}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("サーバーとの通信に失敗しました。");
                }
                return response.text(); // 応答をHTMLテキストとして受け取る
            })
            .then((html) => {
                // 受け取ったHTMLでイベントリストの中身をまるごと入れ替える
                eventListContainer.innerHTML = html;
            })
            .catch((error) => {
                console.error("Fetchエラー:", error);
                eventListContainer.innerHTML = `<p style="text-align: center; width: 100%; color: red;">イベントの読み込みに失敗しました。</p>`;
            });
    }
    function showAllEvents() {
        // すでに「ALL」が表示されている場合は何もしない
        if (selectedDateElement.textContent === "ALL") return;

        selectedDateElement.textContent = "ALL";
        // 選択されている日付のハイライトを解除
        document
            .querySelectorAll(".date-item.active")
            .forEach((el) => el.classList.remove("active"));

        // dateパラメータを付けずに全件取得をリクエスト
        fetchEvents(null);
    }
    // --- イベントリスナーの設定 ---

    // h1の「ALL」または日付部分がクリックされたら、全件表示に戻す
    selectedDateElement.addEventListener('click', showAllEvents);

    // ★★★【追加】★★★
    // カレンダーの日付リスト部分がダブルクリックされたら、全件表示に戻す
    dateList.addEventListener('dblclick', showAllEvents);

    // --- ナビゲーションボタンの処理 ---
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

    // 「ALL」H1要素がクリックされたら、全件表示に戻す機能
    selectedDateElement.addEventListener("click", () => {
        if (selectedDateElement.textContent === "ALL") return; // すでにALLなら何もしない

        selectedDateElement.textContent = "ALL";
        document
            .querySelectorAll(".date-item")
            .forEach((el) => el.classList.remove("active"));

        eventListContainer.innerHTML = `<p style="text-align: center; width: 100%;">読み込み中...</p>`;

        // dateパラメータを付けずにリクエストを送り、全件取得
        fetch(`/events/filter`)
            .then((response) => response.text())
            .then((html) => {
                eventListContainer.innerHTML = html;
            })
            .catch((error) => {
                console.error("Fetchエラー:", error);
                eventListContainer.innerHTML = `<p style="text-align: center; width: 100%; color: red;">イベントの読み込みに失敗しました。</p>`;
            });
    });

    // --- 以下、ナビゲーションボタンの処理 ---
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
});
