let close = document.getElementById("img-close");
let modal = document.getElementById("res_img_modal");

function showImgModal (val){
    let modalImg = document.getElementById("sample_photo");   

    modal.style.display = "block";
    modalImg.src = val;
}

close.onclick = function () {
    modal.style.display = "none";
}