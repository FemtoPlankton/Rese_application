document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    if (dateInput) {
        const reservationForm = document.getElementById('reservation-form');
        const selectedDateElement = document.getElementById('selected-date');
        const selectedTimeElement = document.getElementById('selected-time');
        const selectedNumberElement = document.getElementById('selected-number');

        // 予約フォームが変更されたときの処理
        function displayReservationInfo() {
            // 予約日、予約時間、人数を取得
            const selectedDate = document.getElementById('date').value;
            const selectedTime = document.getElementById('time').options[document.getElementById('time').selectedIndex].value;
            const selectedNumber = document.getElementById('number').options[document.getElementById('number').selectedIndex].value;

            // 取得した予約日、予約時間、人数をp要素に表示
            selectedDateElement.textContent = selectedDate;
            selectedTimeElement.textContent = selectedTime;
            selectedNumberElement.textContent = `${selectedNumber}人`;
        }

        const currentDate = new Date();
        const nextDay = new Date(currentDate.setDate(currentDate.getDate() + 1));
        const nextDayFormatted = nextDay.toISOString().split('T')[0];
        document.getElementById('date').value = nextDayFormatted;

        displayReservationInfo();

        reservationForm.addEventListener('change', function () {
            displayReservationInfo();
        });
    }
});

