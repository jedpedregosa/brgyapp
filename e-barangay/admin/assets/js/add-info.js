let cov_type = document.getElementById("slct_cov");

// Search field
let txt_search = document.getElementById("txtSearch");

// Search dropdown
let dropdown = document.getElementById("search-content");

cov_type.onchange = function () {
    if(this.value == "Symptomatic") {
        document.getElementById("symp-div").style.display = "block";
        document.getElementById("asymp-div").style.display = "none";
    } else if(this.value == "Asymptomatic") {
        document.getElementById("asymp-div").style.display = "block";
        document.getElementById("symp-div").style.display = "none";
    }
}

txt_search.onkeyup = function () {
    if(this.value) {
        $.ajax({
            url: "../controllers/api/get-resident",
            type: "POST",
            data: {
              s_val: this.value
            },
            cache: false,
            success: function(dataResult) {
              var req_result;
              try {
                req_result = JSON.parse(dataResult);
                dropdown.innerHTML = '';

                if(req_result.req_pro_status == 100) {
                  if(req_result.req_pro_val) {
                      var res_val = req_result.req_pro_val;
                      console.log(res_val);
                      for(var i = 0; i < res_val.length; i++) {
                        var row_res = document.createElement("A");
                        row_res.href = 'add-covid-info?r_id=' + res_val[i]['resUname'];
                        var img_val = "<img class = 'search-img' src = '../../file/load/img?type=view1&r_id=" + res_val[i]['hash_id'] + "' />"
                        row_res.innerHTML = img_val + res_val[i]['resLname'] + ', ' + res_val[i]['resFname'];
                        dropdown.appendChild(row_res);
                      }
                  }
                }
              } catch(err) {
      
              }
            }
          });
        dropdown.style.display = 'block';   
    } else {
        dropdown.style.display = 'none';
    }
}
