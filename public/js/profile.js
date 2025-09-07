// DOMが読み込まれてから処理を開始
document.addEventListener('DOMContentLoaded', function() {

    // 最初に必要な要素を一度だけ取得しておく
    const menu = document.getElementById('menu');
    const menuToggle = document.querySelector('.menu-toggle');

    // 要素が見つからない場合は、エラーを防ぐために処理を中断
    if (!menu || !menuToggle) {
        return;
    }

    // --- メニューを開閉する関数 ---
    function toggleMenu() {
        menu.classList.toggle('active');
    }

    // --- メニューを閉じる関数 ---
    function closeMenu() {
        menu.classList.remove('active');
    }

    // --- イベントリスナーの設定 ---

    // 1. メニューボタンがクリックされたら、メニューを開閉する
    menuToggle.addEventListener('click', function(event) {
        // クリックイベントが document まで伝わらないように停止
        event.stopPropagation();
        toggleMenu();
    });

    // 2. ドキュメント全体がクリックされた時の処理
    document.addEventListener('click', function(event) {
        // クリックされた場所が「メニュー要素の外側」であるかを確認
        // isClickInsideMenu が false なら外側がクリックされたということ
        const isClickInsideMenu = menu.contains(event.target);

        if (!isClickInsideMenu) {
            closeMenu();
        }
    });
});

// DOMが完全に読み込まれてから、すべての処理を一度だけ実行する
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | メニュー関連の処理
    |--------------------------------------------------------------------------
    */
    const menu = document.getElementById('menu');
    const menuToggle = document.querySelector('.menu-toggle'); // あなたのHTMLにこのクラスがあることを想定

    // メニューを開閉する関数
    function toggleMenu() {
        if (menu) menu.classList.toggle('active');
    }

    // メニューを閉じる関数
    function closeMenu() {
        if (menu) menu.classList.remove('active');
    }

    // メニュー外をクリックしたときにメニューを閉じる
    document.addEventListener('click', function (event) {
        // menuToggleが存在し、クリックされた要素がmenuToggleまたはその子要素の場合にメニューを開閉
        if (menuToggle && menuToggle.contains(event.target)) {
            toggleMenu();
        }
        // メニュー自体とトグルボタン以外がクリックされた場合はメニューを閉じる
        else if (menu && !menu.contains(event.target)) {
            closeMenu();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | プロフィール更新フォーム関連の処理
    |--------------------------------------------------------------------------
    */
    // 必要なHTML要素をIDで正確に取得する
    const profileForm = document.getElementById('profileForm');
    if (!profileForm) {
        // フォームが見つからない場合は、以降の処理を中断
        console.error('Profile form with ID "profileForm" not found.');
        return;
    }

    const profileImage = document.getElementById('profileImage');
    const profileInput = document.getElementById('profileInput');
    const editableTexts = document.querySelectorAll('.editable-text');
    const submitButton = profileForm.querySelector('button[type="submit"]');

    // --- 1. AJAXによるフォーム送信処理 ---
    profileForm.addEventListener('submit', function (event) {
        // ★★★★★ これが最も重要: デフォルトのページリロードをキャンセル ★★★★★
        event.preventDefault();

        const originalButtonText = submitButton.textContent;
        submitButton.textContent = '保存中...';
        submitButton.disabled = true;

        // フォームの送信先URLをaction属性から取得
        const url = profileForm.action;
        // フォームの全データを一括で取得
        const formData = new FormData(profileForm);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            alert(data.message || '保存しました！');
        })
        .catch(error => {
            console.error('Error:', error);
            if (error.errors) {
                const errorMessages = Object.values(error.errors).map(e => e[0]).join('\n');
                alert(errorMessages);
            } else {
                alert('保存に失敗しました。');
            }
        })
        .finally(() => {
            submitButton.textContent = originalButtonText;
            submitButton.disabled = false;
        });
    });


    // --- 2. 画像プレビュー機能 ---
    if (profileImage && profileInput) {
        profileImage.addEventListener('click', function () {
            profileInput.click();
        });

        profileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    profileImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }


    // --- 3. テキストのインライン編集機能 ---
    editableTexts.forEach(textElement => {
        const inputElementId = textElement.dataset.target;
        const inputElement = document.getElementById(inputElementId);

        if (!inputElement) return;

        textElement.addEventListener('click', () => {
            textElement.style.display = 'none';
            inputElement.style.display = 'block';
            inputElement.focus();
        });

        inputElement.addEventListener('blur', () => {
            const newValue = inputElement.value;

            if (inputElement.tagName.toLowerCase() === 'textarea') {
                textElement.innerHTML = newValue.replace(/\n/g, '<br>');
            } else if (inputElement.name === 'username') {
                textElement.textContent = '@' + newValue;
            } else {
                textElement.textContent = newValue;
            }

            inputElement.style.display = 'none';
            textElement.style.display = 'block';
        });
    });

});
