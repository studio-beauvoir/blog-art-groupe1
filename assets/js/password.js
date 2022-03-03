// Affichage pass
function togglePassword(myInputPass) {
    var x = document.getElementById(myInputPass);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}