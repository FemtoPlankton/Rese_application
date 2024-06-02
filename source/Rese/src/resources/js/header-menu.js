if (document.getElementById('menu_button')){
    document.getElementById('menu_button').addEventListener('click', function () {
        document.getElementById('overlay_menu').classList.toggle('hidden');
    });

    document.getElementById('close_button').addEventListener('click', function () {
        document.getElementById('overlay_menu').classList.toggle('hidden');
    });
};

