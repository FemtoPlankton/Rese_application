// カードごとにフォームのデータが変更されたかどうかを格納するオブジェクト
const formChanges = {};

// edit-button クラスを持つすべてのボタンを取得し、イベントリスナーを追加する
// 編集ボタンのクリックイベントを親要素に設定
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('edit-button')) {
        // クリックされた要素が編集ボタンの場合
        const card = event.target.closest('.reservation-card');
        if (card) {
            // カードが見つかった場合
            const reservationId = card.dataset.reservationId;
            switchToEditMode(reservationId, card);
        }
    }
});

// フォームの変更を監視する関数
function watchFormChanges(reservationId) {
    const form = document.querySelector(`#form-${reservationId}`);
    const inputs = form ? form.querySelectorAll('input, select') : [];
    formChanges[reservationId] = false;

    inputs.forEach(function (input) {
        input.addEventListener('change', function () {
            formChanges[reservationId] = true;
        });
    });
}

// 編集モードへ切り替える関数
function switchToEditMode(reservationId, card) {
    // 編集モードへの切り替え処理をここに記述
    card.querySelector('.editable-section').classList.remove('hidden');
    card.querySelector('.readonly-section').classList.add('hidden');
    // フォームの変更を監視する
    watchFormChanges(reservationId);
}

// 表示モードへ切り替える関数
function switchToDisplayMode(reservationId, card) {
    // 表示モードへの切り替え処理をここに記述
    const editableSection = card.querySelector('.editable-section');
    const readonlySection = card.querySelector('.readonly-section');

    editableSection.classList.add('hidden');
    readonlySection.classList.remove('hidden');
}

// 保存ボタンのクリックイベントを親要素に設定
document.addEventListener('submit', function (event) {
    if (event.target.classList.contains('reservation-form')) {
        // クリックされた要素がフォームの場合
        const card = event.target.closest('.reservation-card');
        if (card) {
            // カードが見つかった場合
            const reservationId = card.dataset.reservationId;
            // フォームデータが変更されていない場合は表示モードへ切り替える
            if (!formChanges[reservationId]) {
                switchToDisplayMode(reservationId, card);
                // フォームの送信をキャンセル
                event.preventDefault();
            }
        }
    }
});
