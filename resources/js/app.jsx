import './bootstrap';

function toggleSearch() {
    var searchForm = document.getElementById("searchForm");
    if (searchForm.style.display === "none" || searchForm.style.display === "") {
        searchForm.style.display = "block";
    } else {
        searchForm.style.display = "none";
    }
}
