document.addEventListener("DOMContentLoaded", function () {
    // ----------------------------------------
    // イベント委譲：body要素でイベントを一括管理
    // ----------------------------------------
    document.body.addEventListener('submit', function (event) {
        const form = event.target.closest('form');
        if (!form) return;

        if (form.matches('.like-form')) {
            handleLike(form, event);
        } else if (form.matches('.bookmark-form')) {
            handleBookmark(form, event);
        } else if (form.matches('.new-comment-form')) {
            handleNewComment(form, event);
        }
    });

    document.body.addEventListener('click', function (event) {
        const button = event.target.closest('.comment-toggle-button');
        if (button) {
            toggleCommentSection(button);
        }
    });

    // ----------------------------------------
    // いいね処理
    // ----------------------------------------
    function handleLike(form, event) {
        event.preventDefault();
        const postId = form.dataset.postId;
        if (!postId) return;

        const url = form.action;
        const isUnlike = form.querySelector('input[name="_method"]')?.value === 'DELETE';
        const method = isUnlike ? 'DELETE' : 'POST';
        const csrfToken = form.querySelector('input[name="_token"]').value;

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeSection = document.getElementById(`like-section-${postId}`);
                if (!likeSection) return;

                let newHtml = '';
                if (isUnlike) {
                    const likeUrl = url.replace('/unlike', '/like');
                    newHtml = `
                        <form action="${likeUrl}" method="POST" class="like-form" data-post-id="${postId}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="like-button"><i class="far fa-heart"></i></button>
                        </form>`;
                } else {
                    const unlikeUrl = url.replace('/like', '/unlike');
                    newHtml = `
                        <form action="${unlikeUrl}" method="POST" class="like-form" data-post-id="${postId}">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="like-button"><i class="fas fa-heart icon-liked"></i></button>
                        </form>`;
                }
                likeSection.innerHTML = newHtml;

                if (!isUnlike) {
                    const newIcon = likeSection.querySelector('.fa-heart');
                    if (newIcon) newIcon.classList.add('icon-animate');
                }
            }
        });
    }

    // ----------------------------------------
    // ブックマーク処理
    // ----------------------------------------
    function handleBookmark(form, event) {
        event.preventDefault();
        const postId = form.closest('.post-actions').querySelector('[data-post-id]').dataset.postId;
        if (!postId) return;

        const url = form.action;
        const isUnbookmark = form.querySelector('input[name="_method"]')?.value === 'DELETE';
        const method = isUnbookmark ? 'DELETE' : 'POST';
        const csrfToken = form.querySelector('input[name="_token"]').value;

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const bookmarkSection = document.getElementById(`bookmark-section-${postId}`);
                if (!bookmarkSection) return;

                let newHtml = '';
                if (isUnbookmark) {
                    const bookmarkUrl = url;
                    newHtml = `
                        <form action="${bookmarkUrl}" method="POST" class="bookmark-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <button type="submit" class="bookmark-button"><i class="far fa-bookmark"></i></button>
                        </form>`;
                } else {
                    const unbookmarkUrl = url;
                    newHtml = `
                        <form action="${unbookmarkUrl}" method="POST" class="bookmark-form">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="bookmark-button"><i class="fas fa-bookmark icon-bookmarked"></i></button>
                        </form>`;
                }
                bookmarkSection.innerHTML = newHtml;

                if (!isUnbookmark) {
                    const newIcon = bookmarkSection.querySelector('.fa-bookmark');
                    if (newIcon) newIcon.classList.add('icon-animate');
                }
            }
        });
    }

    // ----------------------------------------
    // コメント表示/非表示
    // ----------------------------------------
    function toggleCommentSection(button) {
        const postId = button.dataset.postId;
        const commentsContainer = document.getElementById(`comments-container-${postId}`);
        if (!commentsContainer) return;
        const isHidden = commentsContainer.style.display === "none";

        if (isHidden) {
            if (commentsContainer.dataset.loaded !== "true") {
                fetch(`/posts/${postId}/comments`)
                    .then((response) => response.json())
                    .then((comments) => {
                        const commentsList = commentsContainer.querySelector(".comments-list");
                        commentsList.innerHTML = "";
                        comments.forEach((comment) => {
                            const commentHtml = `
                                <div class="comment-item">
                                    <strong>@${comment.user.name}</strong>
                                    <span>${comment.content}</span>
                                </div>`;
                            commentsList.insertAdjacentHTML("beforeend", commentHtml);
                        });
                        commentsContainer.dataset.loaded = "true";
                    });
            }
            commentsContainer.style.display = "block";
        } else {
            commentsContainer.style.display = "none";
        }
    }

    // ----------------------------------------
    // 新規コメント投稿
    // ----------------------------------------
    function handleNewComment(form, event) {
        event.preventDefault();
        const input = form.querySelector('input[name="content"]');
        const content = input.value.trim();
        if (content === "") return;

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ content: content }),
        })
        .then(response => response.json())
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
        .catch((error) => console.error("Error:", error));
    }
});
