document.addEventListener("submit", function (event) {
    // ★ポイント：クリックされた場所から一番近い`.like-form`を探す
    const form = event.target.closest(".like-form");
    // `.like-form`でなければ、何もしない
    if (!form) {
        return;
    }

    // ★ポイント：`preventDefault`はここで一回だけ実行される
    event.preventDefault();

    const postId = form.dataset.postId;
    if (!postId) {
        console.error("Post ID not found on the form.");
        return;
    }

    const url = form.action;
    const isUnlike =
        form.querySelector('input[name="_method"]')?.value === "DELETE";
    const method = isUnlike ? "DELETE" : "POST";

    fetch(url, {
        method: method,
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            Accept: "application/json",
        },
    })
        .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                const likeSection = document.getElementById(
                    `like-section-${postId}`
                );
                if (!likeSection) return;

                const csrfToken = form.querySelector(
                    'input[name="_token"]'
                ).value;
                let newHtml = "";

                if (isUnlike) {
                    // 「いいね」するためのフォームに書き換える
                    const likeUrl = url.replace("/unlike", "/like");
                    newHtml = `
                    <form action="${likeUrl}" method="POST" class="like-form" data-post-id="${postId}" style="display: inline;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                    </form>
                    <span class="like-count">${data.likes_count}</span>
                `;
                } else {
                    // 「いいね解除」するためのフォームに書き換える
                    const unlikeUrl = url.replace("/like", "/unlike");
                    newHtml = `
                    <form action="${unlikeUrl}" method="POST" class="like-form" data-post-id="${postId}" style="display: inline;">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="like-button"><i class="fas fa-heart" style="color: #f21818;"></i></button>
                    </form>
                    <span class="like-count">${data.likes_count}</span>
                `;
                }
                // いいねセクションの中身を、新しいHTMLで丸ごと入れ替える
                likeSection.innerHTML = newHtml;
            }
        })
        .catch((error) => {
            console.error("Fetch error:", error);
            alert("エラーが発生しました。");
        });
});

// ボタンのデフォルトスタイルを無効化（任意）
const style = document.createElement("style");
style.innerHTML = `.like-button { background: none; border: none; padding: 0; cursor: pointer; }`;
document.head.appendChild(style);
