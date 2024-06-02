document.addEventListener('DOMContentLoaded', function () {
    // キャンセルアイコンをクリックしたときの処理を追加
    document.querySelectorAll('.cancel-reservation').forEach(icon => {
        icon.addEventListener('click', function (e) {
            e.preventDefault();
            const reservationId = this.dataset.reservationId; // キャンセル対象の予約IDを取得
            if (!reservationId) {
                console.error('reservation ID not found');
                return;
            }
            // 確認メッセージを表示してユーザーがキャンセルを確認した場合にのみ予約をキャンセルする
            if (confirm('予約をキャンセルしますか？')) {
                cancelReservation(reservationId);
            }
        });
    });

    // 予約をキャンセルする関数
    function cancelReservation(reservationId) {


        // リクエストを送信して予約をキャンセルする
        fetch(`/reservations/${reservationId}/cancel`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to cancel reservation');
                }
                return response.json();
            })
            .then(data => {
                alert(data.message);
                location.reload();
            })
            .catch(error => {
                console.error('Error cancelling reservation:', error);
                alert('予約のキャンセルに失敗しました。');
            });
    }
});
