var slideIndex = 0;

showDivs();

function showDivs() {
  var i;
  var x = document.getElementsByClassName("sliders");
  for(i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  slideIndex++;
  if(slideIndex > x.length - 1) {
      slideIndex = 0;
  }
  x[slideIndex].style.display = "block";
  setTimeout(showDivs, 3000); // Change image every 2 seconds
}