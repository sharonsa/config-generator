<?php
date_default_timezone_set('Asia/Jerusalem');
include('/var/www/sharontools/include/functions.php');
func_confirm_locaion();

//$currentFile = $_SERVER["PHP_SELF"];
//$parts = Explode('/', $currentFile);
//$page_name= $parts[count($parts) - 1];
//if ($page_name=="index2.php")
//	$testing_file_name_postfix="2";
//else
//	$testing_file_name_postfix="";
 
$file_action="config-generator-do/";	//.$testing_file_name_postfix;
$file_style="style.css"; 		//.$testing_file_name_postfix.".css";
$file_js_script="script.js"; 		//.$testing_file_name_postfix.".js";
$file_tabber="tabber.js"; 		//.$testing_file_name_postfix.".js";
$file_sessvars="sessvars.js"; 		//.$testing_file_name_postfix.".js";

if ($_POST)
	$todo=escapeshellcmd(trim($_POST['todo']));

inc_init_session();
inc_print_page_head();

$URI= $_SERVER["REQUEST_URI"];
$ver="v1.8";
if ($todo=="load"){
	$upload_tmp_name=$_FILES['uploadedfile']['tmp_name'];
	if ($upload_tmp_name){
		if (!($_FILES['uploadedfile']['type'] == 'text/plain'))
	                die ("<font color='red'>error: Only text files allowd</font><br>If it's a legitimate configuration file, try changing file extension to '.txt'");

	        $upload_new_name=func_cp($upload_tmp_name,"ConfigGenerator");
	        if($upload_new_name)
			$conf=parse_ini_file($upload_new_name);
		else
	                die ("error: can't move file");
	}else {
		print "<font color =red>Error: No File selected</font><br/>";
		$todo="load_error";
	}
}
elseif ($todo=="example"){
	$conf=parse_ini_file("example.dat");
	$todo="load"; // that all fields will be fillds
}


?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>Config Generator - Generate Cisco, Juniper and Nortel config</title> 
<meta name="description" content="An online tool - Config Generator, Here you can Generate configuration files for Cisco, Juniper and Nortel switches" />
<meta name="keywords" content="Config Generator, config, Generate, Generator, cisco, nortel, juniper, tools, free, switch, switches, router, routers, config, configure, Cisco, Nortel, Juniper, Hostname, IP address, Subnet Mask, Default Gateway, Routing enabled, Managment Vlan, stack, Interfaces Name, Description, Speed [auto / 10 / 100 / 1000 / 10000], Duplex [auto / full / half], Vlans No.,  Vlan Tagging (802.1q), Native Vlan No.(PVID at Nortel), Spanning tree,Port mode[ normal / portfast ],Spanning tree Mode,Bridge priority,vlans Name,valns Ip address, vlans Subnet Mask, Redundancy, VRRP/HSRP,  Priorety, preemption "  />
<meta http-equiv="content-Type" content="text/html; charset=windows-1255"/>

<link rel="stylesheet" type="text/css" href="/<?php print $file_style ?>">

<link rel="stylesheet" href="tabber.css" type="text/css" media="screen">

<script type="text/javascript" src="<?php print $file_tabber; ?>"></script>
<script type="text/javascript" src="<?php print $file_sessvars; ?>"></script>
<script type="text/javascript">  
var php_todo="<?php print $todo; ?>";
</script>
<script type="text/javascript" src="<?php print $file_js_script ?>"></script>

<script type="text/javascript">  

  
  document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script> 

</head>
<body >

<form name="frm_main" action="<?php print $file_action;?>" target="iframe1" enctype="multipart/form-data" method="POST">
<input type=hidden name="todo" value="generate"/>
<input type=hidden name="ver" value="<?php print $ver ?>">
<table class="pannel">
	<tr  align=center>
	<td width="50" onclick="javascript:if(confirm('Reset settings\nAre you sure ?')) document.frm_reset.submit();"><img src="images/new.jpg" style="hight:20px;width:20px"/><br/><font size="2px">New</font></td>
	<td width="50" onclick="javascript:document.getElementById('div_load').style.visibility = 'visible';"><img src="images/open.jpg" style="hight:25px;width:25px"/><br/><font size="2px">Open</font></td>
	<td width="50" onclick="javascript:save_settings();"><img src="images/save.jpg" style="hight:25px;width:25px"/><br/><font size="2px">Save</font></td>
	<td width="50" onclick="javascript:if(confirm('Loading settings will make you to lose all the current settings\nAre you sure ?')) document.frm_example.submit();"><img src="images/example.jpg" style="hight:25px;width:25px"/><br/><font size="2px">Example</font></td>
	</tr>
</table>

<div class="tabber">
    <div class="tabbertab">
	<h2>General</h2>
	<p>
		<table border=1 style="border-color: white;border-style: none;">
			<tr align=left><td>
			Vendor:</td><td>
			<select name =vendor>
			  <option value="cisco_ios" <?php print ($todo == "load") ? (($conf["vendor"] == "cisco_ios") ? "selected": ""): "selected"; ?> >Cisco (IOS)</option>
			  <option value="juniper_junos" <?php print ($todo == "load") ? (($conf["vendor"] == "juniper_junos") ? "selected": ""): ""; ?> >Juniper (JunOS)</option>
			  <option value="nortel" <?php print ($todo == "load") ? (($conf["vendor"] == "nortel") ? "selected": ""): ""; ?> >Nortel (small switches)</option>
			</select>
			</td></tr><tr align=left><td>

			Hostname:</td><td>
			<Input type="text" name=hostname value="<?php print ($todo == "load") ? $conf["hostname"]: ""; ?>">
			</td></tr>
			<tr align=left><td>
			
			IP address: </td><td>
			<Input type="text" name=ip value="<?php print ($todo == "load") ? $conf["ip"]: ""; ?>">
			</td></tr><tr align=left><td>

			Subnet Mask: </td><td>
			<Input type="text" name=subnetmask value="<?php print ($todo == "load") ? $conf["subnetmask"]: "255.255.255.0"; ?>">
			</td></tr><tr align=left><td>

			Default Gateway: </td><td>
			<Input type="text" name=defaultgateway value="<?php print ($todo == "load") ? $conf["defaultgateway"]: ""; ?>">
			</td></tr><tr align=left><td>

			Routing enabled: </td><td>
			<select name =routing_enabled>
			  <option value="no" <?php print ($todo == "load") ? (($conf["routing_enabled"] == "no") ? "selected": ""): ""; ?>>No</option>
			  <option value="yes" <?php print ($todo == "load") ? (($conf["routing_enabled"] == "yes") ? "selected": ""): "selected"; ?>>Yes</option>
			</td></tr><tr align=left><td>


			Managment Vlan:<br/>(for Nortel)</td><td>
			<Input type="text" name=mgmt_vlan value="<?php print ($todo == "load") ? $conf["mgmt_vlan"]: "1"; ?>">
			</td></tr><tr align=left><td>
			
			stack: </td><td>
			<select name =stack>
			  <option value="no" <?php print ($todo == "load") ? (($conf["stack"] == "no") ? "selected": ""): "selected"; ?>>No</option>
			  <option value="yes" <?php print ($todo == "load") ? (($conf["stack"] == "yes") ? "selected": ""): ""; ?>>Yes</option>
			</select>
			</td></tr>
		</table>
	</p>
	</div>
	<div class="tabbertab">
	<h2>Ports</h2>
	<p>
		Ports<br/><font color=gray>you can Copy and Paste from Excel</font><br/><font color=gray>rigth click on any cell for a paste wizard</font><br/>
		<b>Configure Ports</b>: 
			<select name =configure_Ports>
			  <option value="no" <?php print ($todo == "load") ? (($conf["configure_Ports"] == "no") ? "selected": ""): ""; ?>>No</option>
			  <option value="yes" <?php print ($todo == "load") ? (($conf["configure_Ports"] == "yes") ? "selected": ""): "selected"; ?>>Yes</option>
			</select><br/>
			
		<table class="xl">
			<tr align=center><td>Int Name</td><td>Description</td><td>Speed<br/>[auto/10/100<br/>/1000/10000]</td><td>Duplex<br/>[auto / full / half]</td><td>Vlans No.<br/>[1 / 1,2]</td><td>Vlan Tagging<br/>(802.1q)<br/>[y / n]</td><td>Native Vlan No.<br/>(PVID at Nortel)</td><td>Spanning tree<br/>Port mode<br/>[ normal / portfast ]</td></tr>
			<?php
			for ($loop=1;$loop<49;$loop++){
				print  "<td><textarea COLS=15 ROWS=1 WRAP=OFF name=p".$loop."_0 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,0)\">".(($todo == "load") ? $conf["p".$loop."_0"]:"Fa0/$loop")."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=p".$loop."_1 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,1)\">".(($todo == "load") ? $conf["p".$loop."_1"]:"")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_2 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,2)\">".(($todo == "load") ? $conf["p".$loop."_2"]:"auto")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_3 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,3)\">".(($todo == "load") ? $conf["p".$loop."_3"]:"auto")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_4 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,4)\">".(($todo == "load") ? $conf["p".$loop."_4"]:"")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_5 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,5)\">".(($todo == "load") ? $conf["p".$loop."_5"]:"n")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_6 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,6)\">".(($todo == "load") ? $conf["p".$loop."_6"]:"")."</TEXTAREA></td>
						<td><textarea COLS=10 ROWS=1 WRAP=OFF name=p".$loop."_7 class='xl'  oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'p');\" onkeyup=\"formatCells(this.value,'p',$loop,7)\">".(($todo == "load") ? $conf["p".$loop."_7"]:"portfast")."</TEXTAREA></td>
						</tr>";
			}
			?>
		</table>
	</p>
	</div>
	<div class="tabbertab">
	<h2>STP</h2>
	<p>
		Spanning tree:<br/>
		<table>
			<tr align=left><td>
			Mode:</td><td>
			<select name =stp_mode>
			  <option value="stp" <?php print ($todo == "load") ? (($conf["stp_mode"] == "stp") ? "selected": ""): "selected"; ?> >STP</option>
			  <option value="rstp" <?php print ($todo == "load") ? (($conf["stp_mode"] == "rstp") ? "selected": ""): ""; ?> >Rapid STP</option>
			</select>
			</td></tr>
			<tr align=left><td>
			
			Bridge priority: </td><td>
			<Input type="text" name=stp_Priority value="<?php print ($todo == "load") ? $conf["stp_Priority"]: ""; ?>">
			</td></tr>
		</table><br/>
		<table>
			<tr align=left><td>
			<font color=gray> Bridge priority can be 0 to 61440 in increments of 4096,<br/>
			The default priority for switches is 32768<br/>
			Usually The Root Bridge priority is 4096
			</font>
			</td></tr>
		</table>
	</p>
	</div>
	<div class="tabbertab">
	<h2>Vlans</h2>
	<p>

		Vlans<br/><font color=gray>you can Copy and Paste from Excel</font><br/><font color=gray>rigth click on any cell for a paste wizard</font><br/>
		<b>Configure Vlans</b>: 
			<select name =configure_Vlans>
			  <option value="no" <?php print ($todo == "load") ? (($conf["configure_Vlans"] == "no") ? "selected": ""): ""; ?>>No</option>
			  <option value="yes" <?php print ($todo == "load") ? (($conf["configure_Vlans"] == "yes") ? "selected": ""): "selected"; ?>>Yes</option>
			</select><br/>
		<table class="xl">
			<tr align=center><td>#</td><td>Name</td><td>Ip address</td><td>Subnet Mask</td></tr>
			<?php
			for ($loop=1;$loop<11;$loop++){
				print  "<td><textarea COLS=5  ROWS=1 WRAP=OFF name=v".$loop."_0 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'v');\" onkeyup=\"formatCells(this.value,'v',$loop,0)\">".(($todo == "load") ? $conf["v".$loop."_0"]: $loop)."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=v".$loop."_1 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'v');\" onkeyup=\"formatCells(this.value,'v',$loop,1)\">".(($todo == "load") ? $conf["v".$loop."_1"]: "")."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=v".$loop."_2 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'v');\" onkeyup=\"formatCells(this.value,'v',$loop,2)\">".(($todo == "load") ? $conf["v".$loop."_2"]: "")."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=v".$loop."_3 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'v');\" onkeyup=\"formatCells(this.value,'v',$loop,3)\">".(($todo == "load") ? $conf["v".$loop."_3"]: "")."</TEXTAREA></td>
						</tr>";
			}
			?>
		</table>

	</p>
	</div>
	<div class="tabbertab">
	<h2>VRRP/HSRP</h2>
	<p>

		VRRP/HSRP<br/><font color=gray>you can Copy and Paste from Excel</font><br/><font color=gray>rigth click on any cell for a paste wizard</font><br/>
		<b>Configure VRRP/HSRP</b>: 
			<select name =configure_VRRP>
			  <option value="no" <?php print ($todo == "load") ? (($conf["configure_VRRP"] == "no") ? "selected": ""): "selected"; ?>>No</option>
			  <option value="yes" <?php print ($todo == "load") ? (($conf["configure_VRRP"] == "yes") ? "selected": ""): ""; ?>>Yes</option>
			</select><br/>
		<table class="xl">
			<tr align=center><td>Vlan No.<br/><td>Redundancy group<br/>(usually same as<br/> vlan no.)<br/></td><td>Redundancy IP<br/>(Cisco - HSRP<br/>All other - VRRP)</td><td>Redundancy Priorety<br/>(usually  Master=150,<br/> Standby=100></td><td>Redundancy preemption<br/>[y / n]</td></tr>
			<?php
			for ($loop=1;$loop<11;$loop++){
				print  "<td><textarea COLS=15 ROWS=1 WRAP=OFF name=vrrp".$loop."_0 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'vrrp');\" onkeyup=\"formatCells(this.value,'vrrp',$loop,0)\">".(($todo == "load") ? $conf["vrrp".$loop."_0"]: $loop)."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=vrrp".$loop."_1 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'vrrp');\" onkeyup=\"formatCells(this.value,'vrrp',$loop,1)\">".(($todo == "load") ? $conf["vrrp".$loop."_1"]: $loop)."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=vrrp".$loop."_2 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'vrrp');\" onkeyup=\"formatCells(this.value,'vrrp',$loop,2)\">".(($todo == "load") ? $conf["vrrp".$loop."_2"]: "")."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=vrrp".$loop."_3 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'vrrp');\" onkeyup=\"formatCells(this.value,'vrrp',$loop,3)\">".(($todo == "load") ? $conf["vrrp".$loop."_3"]: "")."</TEXTAREA></td>
						<td><textarea COLS=15 ROWS=1 WRAP=OFF name=vrrp".$loop."_4 class='xl' oncontextmenu=\"return false;\" onmousedown=\"MouseDown(this,'vrrp');\" onkeyup=\"formatCells(this.value,'vrrp',$loop,4)\">".(($todo == "load") ? $conf["vrrp".$loop."_4"]: "n")."</TEXTAREA></td>
						</tr>";
			}
			?>
		</table>

	</p>
	</div>
	<div class="tabbertab">
	<h2>Config</h2>
	<p>
		<input type=button name= "btn_go" value="Generate config" onclick="javascript:document.frm_main.submit();" style="color: white; background-color: blue"/><br/><br/>
		<IFRAME name="iframe1" WIDTH="900" HEIGHT="400">
		If you can see this, your browser doesn't 
		understand IFRAME.
		</IFRAME>
	</p>
	</div>
	</form>
</div>

<div id="div_load" class="box" style="visibility: hidden;">
<form name="frm_load" action="<?php print $URI ?>" enctype="multipart/form-data" method="POST">
<input type=hidden name="todo" value="load"/>
<table border=0 width="100%" class="box">
	<tr align=center><td>
	<br/>
	<span style="font-size:5">File Load</span>
	</td></tr><tr align=center><td>
	<input type=file name="uploadedfile" style="background-color: white"/> 
	</td></tr><tr align=center><td>
	<input type=button name="btn_load_submit" value="Load" onclick="javascript:if(confirm('Loading settings will make you to lose all the current settings\nAre you sure ?')) document.frm_load.submit();"/>  
	<input type=button name="btn_load_cancel" value="Cancel" onclick="javascript:document.getElementById('div_load').style.visibility = 'hidden';"/>  
	<br/><br/>
	</td></tr>
</table>
</form>
</div>

<div id="div_paste" class="greymenu"  style="visibility: hidden;">
<table id="table_paste" border=0 width="100%" class="greymenu">
	<tr  align=left onclick="document.getElementById('div_paste').style.visibility = 'hidden';func_cut();save_all_form(true);"><td>
		&nbsp;Cut
	</td></tr><tr  align=left onclick="document.getElementById('div_paste').style.visibility = 'hidden';func_copy();"><td>
		&nbsp;Copy
	</td></tr><tr  align=left onclick="document.getElementById('div_paste').style.visibility = 'hidden';func_paste();save_all_form(true);"><td>
		&nbsp;Paste
	</td></tr><tr  align=left><th>
		<hr>
	</th></tr><tr  align=left><th align=left>
		&nbsp;<b>Paste Wizard</b>
	</th></tr><tr  align=left><td>
		&nbsp;Value: <input type= "text" id="text_paste" size="8" />
	</td></tr><tr  align=left><td>
		&nbsp;Cells:&nbsp;&nbsp;<input type= "text" size="3" id="text_paste_size"/> 
	</td></tr><tr  align=left><td>
		&nbsp;Direction:<br/>
		<input type=radio id=radio_paste_dir name=radio_paste_dir value="down" checked />	Down<br/>
		<input type=radio id=radio_paste_dir name=radio_paste_dir value="rigth"/> Rigth
	</td></tr><tr  align=left><td>
		&nbsp;<input type="checkbox" id="checkbox_paste_increase" checked /> Auto increase
	</td></tr><tr  align=left><th>
		&nbsp;<input type=button id="btn_paste_submit" value="Paste" onclick="document.getElementById('div_paste').style.visibility = 'hidden';func_paste_wizard();save_all_form(true);"/>  
		<input type=button id="btn_paste_cancel" value="Cancel" onclick="javascript:document.getElementById('div_paste').style.visibility = 'hidden';"/>  
	</th></tr>
</table>
</div>

<div id="div_saving" class="box" style="visibility: hidden;">
<table border=0 width="100%" class="box">
	<tr align=center><td>
	<br/>
	<span style="font-size:5">Saving settings to coockie</span>
	<br/><br/>
	Please wait
	</td></tr>
</table>
</div>

<form name="frm_reset" action="<?php print $URI ?>" method="POST">
<input type=hidden name="todo" value="new"/>
</form>

<form name="frm_example" action="<?php print $URI ?>" method="POST">
<input type=hidden name="todo" value="example"/>
</form>

 <?php //print_r($conf); ?>
</body></html>

