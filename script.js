  var ClickedObj;
  var ClickedObj_prefix;
  if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
	browser="chrome";
  else if (navigator.userAgent.toLowerCase().indexOf('windows') > -1)
	browser="ie";
  else
	browser="other";
	
//sessvars.$.debug();
  function formatCells(xls,type,line,column){ // xls = paste/keystroke, type = vlans or ports
	if (xls.length==0){
		return;
	}
	var Enter_Pressed=0;
	var arrLines = xls.split(/\n/g); 
	for(var l=0;l<arrLines.length;l++){
		if ((l == ( arrLines.length - 1) ) && (arrLines[l].length==0)){ // if this is the last line that copied from excel(it's empty)
			break;
		}
		arrLines[l]=arrLines[l].replace("\r","");
		var arrColumns = arrLines[l].split(/\t/gi);
		if (arrLines.length<3 && arrColumns.length==1 ){ // it is not paste (When pressinf Enter, at IE it's 1 line, at Chrome it's 2)
			//alert ("It is not paste");
			if (!((xls.charCodeAt(xls.length - 1)==10) || (xls.charCodeAt(xls.length - 1)==13))){
				return; // break only if Enter not pressed, if it pressed go 1 line down
			}
			else {
				//alert ("Enter");
				Enter_Pressed=1; // 
				//document.forms[0].elements[type + (line + 1) + "_" + (column)].focus();
			}
		}
		for(var c=0;c<arrColumns.length;c++){  
			if (document.forms[0].elements[type + (l+line) + "_" + (c+column)]){
				document.forms[0].elements[type + (l+line) + "_" + (c+column)].value = arrColumns[c];  
			}
		}
	}
	//alert (type + (l+line ) + "_" + (c+column - 1));
	if(document.forms[0].elements(type + (l+line - 1 + Enter_Pressed) + "_" + (c+column - 1))){ // if Element exist
		document.forms[0].elements[type + (l+line - 1 + Enter_Pressed) + "_" + (c+column - 1)].focus();
	}
  }  
  
  function save_settings(){ 
	document.forms[0].elements["todo"].value = "save";
	document.forms[0].elements["btn_go"].click();
  }
  
  function fill_form(){
	var myOnChange = new Function("e", "save_field(this);");
	var ObjValue;
	var els = frm_main.elements; 
	
	//alert(sessvars.todo);
	if (!(typeof(sessvars.todo)=="undefined")){

		for(i=0; i<els.length; i++){ 
			els[i].onchange=myOnChange;
			
			if (!( php_todo=="load" || php_todo=="new")){
				ObjValue=eval('sessvars.' + els[i].name);
				obj = els[i];
				objType = new String(obj.type);
				switch(objType.toLowerCase()) {
					case 'checkbox' :
						if (eval('sessvars.' + els[i].name)=='1') 
							obj.checked = 1;
						else 
							obj.checked = 0;
						break;
					case 'select-one' :
						obj.selectedIndex = eval('sessvars.' + els[i].name);
						break;
					default :
						obj.value = eval('sessvars.' + els[i].name);
				}		
			}
			
		}
	}
	save_all_form();
  }
 
  
  function save_field(obj){
	objType = new String(obj.type);
	switch(objType.toLowerCase()) {
		case "checkbox" :
			if (obj.checked) 
				eval("sessvars." + obj.name + " = \"1\"");
			else 
				eval("sessvars." + obj.name + " = \"0\"");
			break;
		case "select-one" :
			eval("sessvars." + obj.name + " = \"" + obj.selectedIndex + "\"");
			break;
		default :
			eval("sessvars." + obj.name + " = \"" + obj.value + "\"");
			break;
	}
  }
   
  function save_all_form(must_do){
  //alert("<?php print $todo; ?> - " + document.forms[0].elements["todo"].value );
 
	//if ($todo=="new") 
	//	print "Delete_Cookie();\n return 1;\n";
	if(!must_do)
		if (!(php_todo=="load" || php_todo=="new")) 
			return 1;

	//alert("Saving new setting to  ");
	var obj;
	var ObjValue;
	var objType;
	var objType;
	var els = frm_main.elements;
	for(i=0; i<els.length; i++){ 
		obj = els[i];
		objType = new String(obj.type);
		switch(objType.toLowerCase()) {
			case "checkbox" :
				if (obj.checked) 
					eval("sessvars." + obj.name + " = \"1\"");
				else 
					eval("sessvars." + obj.name + " = \"0\"");
				break;
			case "select-one" :
				eval("sessvars." + obj.name + " = \"" + obj.selectedIndex + "\"");
				break;
			default :
				eval("sessvars." + obj.name + " = \"" + obj.value + "\"");
				break;
		}
		
	}
  }
 
 

  
  function MouseDown(obj,obj_prfix){
	if (event.button==2){
		ClickedObj=obj;
		ClickedObj_prefix=obj_prfix;
		document.getElementById("text_paste").value = obj.value;
		if (!document.getElementById("text_paste_size").value)
			document.getElementById("text_paste_size").value="100";
		set_div_position(document.getElementById("div_paste"));
		document.getElementById("div_paste").style.visibility = 'visible';
		return false;
	}
	return true;
  }
  
  
  
  function set_div_position(obj) {
  var tempX = 0;
  var tempY = 0;
  if (browser=="other") {// grab the x-y pos.s if browser is NS
    tempX = e.pageX
    tempY = e.pageY
  } 
  else {
	  if (browser=="ie"){
		tempX = event.clientX + document.documentElement.scrollLeft
		tempY = event.clientY + document.documentElement.scrollTop
	  }
	  else {
		tempX = event.clientX + document.body.scrollLeft
		tempY = event.clientY + document.body.scrollTop
	  } 
  }

  // catch possible negative values in NS4
  if (tempX < 0){tempX = 0}
  if (tempY < 0){tempY = 0}  
//  if (browser=="ie")
//	tempY+=150;
	
  // show the position values in the form named Show
  // in the text fields named MouseX and MouseY
  //alert(obj.style.top );
  obj.style.top =  tempY + 5 + "px";
  obj.style.left =  tempX + 5 + "px";
  
  //alert(tempX +  "," + tempY);
  return true
  }

  function func_copy(){
	if (browser=="ie") {     // Internet Explorer          
		//ClickedObj.focus();
		Txt = ClickedObj.createTextRange();
		Txt.execCommand("Copy");
	}
	else {      // Firefox, Opera, Google Chrome and Safari   
		alert("Paste function is supported only in Internet Explorer\nUse '[Ctrl] + c' instade");
	}		
  }
  function func_cut(){
	if (browser=="ie") {     // Internet Explorer  	
		//ClickedObj.focus();
		Txt = ClickedObj.createTextRange();
		Txt.execCommand("Cut");
	}
	else {      // Firefox, Opera, Google Chrome and Safari   
		alert("Paste function is supported only in Internet Explorer\nUse '[Ctrl] + x' instade");
	}
  }
  function func_paste(){
	if (browser=="ie") {     // Internet Explorer  
		//ClickedObj.focus();	
		Txt = ClickedObj.createTextRange();
		Txt.execCommand("Paste");
	}
	else {      // Firefox, Opera, Google Chrome and Safari   
		alert("Paste function is supported only in Internet Explorer\nUse '[Ctrl] + v' instade");
	}		
  }
  
  function func_paste_wizard(){
	var size=parseInt(document.getElementById("text_paste_size").value);
	var first_column_name=ClickedObj.name;
	var first_column_value=ClickedObj.value;
	var splt=first_column_name.split("_");
	var down=0;
	var rigth=0;
	var row=parseInt(splt[0].replace(ClickedObj_prefix,""));
	var column=parseInt(splt[1]);
	var first_column_value_to_increase=0;
	var new_value;
	var need_to_increase=false;
	var temp_obj;
	if(document.getElementById("radio_paste_dir").checked)
		down=1;
	else
		rigth=1;
		
	if (document.getElementById("checkbox_paste_increase").checked){
		first_column_value_to_increase=parseInt(first_column_value.substring(first_column_value.length - 1, first_column_value.length));
		if(!(isNaN(first_column_value_to_increase))){// check if it's a number
			first_column_value=first_column_value.substring(0, first_column_value.length - 1);
			need_to_increase=true;
		}
		else{
			alert("error: you checked the 'Increase' option \nbut cell value can not be increased");
			return;
		}
	}
	for(var c=0;c<size;c++){  
			//alert ("p" + (row + (c * rigth)) + "_" + (column + (c * down)))
			
			if (document.forms[0].elements[ClickedObj_prefix + (row + (c * down)) + "_" + (column + (c * rigth))]){
				if(need_to_increase)
					new_value=first_column_value + (first_column_value_to_increase + c);
				else
					new_value=first_column_value;
				temp_obj=ClickedObj_prefix + (row + (c * down)) + "_" + (column + (c * rigth));
				document.forms[0].elements[temp_obj].value = new_value;
			}
			else{
				break;
			}
	}
  }

