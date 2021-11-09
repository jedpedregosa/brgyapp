let cov_type = document.getElementById("slct_cov");

cov_type.onchange = function () {
    if(this.value == "Symptomatic") {
        document.getElementById("symp-div").style.display = "block";
        document.getElementById("asymp-div").style.display = "none";
    } else if(this.value == "Asymptomatic") {
        document.getElementById("asymp-div").style.display = "block";
        document.getElementById("symp-div").style.display = "none";
    }
}
