
window.addEventListener("scroll", function () {
    if (scrollY > 45) {
      document.getElementsByClassName("header")[0].classList.add("sticky");
    } else {
      document.getElementsByClassName("header")[0].classList.remove("sticky");
    }
  });

  // --------------------------------------------------------------------------

document.getElementById("language_vi").addEventListener("click", myFunction);
function myFunction () {
    console.log(window.location.hostname);
}
