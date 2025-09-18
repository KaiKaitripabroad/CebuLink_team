document.addEventListener("DOMContentLoaded", function () {
    // CSRFトークンを一括で取得
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // ----------------------------------------
    // イベント委譲：body要素でイベントを一括管理
    // ----------------------------------------

    // 'submit'イベント（フォームの送信）を監視
    document.body.addEventListener("submit", function (event) {
        const form = event.target.closest("form");
        if (!form) return;

        if (form.matches(".like-form")) {
            handleLike(form, event);
        } else if (form.matches(".bookmark-form")) {
            handleBookmark(form, event);
        } else if (form.matches(".new-comment-form")) {
            handleNewComment(form, event);
        }
    });

    // 'click'イベント（クリック操作）を監視
    document.body.addEventListener("click", function (event) {
        const commentToggleButton = event.target.closest(".comment-toggle-button");
        if (commentToggleButton) {
            toggleCommentSection(commentToggleButton);
        }

        const tagButton = event.target.closest(".tag-section .tag");
        if (tagButton) {
            handleTagClick(tagButton);
        }
    });

    // ----------------------------------------
    // 各処理の関数
    // ----------------------------------------

    /**
     * いいね処理（楽観的UI・アニメーション付き）
     */
    function handleLike(form, event) {
        event.preventDefault();
        const postId = form.dataset.postId;
        const url = form.action;
        const isUnlike = form.querySelector('input[name="_method"]')?.value === "DELETE";
        const method = isUnlike ? "DELETE" : "POST";

        const likeSection = document.getElementById(`like-section-${postId}`);
        if (!likeSection) return;

        const icon = likeSection.querySelector("i");
        const originalClasses = icon.className;

        // 1. 先に見た目を変更
        if (isUnlike) {
            icon.className = "far fa-heart";
        } else {
            icon.className = "fas fa-heart icon-liked";
            icon.classList.add("icon-animate");
        }

        // 2. 裏側でサーバーに通信
        fetch(url, {
            method: method,
            headers: { "X-CSRF-TOKEN": csrfToken, Accept: "application/json" },
        })
        .then(response => {
            if (!response.ok) throw new Error("Server error");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // 3. 通信成功後、フォームの情報を更新
                const newHtml = isUnlike
                    ? `<form action="${url.replace("/unlike","/like")}" method="POST" class="like-form" data-post-id="${postId}">
                           <input type="hidden" name="_token" value="${csrfToken}">
                           <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                       </form>`
                    : `<form action="${url.replace("/like","/unlike")}" method="POST" class="like-form" data-post-id="${postId}">
                           <input type="hidden" name="_token" value="${csrfToken}">
                           <input type="hidden" name="_method" value="DELETE">
                           <button type="submit" class="like-button"><i class="fas fa-heart icon-liked"></i></button>
                       </form>`;
                likeSection.innerHTML = newHtml;
            } else {
                icon.className = originalClasses;
            }
        })
        .catch(error => {
            console.error("Like failed:", error);
            icon.className = originalClasses;
            alert("いいね操作に失敗しました。");
        });
    }

    /**
     * ブックマーク処理（楽観的UI・アニメーション付き）
     */
    function handleBookmark(form, event) {
        event.preventDefault();
        const postId = form.dataset.postId;
        const url = form.action;
        const isUnbookmark = form.querySelector('input[name="_method"]')?.value === "DELETE";
        const method = isUnbookmark ? "DELETE" : "POST";

        const bookmarkSection = document.getElementById(`bookmark-section-${postId}`);
        if (!bookmarkSection) return;

        const icon = bookmarkSection.querySelector("i");
        const originalClasses = icon.className;

        // 1. 先に見た目を変更
        if (isUnbookmark) {
            icon.className = "far fa-bookmark";
        } else {
            icon.className = "fas fa-bookmark icon-bookmarked";
            icon.classList.add("icon-animate");
        }

        // 2. 裏側でサーバーに通信
        fetch(url, {
            method: method,
            headers: { "X-CSRF-TOKEN": csrfToken, Accept: "application/json" },
        })
        .then(response => {
            if (!response.ok) throw new Error("Server error");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // 3. 通信成功後、フォームの情報を更新
                const newHtml = isUnbookmark
                    ? `<form action="${url.replace("/unbookmark","/bookmark")}" method="POST" class="bookmark-form" data-post-id="${postId}">
                           <input type="hidden" name="_token" value="${csrfToken}">
                           <button type="submit" class="bookmark-button"><i class="far fa-bookmark"></i></button>
                       </form>`
                    : `<form action="${url.replace("/bookmark","/unbookmark")}" method="POST" class="bookmark-form" data-post-id="${postId}">
                           <input type="hidden" name="_token" value="${csrfToken}">
                           <input type="hidden" name="_method" value="DELETE">
                           <button type="submit" class="bookmark-button"><i class="fas fa-bookmark icon-bookmarked"></i></button>
                       </form>`;
                bookmarkSection.innerHTML = newHtml;
            } else {
                icon.className = originalClasses;
            }
        })
        .catch(error => {
            console.error("Bookmark failed:", error);
            icon.className = originalClasses;
            alert("ブックマーク操作に失敗しました。");
        });
    }

    /**
     * コメント欄の表示/非表示
     */
    function toggleCommentSection(button) {
        const postId = button.dataset.postId;
        const commentsContainer = document.getElementById(`comments-container-${postId}`);
        if (!commentsContainer) return;

        const isHidden = commentsContainer.style.display === "none" || commentsContainer.style.display === "";

        if (isHidden) {
            if (commentsContainer.dataset.loaded !== "true") {
                fetch(`/posts/${postId}/comments`)
                    .then(response => response.json())
                    .then(comments => {
                        const commentsList = commentsContainer.querySelector(".comments-list");
                        commentsList.innerHTML = "";
                        comments.forEach(comment => {
                            const commentHtml = `
                                <div class="comment-item">
                                    <strong>@${comment.user.name}</strong>
                                    <span>${comment.content}</span>
                                </div>`;
                            commentsList.insertAdjacentHTML("beforeend", commentHtml);
                        });
                        commentsContainer.dataset.loaded = "true";
                    })
                    .catch(error => console.error("Error:", error));
            }
            commentsContainer.style.display = "block";
        } else {
            commentsContainer.style.display = "none";
        }
    }

    /**
     * 新規コメント投稿
     */
    function handleNewComment(form, event) {
        event.preventDefault();
        const input = form.querySelector('input[name="content"]');
        const content = input.value.trim();
        if (content === "") return;

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ content: content }),
        })
        .then(response => {
            if (!response.ok) throw new Error("Server error");
            return response.json();
        })
        .then(newComment => {
            if (newComment && newComment.user) {
                const commentsList = form.closest(".comments-container").querySelector(".comments-list");
                const commentHtml = `
                    <div class="comment-item">
                        <strong>@${newComment.user.name}</strong>
                        <span>${newComment.content}</span>
                    </div>`;
                commentsList.insertAdjacentHTML("beforeend", commentHtml);
                input.value = "";
            }
        })
        .catch(error => console.error("Error:", error));
    }

    /**
     * タグのクリック処理
     */
    function handleTagClick(button) {
        document.querySelectorAll(".tag-section .tag").forEach(btn => btn.classList.remove("active"));
        button.classList.add("active");
        document.getElementById("tag").value = button.dataset.value;
    }
});
