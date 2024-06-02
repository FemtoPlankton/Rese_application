document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-button').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const isFavorited = JSON.parse(this.dataset.favorited);
            const restaurantId = this.dataset.restaurant;
            const url = isFavorited ? `/restaurants/${restaurantId}/delete` : `/restaurants/${restaurantId}/add`;

            fetch(url, {
                method: isFavorited ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'content-type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (isFavorited) {
                        removeFromFavorites(this, data);
                    } else {
                        addToFavorites(this, data);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});

function addToFavorites(button, data) {
    const icon = button.querySelector('i');
    button.dataset.favorited = 'true';
    icon.classList.remove('icon-grey');
    icon.classList.add('icon-red');
}

function removeFromFavorites(button, data) {
    const icon = button.querySelector('i');
    button.dataset.favorited = 'false';
    icon.classList.remove('icon-red');
    icon.classList.add('icon-grey');
}
