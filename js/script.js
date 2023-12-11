document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get("error");
    console.log(errorMessage)
    let toast = document.getElementById("error-toast");
    if (errorMessage) {
        toast.style.opacity = 1;
    } else {
        document.getElementById("toast-container").style.display = "none";
        toast.style.opacity = 0;
    }
});
