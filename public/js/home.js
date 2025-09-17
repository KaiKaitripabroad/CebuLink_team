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

// ページのすべてのHTMLが読み込まれてから、スクリプトを実行する
document.addEventListener("DOMContentLoaded", function () {
    // ----------------------------------------
    // いいね機能
    // ----------------------------------------
    document.body.addEventListener("submit", function (event) {
        const form = event.target.closest(".like-form");
        if (!form) return;

        event.preventDefault();

        // ... (いいね機能のコードはこのまま) ...
        const postId = form.dataset.postId;
        if (!postId) return;

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
            .then((response) => response.json())
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
                        const likeUrl = url.replace("/unlike", "/like");
                        newHtml = `
                        <form action="${likeUrl}" method="POST" class="like-form" data-post-id="${postId}" style="display: inline;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                        </form>
                        <span class="like-count">${data.likes_count}</span>
                    `;
                    } else {
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
                    likeSection.innerHTML = newHtml;
                }
            });
    });

    // ----------------------------------------
    // コメント機能
    // ----------------------------------------

    // 1. コメントアイコンクリック時の処理
    document.body.addEventListener("click", function (event) {
        const toggleButton = event.target.closest(".comment-toggle-button");
        if (!toggleButton) return;

        const postId = toggleButton.dataset.postId;
        const commentsContainer = document.getElementById(
            `comments-container-${postId}`
        );
        const isHidden = commentsContainer.style.display === "none";

        if (isHidden) {
            if (commentsContainer.dataset.loaded !== "true") {
                fetch(`/posts/${postId}/comments`)
                    .then((response) => response.json())
                    .then((comments) => {
                        const commentsList =
                            commentsContainer.querySelector(".comments-list");
                        commentsList.innerHTML = ""; // 一旦空にする
                        comments.forEach((comment) => {
                            const commentHtml = `
                                <div class="comment-item">
                                    <strong>@${comment.user.name}</strong>
                                    <span>${comment.content}</span>
                                </div>
                            `;
                            commentsList.insertAdjacentHTML(
                                "beforeend",
                                commentHtml
                            );
                        });
                        commentsContainer.dataset.loaded = "true";
                    });
            }
            commentsContainer.style.display = "block";
        } else {
            commentsContainer.style.display = "none";
        }
    });

    // 2. 新しいコメントフォーム送信時の処理
    document.body.addEventListener("submit", function (event) {
        const form = event.target.closest(".new-comment-form");
        if (!form) return;

        event.preventDefault();

        const input = form.querySelector('input[name="content"]');
        const content = input.value.trim();
        if (content === "") return;

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            // ★★★ ここが修正ポイント！ 'body' というキーで送る ★★★
            body: JSON.stringify({ content: content }),
        })
            .then((response) => {
                if (!response.ok)
                    throw new Error("Validation failed or server error");
                return response.json();
            })
            .then((newComment) => {
                if (newComment) {
                    // newCommentがnullでないことを確認
                    const commentsList = form
                        .closest(".comments-container")
                        .querySelector(".comments-list");
                    const commentHtml = `
                    <div class="comment-item">
                        <strong>@${newComment.user.name}</strong>
                        <span>${newComment.content}</span>
                    </div>
                `;
                    commentsList.insertAdjacentHTML("beforeend", commentHtml);
                    input.value = ""; // 入力欄を空にする
                }
            })
            .catch((error) => console.error("Error:", error));
    });

    // ボタンのスタイル（任意）
    const style = document.createElement("style");
    style.innerHTML = `.like-button, .comment-toggle-button { background: none; border: none; padding: 0; cursor: pointer; }`;
    document.head.appendChild(style);
});
document.querySelectorAll(".tag-section .tag").forEach((button) => {
    button.addEventListener("click", function () {
        // ボタンのアクティブ化
        document
            .querySelectorAll(".tag-section .tag")
            .forEach((btn) => btn.classList.remove("active"));
        this.classList.add("active");

        // select に反映
        document.getElementById("tag").value = this.dataset.value;
    });
});
