// Get the modal
var modal = document.getElementById("res_img_modal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var modalImg = document.getElementById("sample_photo");
var captionText = document.getElementById("img_caption");

// Radio Buttons
var all_row = document.getElementsByClassName("slct_row");
var slctd_row = [];

function showImgModal (val, type){
  modal.style.display = "block";
  modalImg.src = "../../file/load/img?type=view" + type + "&r_id=" + val;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("img-close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

function selectClick() {
  for(i = 0; i < all_row.length; i++) {
    if(all_row[i].checked) {
      all_row[i].checked = false;
    }
    all_row[i].disabled = false;
  }
}


function completeClick(tType) {
  for(i = 0; i < all_row.length; i++) {
    if(all_row[i].checked) {
      slctd_row.push(all_row[i].value);
    }
  }

  if(slctd_row.length > 0) {
    var rows = JSON.stringify(slctd_row);

    $.ajax({
      url: "../controllers/api/process-req",
      type: "POST",
      data: {
        id_rows: rows,
        type: tType
      },
      cache: false,
      success: function(dataResult) {
        var req_result;
        try {
          req_result = JSON.parse(dataResult);

          if(req_result.req_pro_status == 100) {
            window.location.reload();
          }
        } catch(err) {

        }
      }
    });
  }
}

function deleteClick(tType) {
  for(i = 0; i < all_row.length; i++) {
    if(all_row[i].checked) {
      slctd_row.push(all_row[i].value);
    }
  }

  if(slctd_row.length > 0) {
    var rows = JSON.stringify(slctd_row);

    $.ajax({
      url: "../controllers/api/process-req",
      type: "POST",
      data: {
        id_rows: rows,
        type: tType
      },
      cache: false,
      success: function(dataResult) {
        var req_result;
        try {
          req_result = JSON.parse(dataResult);

          if(req_result.req_pro_status == 100) {
            window.location.reload();
          }
        } catch(err) {

        }
      }
    });
  }
}
