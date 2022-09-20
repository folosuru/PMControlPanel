<?php
require "setting.php";

if (array_key_exists("request",$_POST)){
	if ($_POST["request"] == "return_file_path"){
		echo setting::tmp_file_path;
	}


}else{
	echo "who are you?";
}