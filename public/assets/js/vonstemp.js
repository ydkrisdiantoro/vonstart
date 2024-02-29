$(document).ready(function () {
    $('#btnToggleSidebar').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $('#navbar').toggleClass('active');
    });
    $('#btnDismissSidebar').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
        $('#navbar').toggleClass('active');
    });
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