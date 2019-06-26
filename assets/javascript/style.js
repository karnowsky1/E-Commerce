
/**
  Function used to toggle the class for .hamburger
  Causes animation for hamburger
  Also used to check position of hamburger and adjust
  position when pressed
**/

function mobileNav(x) {
    x.classList.toggle("change");
    if(document.getElementById("nav-inner").style.right == ""){
        document.getElementById("nav-inner").style.right = "0px";
    }else if(document.getElementById("nav-inner").style.right == "-130px"){
        document.getElementById("nav-inner").style.right = "0px";
    }else if(document.getElementById("nav-inner").style.right == "0px"){
        document.getElementById("nav-inner").style.right = "-130px";
    }
    document.getElementById("nav-inner").style.transition = ".5s";
}

/**
  Function used to check if user is trying to
  pass in an empty string
**/

function validate() {
    // Is there any value in the input?
    // The appearance of s in Element(s) determines whether array or not
    // document.getElementsByName (ARRAY)
    // document.getElementsByClassName (ARRAY)
    // document.getElementById (NOT AN ARRAY)
    if (document.getElementsByTagName('input')[0].value == '' || document.getElementsByTagName('input')[1].value == ''){
        document.getElementById('comment').style.borderColor = 'red';
        return false;
    } else {
        return true;
    }
}
