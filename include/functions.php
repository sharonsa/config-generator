<?php
$g_path="/var/www/include";
$g_path_client_side_files="/files";
function protect_files($str){
	$str=str_replace("/","",$str);
	$str=str_replace("\\","",$str);
	$str=str_replace("&","",$str);
	$str=str_replace("..","",$str);
	$str=str_replace("~","",$str);
	$str=str_replace("'","",$str);
	$str=str_replace("`","",$str);
	$str=str_replace("php","",$str);
	return 	$str;
}

function func_cp ($temp_file_path,$app_name){
	$target_path = "/var/www/temp/";
        $target_path = $target_path . $app_name."-". date("dmY")."-". rand(0, 999999);;
        //print "$target_path<br>";
	if (!move_uploaded_file( $temp_file_path, $target_path))
        {
           echo "<font color =red>error uploading file\n</font>";
           return "";
        }

	return $target_path;
}


function inc_init_session()
{
	session_start(); 
}

function inc_print_page_head()
{
	error_reporting (E_ALL ^ E_NOTICE);
    print "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
	
}

if (!function_exists('write_ini_file')) {
    function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
        $content = "";

        if ($has_sections) {
            foreach ($assoc_arr as $key=>$elem) {
                $content .= "[".$key."]\n";
                foreach ($elem as $key2=>$elem2) {
                    $content .= $key2." = \"".$elem2."\"\n";
                }
            }
        }
        else {
            foreach ($assoc_arr as $key=>$elem) {
				if (is_array($elem)){
					foreach ($elem as $key2=>$elem2) {
						$content .= $key."[] = \"".$elem2."\"\n";
					}
				}
				else{
					$content .= $key." = \"".$elem."\"\n";
				}
            }
        }

        if (!$handle = fopen($path, 'w')) {
            return false;
        }
        if (!fwrite($handle, $content)) {
            return false;
        }
        fclose($handle);
        return true;
    }
}

function mask2prefix($mask)
{
	
    if (($long = ip2long($mask)) === false)
        return "<font color=red>#Error Mask enterd.1</font>";
    for ($prefix = 0; $long & 0x80000000; ++$prefix, $long <<= 1) {}
    //if ($long != 0) 
        //return "<font color=red>#Error Mask enterd.2</font>";
    return $prefix;
}
?>
