if (document.getElementById('searchForm')) {
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('areaSelect').addEventListener('change', function () {
            document.getElementById('searchForm').submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('genreSelect').addEventListener('change', function () {
            document.getElementById('searchForm').submit();
        });
    });
}
