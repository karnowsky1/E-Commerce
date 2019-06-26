//remember - [0] - ?
// [1] - image
// [2- is the options



/**
    function that checks to make sure the selected node is the last node\
    removes all nodes until the node that is passed in is the last node
*/
function killer(dom){
    // this is where IE 7 breaks for my stuff
    //alert(dom); // why does this alert this?
    if(dom == data['init']){
        return;
    }
    while(!(dom === document.getElementById('selContainer').lastChild)){
        //node.removeChild() // ask about the syntax of how to do remove LastChild
        document.getElementById('selContainer').removeChild(document.getElementById('selContainer').lastChild);
        //ask if this is the right syntax for this
    }
}

/**
*  creates h2 tags and that tells the user what they're watching
*  by passing dom into the format for the h2 string
*  the h2 is dynamically created and then aended to the selContainer
**/
function displayResult(dom){
    var result = document.createElement('h2');
    result.setAttribute('class', 'displayResult');
    result.appendChild(document.createTextNode("Hey!"));
    document.getElementById('selContainer').appendChild(result);
    var result1 = document.createElement('h2');
    result1.setAttribute('class', 'displayResult');
    result1.appendChild(document.createTextNode("You're watching: " + dom));
    document.getElementById('selContainer').appendChild(result1);
    watchTV(dom);
}


/**
*  the value that the user is passed in, then reformmated so that it doesn't
*  have any spaces in it. I looked up how to do the regex line. Once the string
*  is reformatted it is then converted in a format to reference the image that
*  corresponds with the show that they chose. This images then changes the source
*  of the tv.
*
**/
function watchTV(dom){
    dom = dom.replace(/\s/g,''); // study how the regex works
    if(document.attachEvent){
        var srcString =  'assets/Shows/' + dom + '.png';
        img = createImg(srcString , 'TVshow', '10em', '10em');
        document.getElementById('TVcontainer').appendChild(img);
    }else{
        document.getElementsByTagName('img')[1].setAttribute('src', 'assets/Shows/' + dom + '.png');
    }
}


/**
* Creates a p tag with given text and then appends an input tags
* with given type and name value
**/
function formHelper(text, type, name){
    var words = document.createElement('p');
    //p.setAttribute('class','class for form p tags' );
    words.appendChild(document.createTextNode(text));
    //create the actual textbox for the form
    var text1 = document.createElement('input');
    text1.setAttribute('type', '' + type);
    text1.setAttribute('name', '' + name);
    words.appendChild(text1);
    return words;
}

/**
*  dynamiclly creates forms for firstname, lastname, and email
*  it calls formHelper to assist itad then appends it to
*  selContainer
**/

function formCreate(dom){
    displayResult(dom);
    var form = document.createElement('form'); // creaate a new element form
    form.setAttribute('action', '');
    form.setAttribute('method', 'GET');
    form.setAttribute('id', 'form1');
    form.setAttribute('name', 'form1');
    form.setAttribute('onsubmit', 'return validate();');
    //Create the text node for firstname
    form.appendChild(formHelper('First Name', 'text', 'firstname'));
    form.appendChild(formHelper('Last Name', 'text', 'lastname'));
    form.appendChild(formHelper('Email', 'text', 'email'));
    //create a submit button
    var submitButton = document.createElement('input');
    submitButton.setAttribute('type', 'submit');
    submitButton.setAttribute('value', 'Submit');
    submitButton.setAttribute('style', 'float: right;');
    // set the submit = to this thing
    form.appendChild(submitButton);
    //append the form to the page
    form.setAttribute('class', 'formStyle');
    document.getElementById('selContainer').appendChild(form);
}

function validate(){
    document.getElementById("form1")['firstname'].style.backgroundColor = "";
    document.getElementById("form1")['lastname'].style.backgroundColor = "";
    document.getElementById("form1")['email'].style.backgroundColor = "";
    //After validation save to local storage and chache for IE 7
    var fname = document.getElementById('form1')["firstname"].value;
    var lname = document.getElementById('form1')["lastname"].value;
    var emailer = document.getElementById('form1')["email"].value;
    if(fname == "" || fname == null){ //CHECKS if Email address Submited is null
        document.getElementById("form1")['firstname'].style.backgroundColor = "red";
        alert("Please Enter a valid First Name");
        return false;
    }else if(lname == "" || lname == null){ //CHECKS if Email address Submited is null
        document.getElementById("form1")['lastname'].style.backgroundColor = "red";
        alert("Please Enter a valid Last Name");
        return false;
    }else if(emailer == "" || emailer == null){ //CHECKS if Email address Submited is null
    document.getElementById("form1")['email'].style.backgroundColor = "red";
    alert("Please Enter An Email Address");
    return false;
}else{
        //Validation Succeded -- Save to localstorage and to cahce for IE 7
        if(document.attachEvent){
            document.setCookie('fname',fname);
            document.setCookie('lname',lname);
            document.setCookie('emailer',emailer);
        }else{
            window.localStorage.setItem("SaveEmail", emailer);
            console.log(localStorage.getItem("SaveEmail"));
            window.localStorage.setItem("Savefname", fname);
            console.log(localStorage.getItem("Savefname"));
            window.localStorage.setItem("Savelname", emailer);
            console.log(localStorage.getItem("Savelname"));ss
        }
	}
    // validateHelper(fname,'firstname');
    // validateHelper(lname, 'lastname');
    // validateHelper(emailer, 'email');
}

function validateHelper(dom,domTagName){
    if(dom == "" || dom == null){ //CHECKS if Email address Submited is null
        document.getElementById("form1")[domTagName].style.backgroundColor = "red";
        alert("Please Enter a valid " + domTagName);
        return false;
    }else{
    	//Validation Succeded -- Save to localstorage and to cahce for IE 7
    	if(document.attachEvent){
    			document.SetCookie = dom;
    	}else{
    	window.localStorage.setItem("SaveEmail", emailer);
    	console.log(localStorage.getItem("SaveEmail"));
    	}
  	}
}

function selCreate(dom){
    killer(dom);
    var thisData = data[dom.value];
    var sel=document.createElement('select');

    //<select></select>
    //sel.setAttribute('something','value');
    //<select something="value"></select>
    sel.onchange=function(){selCreate(this);}
    //<select something="value" onchange="selCreate(this)"></select>
    /**
    //while(data.vale.next) --> next idea
    **/
    if(undefined !== thisData  && thisData.length){
        for(var i = 1, len = thisData.length; i < len; i++){
            //instantiate an option element
            var o = document.createElement('option');
            //<option></option>
            o.setAttribute('value',thisData[i]);
            //<option value="Nickelodeon"></option>
            o.appendChild(document.createTextNode(thisData[i]));
            //<option value="Nickelodeon">Nickelodeon</option>
            sel.appendChild(o);
            /* from one interation
            <select something="value" onchange="selCreate(this)">
            <option value="Nickelodeon">Nickelodeon</option>
            </select>
            */
        }
        document.getElementById('selContainer').appendChild(sel);
    }

    // if(dom.value == thisData[thisData.length-1]){
    //     formCreate();
    // }
    if((thisData == undefined && dom.value !== dom[0].value)){
        //alert(dom[0].value);
        // dom.value vs dom[0].value ask Dan about this
        formCreate(dom.value);
    }
}
/**
*  init method takes care of power button functionality
*  it checks the status of the power button and then inverses it
*  if the user is turning the program 'on', the first select will
*  be dynamically created.
*  Otherwise the killer method will remove all nodes except for the
*  power button
**/
function init(dom, state){
    if (state == 'off') {
        document.getElementsByTagName('img')[1].setAttribute('src', 'assets/TVs/TV2.gif');
        currentState = 'on';
        var sel = document.createElement('select');
        if(document.attachEvent){
            sel.attachEvent("onchange", function() {
                selCreate(this);
            });
            return;
        }else{
            document.getElementById('selContainer').setAttribute("class", "selStyle");
            sel.setAttribute("onchange", "selCreate(this)");
        }
        for(var i = 1, len = dom.length; i < len; i++ ){
            var o = document.createElement('option');
            o.setAttribute("value", dom[i]);
            o.appendChild(document.createTextNode(dom[i]));
            sel.appendChild(o);
        }
        //var img = document.createElement('img');
        //img.setAttribute('src', '')
        document.getElementById('selContainer').appendChild(sel);
    }else{
        document.getElementsByTagName('img')[1].setAttribute('src', 'assets/TVs/TV_OFF.png');
        currentState = 'off';
        killer(document.getElementsByTagName('img')[0]);
    }

}
/**
* Init for ie 7 creates a select and assigns selcreate to the onchanges
* it then dynamically populates the list to the selContainer div
*
**/
function initIE7(dom){
    var sel = document.createElement('select');
    sel.setAttribute("onchange", function() {
        selCreate(this);
    });
    document.getElementById('selContainer').setAttribute("class", "selStyle");
    for(var i = 1, len = dom.length; i < len; i++ ){
        var o = document.createElement('option');
        o.setAttribute("value", dom[i]);
        o.appendChild(document.createTextNode(dom[i]));
        sel.appendChild(o);
    }
    document.getElementById('selContainer').appendChild(sel);
}
/**
* Helper function that helps me create images cause i'm lazy
**/

function createImg(src, alt, width, height){
    var img = document.createElement('img');
    img.setAttribute('src', src);
    img.setAttribute('alt', alt);
    img.setAttribute('width', width);
    img.setAttribute('height', height);
    return img;
    // test out using this
}

/**
*  redirects user if browser is too old. check if user is using IE7
*  and uses corresponding init function. Otherwise it creates a powerButton
*  immage ad sets the init function to the onclick for that button
*
**/

function powerButton(){
    if(!document.getElementById){
        alert("please download a modern Web Browser");
        window.location = "https://www.mozilla.org/en-US/firefox/new/";
    }
    if(document.attachEvent){
        initIE7(data['init']);
    }else{
        img = createImg('assets/Power-Button/PowerButton.png', 'power button', '30em', '30em');
        img.setAttribute('class', 'powerButton');
        img.setAttribute('onclick', "init(data['init'], currentState)");
        document.getElementById('selContainer').appendChild(img);
        var img = createImg('assets/TVs/TV_OFF.png', 'TV');
        document.getElementById('TVcontainer').appendChild(img);
    }
    // }else{
    //     alert("please download a modern Web Browser");
    //     window.location = "https://www.mozilla.org/en-US/firefox/new/";
    // }
}

/*
    to start in HTML

    <select onchange="selCreate(this)">
    <option value="80's">80's</option>
    <option value="90's">90's</option>
    <option value="2000's">2000's</option>
    </select>
*/
