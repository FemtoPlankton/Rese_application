async function submitSearchForm() {
    const formData = new FormData(document.getElementById('searchForm'));
    try {
        const response = await fetch('/restaurants/search', {
            method: 'POST',
            headers: {
                'accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        });
        const data = await response.json();
        updateSearchResults(data);
    } catch (error) {
        console.error('Error:', error);
    }
}

function updateSearchResults(data) {
    document.getElementById('searchForm').submit();
    console.log(data);
}

document.addEventListener('DOMContentLoaded', () => {
    const selectElements = document.querySelectorAll('#searchForm select');
    selectElements.forEach(select => {
        select.addEventListener('change', submitSearchForm);
    })
})
