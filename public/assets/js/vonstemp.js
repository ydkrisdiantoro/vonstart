document.addEventListener('DOMContentLoaded', function () {
    const btnToggleSidebar = document.getElementById('btnToggleSidebar');
    const btnDismissSidebar = document.getElementById('btnDismissSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const navbar = document.getElementById('navbar');

    function toggleClasses() {
        sidebar.classList.toggle('active');
        content.classList.toggle('active');
        navbar.classList.toggle('active');
    }

    btnToggleSidebar.addEventListener('click', toggleClasses);
    btnDismissSidebar.addEventListener('click', toggleClasses);
});


function searchMenu() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("searchMenu");
    filter = input.value.toLowerCase();
    sidebarMenu = document.getElementById("sidebarMenu");
    menus = sidebarMenu.getElementsByTagName("a");

    for (i = 0; i < menus.length; i++) {
        span = menus[i].getElementsByTagName("span")[0];
        namaMenu = span.innerText.toLowerCase();
        if (namaMenu.indexOf(filter) > -1) {
            menus[i].style.display = "";
        } else {
            menus[i].style.display = "none";
        }
    }
}