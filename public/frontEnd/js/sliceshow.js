var slideIndex = 1;
ashowSlides(slideIndex);

// Next/previous controls
function aplusSlides(n) {
  ashowSlides(slideIndex += n);
}

// Thumbnail image controls
function acurrentSlide(n) {
  ashowSlides(slideIndex = n);
}

function ashowSlides(n) {
    var i;
    var aslides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > aslides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = aslides.length}
    for (i = 0; i < aslides.length; i++) {
        aslides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    aslides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
  }