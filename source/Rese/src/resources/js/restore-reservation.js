document.querySelectorAll('.restore').forEach(item => {
    item.addEventListener('click', event => {
        const reservationId = item.dataset.reservationId;
        restoreReservation(reservationId);
    })
})

function restoreReservation(reservationId) {
    if (confirm('元に戻しますか？')) {
        // Bladeで設定したCSRFトークンを取得
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Ajaxリクエストを送信
        fetch(`/reservations/${reservationId}/restore`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token // 取得したCSRFトークンを使用
            },
            body: JSON.stringify({
                _method: 'PUT'
            })
        })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    console.error('失敗しました。');
                }
            })
            .catch(error => {
                console.error('失敗しました。', error);
            });
    }
}
