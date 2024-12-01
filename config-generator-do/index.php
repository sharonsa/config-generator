<?php 
//error_reporting (E_ALL ^ E_NOTICE);
include('/var/www/include/functions.php');
include("$g_path/vars.php");

$todo=trim($_POST['todo']);

if ($todo=="save"){
	$filename = "config-generator-".date("m.d.y-H.i.s")."-".rand(1000000,10000000).".dat";
	//print"<script>alert('".$filename."')</script>;";
	write_ini_file($_POST, "/var/www/temp-saves/$filename");
	
	header( 'Location: http://www.example.com/temp-saves/'.$filename );
	exit;
}
date_default_timezone_set('Asia/Jerusalem');


mysql_connect($server_db_host, $server_db_user, $server_db_password) or die(mysql_error());
@mysql_select_db("sha_db") or die( "Unable to Connect to database");


$ver=escapeshellcmd(trim($_POST['ver']));
$vendor=mysql_real_escape_string(trim($_POST['vendor']));
$hostname=escapeshellcmd(trim($_POST['hostname']));
$ip=escapeshellcmd(trim($_POST['ip']));
$subnetmask=escapeshellcmd(trim($_POST['subnetmask']));
$defaultgateway=escapeshellcmd(trim($_POST['defaultgateway']));
$routing_enabled=escapeshellcmd(trim($_POST['routing_enabled']));
$mgmt_vlan=escapeshellcmd(trim($_POST['mgmt_vlan']));
$stack=escapeshellcmd(trim($_POST['stack']));

$stp_mode=escapeshellcmd(trim($_POST['stp_mode']));
$stp_Priority=escapeshellcmd(trim($_POST['stp_Priority']));

$configure_Ports=escapeshellcmd(trim($_POST['configure_Ports']));
$configure_Vlans=escapeshellcmd(trim($_POST['configure_Vlans']));
$configure_VRRP=escapeshellcmd(trim($_POST['configure_VRRP']));


// ==================== Vlans - read ==============================
for ($loop=1;$loop<11;$loop++){
	$v_num[$loop]=escapeshellcmd(trim($_POST["v".$loop."_0"]));
	$v_name[$loop]=escapeshellcmd(trim($_POST["v".$loop."_1"]));
	$v_ip[$loop]=escapeshellcmd(trim($_POST["v".$loop."_2"]));
	$v_mask[$loop]=escapeshellcmd(trim($_POST["v".$loop."_3"]));
}

// ==================== VRRP - read ==============================
for ($loop=1;$loop<11;$loop++){

	$v_redundency_vlav[$loop]=escapeshellcmd(trim($_POST["vrrp".$loop."_0"]));
	$v_redundency_group[$loop]=escapeshellcmd(trim($_POST["vrrp".$loop."_1"]));
	$v_redundency_ip[$loop]=escapeshellcmd(trim($_POST["vrrp".$loop."_2"]));
	$v_redundency_priorety[$loop]=escapeshellcmd(trim($_POST["vrrp".$loop."_3"]));
	$v_redundency_preemption[$loop]=escapeshellcmd(trim($_POST["vrrp".$loop."_4"]));
	
}

// ==================== Ports - read ==============================
for ($loop=1;$loop<49;$loop++){
	$p_name[$loop]=escapeshellcmd(trim($_POST["p".$loop."_0"]));
	$p_desc[$loop]=escapeshellcmd(trim($_POST["p".$loop."_1"]));
	$p_speed[$loop]=escapeshellcmd(trim($_POST["p".$loop."_2"]));
	$p_duplex[$loop]=escapeshellcmd(trim($_POST["p".$loop."_3"]));
	$p_vlan[$loop]=escapeshellcmd(trim($_POST["p".$loop."_4"]));
	$p_tag[$loop]=escapeshellcmd(trim($_POST["p".$loop."_5"]));
	$p_native_vlan[$loop]=escapeshellcmd(trim($_POST["p".$loop."_6"]));
	$p_stp_mode[$loop]=escapeshellcmd(trim($_POST["p".$loop."_7"]));
}


$top_comment1="This Script was build by ConfigGenerator $ver - an online tool at http://sharontools.com";
$top_comment2="Build date: ".date("F j, Y, g:i a")."";
$top_comment3="Build for: $vendor";


$query = "select * from commands where vendor='$vendor'";
$result=mysql_query($query);



?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta name="robots" content="noindex"/>
<script src="<?php print $g_path_client_side_files ?>/sorttable.js"></script>
</head> 
<body bgcolor=white>
<br/>
<?php
$comment_tag=mysql_result($result,0,"comment_tag");
eval("\$comment_tag = \"$comment_tag\";");
print "<font color=blue>$comment_tag $top_comment1 <br/>$comment_tag $top_comment2 <br/>$comment_tag $top_comment3<br/>$comment_tag<br/></font>";

if($hostname){
	$command=mysql_result($result,0,"hostname");
	eval("\$command = \"$command\";");
	print $command."<br/>";
}

if($ip) {
	if ($stack=="yes")
		$command=mysql_result($result,0,"ip_stack");
	else 
		$command=mysql_result($result,0,"ip");
	eval("\$command = \"$command\";");
	print $command."<br/>";
}

if($routing_enabled=="no")
	$command=mysql_result($result,0,"routing_disabled");
else
	$command=mysql_result($result,0,"routing_enabled");
eval("\$command = \"$command\";");
print $command."<br/>";

if ($defaultgateway) {
	if($routing_enabled=="no")
		$command=mysql_result($result,0,"defaultgateway_routing_d");
	else
		$command=mysql_result($result,0,"defaultgateway_routing_e");
	eval("\$command = \"$command\";");
	print $command."<br/>";
}

if($stp_mode=="rstp")
	$command=mysql_result($result,0,"stp_mode_rstp")."<br/><font color=red>".mysql_result($result,0,"stp_message")."</font>";
else
	$command=mysql_result($result,0,"stp_mode_stp");
eval("\$command = \"$command\";");
print $command."<br/>";

if($stp_Priority){
	$command=mysql_result($result,0,"stp_priority");
	eval("\$command = \"$command\";");
	print $command."<br/>";
}

if ($configure_Vlans !="no"){ // in older saved config files this field was empty
	for ($loop=1;$loop<11;$loop++){
		if ($v_name[$loop]) {
			$command=mysql_result($result,0,"v_name");
			eval("\$command = \"$command\";");
			print $command."<br/>";
			
			//$command=mysql_result($result,0,"v_ip");
			//eval("\$command = \"$command\";");
			//print $command."<br/>";
			
		}
	}
}

//if ($configure_VRRP!="no"){ // in older saved config files this field was empty // disabled beacuse vlan ip is configured from here..
	$command=mysql_result($result,0,"v_redundency_enable");
	if ($command){// if need to enable VRRP globaly
		for ($loop=1;$loop<11;$loop++){
			if ($v_redundency_ip[$loop] and $v_redundency_group[$loop]){// check if vrrp/hsrp is used
				print $command."<br/>";
				break;
			}
		}

	}

	$message1_shown="no";
	$v_prefix_mask=mysql_result($result,0,"v_prefix_mask");
	for ($loop=1;$loop<11;$loop++){
		if ($v_num[$loop] and $v_name[$loop] and $v_ip[$loop] and $v_mask[$loop]) {
			if ($v_prefix_mask=="yes"){// if needs to convert mask to prefix mask
				$prefix_mask = mask2prefix("$v_mask[$loop]");
				//print "yy-$v_mask[$loop]-yy";
			}
			$command=mysql_result($result,0,"v_ip");
			eval("\$command = \"$command\";");
			print $command."<br/>";
			$message1=mysql_result($result,0,"v_redundency_message");
			for ($loop2=1;$loop2<11;$loop2++){
				if ($v_num[$loop]==$v_redundency_vlav[$loop2] and $v_redundency_ip[$loop2]){
					$command=mysql_result($result,0,"v_redundency_ip");
					if ($message1)
						if($message1_shown=="no"){
							$command.="<br/><font color=red>".$message1."</font>";
							$message1_shown="yes";
						}
					eval("\$command = \"$command\";");
					print $command."<br/>";
					if ($v_redundency_priorety[$loop]){
						$command=mysql_result($result,0,"v_redundency_priorety");
						eval("\$command = \"$command\";");
						print $command."<br/>";
					}
					if ($v_redundency_preemption[$loop2]=="y"){
						$command=mysql_result($result,0,"v_redundency_preemption");
						eval("\$command = \"$command\";");
						print $command."<br/>";
					}
				}
			}
		}
	}
//}

if ($configure_Ports!="no"){ // in older saved config files this field was empty
	$p_auto_negotiate_disable=mysql_result($result,0,"p_auto_negotiate_disable");
	$p_vlan_separator=mysql_result($result,0,"p_vlan_separator");
	$p_global=mysql_result($result,0,"p_global");
	if ($p_global) // if is needed to enter the port name first
		print $p_global."<br/>";
	for ($loop=1;$loop<49;$loop++){
		$command=mysql_result($result,0,"p_name");
		if ($command){ // if is needed to enter the port name first
			eval("\$command = \"$command\";");
			print $command."<br/>";
		}
		if ($p_desc[$loop]){
			$command=mysql_result($result,0,"p_desc");
			eval("\$command = \"$command\";");
			print $command."<br/>";
		}
		if($p_auto_negotiate_disable){//if needs to disable autonegotiate first
			if (($p_speed[$loop] and $p_speed[$loop]!="auto") or ($p_duplex[$loop] and $p_duplex[$loop]!="auto")){
				eval("\$command = \"$p_auto_negotiate_disable\";");
				print $command."<br/>";
			}
		}
		if ($p_speed[$loop] and $p_speed[$loop]!="auto"){
			$command=mysql_result($result,0,"p_speed");
			eval("\$command = \"$command\";");
			print $command."<br/>";
		}
		if ($p_duplex[$loop] and $p_duplex[$loop]!="auto"){
			$command=mysql_result($result,0,"p_duplex");
			eval("\$command = \"$command\";");
			print $command."<br/>";
		}
		if($vendor!="nortel") { // for nortel it will be configured seperatlly
			if ($p_tag[$loop]=="y"){
				$command=mysql_result($result,0,"p_tag");
				eval("\$command = \"$command\";");
				print $command."<br/>";
				if ($p_vlan[$loop]) {
					$p_vlan[$loop]=str_replace(",",$p_vlan_separator,$p_vlan[$loop]);
					$command=mysql_result($result,0,"p_vlan_trunk");
					eval("\$command = \"$command\";");
					print $command."<br/>";
				}
				if ($p_native_vlan[$loop]){
					$command=mysql_result($result,0,"p_native_vlan");
					eval("\$command = \"$command\";");
					print $command."<br/>";
				}
			}
			else {
				if ($p_vlan[$loop]) {
					$command=mysql_result($result,0,"p_vlan_access");
					eval("\$command = \"$command\";");
					print $command."<br/>";
				}
			}
		}
		
		if ($p_stp_mode[$loop]=="portfast") {
			if ($stp_mode=="rstp")
				$command=mysql_result($result,0,"p_stp_mode_rstp");
			else
				$command=mysql_result($result,0,"p_stp_mode_stp");
			eval("\$command = \"$command\";");
			print $command."<br/>";
		}
	}
	$p_global_exit=mysql_result($result,0,"p_global_exit");
	if ($p_global_exit) // if is needed to enter the port name first
		print $p_global_exit."<br/>";


	if($vendor=="nortel"){
		for ($loop=1;$loop<49;$loop++){
			if ($p_vlan[$loop] or $p_tag[$loop]){
				if ($p_tag[$loop]=="y"){
					$command=mysql_result($result,0,"p_tag");
					eval("\$command = \"$command\";");
					print $command."<br/>";
				}
				if ($p_vlan[$loop]) {
					$vlans=explode(",",$p_vlan[$loop]);
					foreach ($vlans as $vlan) {
						$command=mysql_result($result,0,"p_vlan_trunk");
						eval("\$command = \"$command\";");
						print $command."<br/>";
					}
					
				}
			}
			if ($p_native_vlan[$loop]){
				$command=mysql_result($result,0,"p_native_vlan");
				eval("\$command = \"$command\";");
				print $command."<br/>";
			}
		}
	}	
}
print "!<font color=blue><br/>! Script end<br/>";
exit;


?>

<br/><br/>

</body>
</html>
