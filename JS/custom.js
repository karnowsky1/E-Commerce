var data = new Object();
data['init'] = ['--Select Your Carrier--', 'Verizon', 'Verizon', 'Sprint', 'Sprint', 'At&T', 'At&T', 'T-Mobile', 'T-Mobile']; //What carrier are you on
//[q,opt,opt,opt]
//q,optval,opttext,optval2,opttext2,,,]
//<option value="optval">opttext</option>
data['Sprint'] 		= ['--Mobile OS--', 'androidSprint', 'android', 'iphoneSprint', 'iphone', 'windowsSprint', 'Windows Phone'];
data['At&T'] 			= ['--Mobile OS--', 'androidAt&T', 'android', 'iphoneAt&T', 'iphone', 'windowsAt&T', 'Windows Phone'];
data['T-Mobile'] 	= ['--Mobile OS--', 'androidT-Mobile', 'android', 'iphoneT-Mobile', 'iphone', 'windowsT-Mobile', 'Windows Phone'];
data['Verizon'] 	= ['--Mobile OS--', 'androidVerizon', 'android', 'iphoneVerizon', 'iphone', 'windowsVerizon', 'Windows Phone'];

data['androidSprint'] 	= ['--Select Phone Manufacturer--', 'Samsung', 'Samsung', 'LG', 'LG', 'Motorola', 'Motorola']; //What manufacture makes your phone
data['androidAt&T'] 		= ['--Select Phone Manufacturer--', 'Samsung', 'Samsung', 'LG', 'LG', 'Motorola', 'Motorola']; //What manufacture makes your phone
data['androidT-Mobile'] = ['--Select Phone Manufacturer--', 'Samsung', 'Samsung', 'LG', 'LG', 'Motorola', 'Motorola']; //What manufacture makes your phone
data['androidVerizon'] 	= ['--Select Phone Manufacturer--', 'Samsung', 'Samsung', 'LG', 'LG', 'Motorola', 'Motorola']; //What manufacture makes your phone

data['iphoneSprint'] 		= ['--Select Storage Size--', '16 GB', '16 GB', '32 GB', '32 GB', '64 GB', '64 GB', '128 GB', '128 GB']; //print results
data['iphoneAt&T'] 			= ['--Select Storage Size--', '16 GB', '16 GB', '32 GB', '32 GB', '64 GB', '64 GB', '128 GB', '128 GB']; //print results
data['iphoneT-Mobile'] 	= ['--Select Storage Size--', '16 GB', '16 GB', '32 GB', '32 GB', '64 GB', '64 GB', '128 GB', '128 GB']; //storage size then print results
data['iphoneVerizon'] 	= ['--Select Storage Size--', '16 GB', '16 GB', '32 GB', '32 GB', '64 GB', '64 GB', '128 GB', '128 GB']; //storage size then print results

data['windowsSprint'] 	= ['--Why Did you Choose the Windows Phone?--', 'I bought this phone because was confused', 'I bought this phone because was confused', 'I regret it, I made a Mistake', 'I regret it, I made a Mistake', 'I bought it because I actually Like it for some reason', 'I bought it because I actually Like it for some reason']; // print results
data['windowsAt&T'] 		= ['--Why Did you Choose the Windows Phone?--', 'I bought this phone because was confused', 'I bought this phone because was confused', 'I regret it, I made a Mistake', 'I regret it, I made a Mistake', 'I bought it because I actually Like it for some reason', 'I bought it because I actually Like it for some reason']; // print results
data['windowsT-Mobile'] = ['--Why Did you Choose the Windows Phone?--', 'I bought this phone because was confused', 'I bought this phone because was confused', 'I regret it, I made a Mistake', 'I regret it, I made a Mistake', 'I bought it because I actually Like it for some reason', 'I bought it because I actually Like it for some reason']; // print results
data['windowsVerizon'] 	= ['--Why Did you Choose the Windows Phone?--', 'I bought this phone because was confused', 'I bought this phone because was confused', 'I regret it, I made a Mistake', 'I regret it, I made a Mistake', 'I bought it because I actually Like it for some reason', 'I bought it because I actually Like it for some reason']; // print results

data['Samsung']  	= ['--Select Phone--','GS4', 'GS4', 'GS3','GS3', 'GS2', 'GS2', 'Galaxy Note', 'other', 'IDK'];  //print results
data['LG']      	= ['--Select Phone--','GS4', 'GS4', 'GS3','GS3', 'GS2', 'GS2', 'Galaxy Note', 'other', 'IDK'];  //print results
data['Motorola'] 	= ['--Select Phone--','GS4', 'GS4', 'GS3','GS3', 'GS2', 'GS2', 'Galaxy Note', 'other', 'IDK'];  //print results

//sel.onchange = onchange//   // pass onchange into create
function printResultsOnPage(){
  var allSel = document.getElementById("placeholder").getElementsByTagName('select'); //div with all of selects
  //var allSel = document.getElementsByTagName('body')[0].firstChild; //div with all of selects
  var outputDiv = document.createElement("div");
  var h22 = document.createElement("h2");
  var resultsText = document.createTextNode("Results:");
  h22.appendChild(resultsText);
  outputDiv.className = 'outputBox';
  outputDiv.appendChild(h22);
  for (i = 0; i < allSel.length; i++){
    //console.log(allSel[i].options[allSel[i].selectedIndex].firstChild.nodeValue);
    var pElement = document.createElement("p");
    var outputValue = allSel[i].options[allSel[i].selectedIndex].firstChild.nodeValue;
    var printTextNode = document.createTextNode(outputValue);

    pElement.appendChild(printTextNode);
    outputDiv.appendChild(pElement);
  }
  document.getElementsByTagName('body')[0].appendChild(outputDiv);
}

function createSelect(dom){
  if (!document.getElementById){
    console.log('IT WORKSSADAKJHSGDKJGS')
    alert('Please Download an Updated Browser');
    window.location = "https://www.google.com/chrome/browser/desktop/";
  }else{

    if (dom == 'init'){
      var hold = data['init'];
    }else{
      var hold = data[dom.value];
			//removes the selects
      while (dom != dom.parentNode.lastChild){
        dom.parentNode.removeChild(dom.parentNode.lastChild);
				//if the result was already printed, this removes it.
        if (document.getElementsByTagName("BODY")[0].lastChild.getAttribute("class") === 'outputBox'){
          document.getElementsByTagName("BODY")[0].removeChild(document.getElementsByTagName("BODY")[0].lastChild);
        }
      }
    }

    if (hold != undefined){
      var sel = document.createElement('select');
      //loop on the length of hold
      //create the option
      //give the option an attribute (value)
      //put text in the option
      //put option in the select
      //end loop
      for (var i = 0; i < hold.length; i += 2){
        var currOption = document.createElement("option");
        currOption.setAttribute("value", hold[i - 1]);
        var myTextNode = document.createTextNode(hold[i]);
        currOption.appendChild(myTextNode);
        sel.appendChild(currOption);
      }
      sel.className = 'box';

      //This makes it work in IE, IE7 is set to true in the IE condintial
      if (IE7){
        sel.setAttribute('onchange', function(){
          createSelect(this);
        }); //IE 7
      }else{
        sel.setAttribute('onchange', 'createSelect(this);');      //dont do this
      }
      document.getElementById('placeholder').appendChild(sel);
    }else{
      printResultsOnPage();
    }
  }
}

function validateForm(dom,){
  //After validation save to local storage and chache for IE 7
  var emailer = document.getElementById('form1')["email"].value;
  if (emailer == "" || emailer == null){ //CHECKS if Email address Submited is null
    document.getElementById("inputfield").style.backgroundColor = "red";
    alert("Please Enter An Email Address");

    return false;
  }else{
			//Validation Succeded -- Save to localstorage and to cahce for IE 7
			if(IE7){
					document.cookie = emailer;
			}else{
			window.localStorage.setItem("SaveEmail", emailer);
			console.log(localStorage.getItem("SaveEmail"));

			}
	}
}
