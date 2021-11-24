// Get the modal
var modal = document.getElementById("res_img_modal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("sample_photo");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("img-close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

var slideIndex = 0;
    showSlides();
    
    function showSlides() {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";  
      dots[slideIndex-1].className += " active";
      setTimeout(showSlides, 2000); // Change image every 2 seconds
    }

function showImgModal(val, type){
  
  modal.style.display = "block";
  modalImg.src = "../file/POST/post_photo?type=view" + type + "&p_id=" + val;
}
