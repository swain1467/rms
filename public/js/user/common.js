function openNav() {
    let x = document.getElementById("mySidepanel");
    if (x.style.width === "100%") {
        $('#navBar').html('<i class="fa fa-bars"></i>');
        x.style.width = "0";
    } else {
        $('#navBar').html('<i class="fa fa-times"></i>');
        x.style.width = "100%";
    }
}