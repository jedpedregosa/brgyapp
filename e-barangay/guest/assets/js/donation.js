
let donation_type = document.getElementById("slct_donation");

donation_type.onchange = function () {
    if(this.value == "dntn1") {
        document.getElementById("kind-div").style.display = "block";
        document.getElementById("charity-div1").style.display = "none";
        document.getElementById("charity-div2").style.display = "none";
    } else if(this.value == "dntn2") {
        document.getElementById("charity-div1").style.display = "block";
        document.getElementById("charity-div2").style.display = "block";
        document.getElementById("kind-div").style.display = "none";
    }
}