// Menu side button
var selct = document.getElementById("tool_slct");
var move = document.getElementById("tool_move");
var dlte = document.getElementById("tool_dlte");

// Radio Buttons
var all_row = document.getElementsByClassName("slct_row");
var slctd_row = [];

selct.onclick = function () {
    for(i = 0; i < all_row.length; i++) {
        if(all_row[i].checked) {
            all_row[i].checked = false;
        }
        all_row[i].disabled = false;
    }
}

if(move) {
  move.onclick = function () {
    controllerCall("4");
  }
}
  
dlte.onclick = function () {
    controllerCall("5");
}

function controllerCall(str) {
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
            type: str
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
