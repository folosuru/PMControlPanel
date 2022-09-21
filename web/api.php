<?php
require "setting.php";

if (array_key_exists("request",$_POST)){
	 switch ($_POST["request"]) {
         case "return_file_path":
            if ($_SERVER["SERVER_ADDR"] === "localhost" or $_SERVER["SERVER_ADDR"] === "127.0.0.1") {
                echo setting::tmp_file_path;
            }else{
                echo "this request is not for clients.";
            }
                break;

         case "get_log":
             //if (array_key_exists("token",$_POST)){

             //}
             if (file_exists(setting::tmp_file_path."log.sqlite")) {
                 $db = new SQLite3(setting::tmp_file_path . "log.sqlite");
                 if (array_key_exists("last_time", $_POST)){
                     $unix_time = (int) $_POST["last_time"];
                     $db->query("select unix_time,event_name,data,tag1,tag2,tag3 from log where unix_time>=".$unix_time.";");


                 }
             }else{
                 echo "hmm";
             }
	}


}else{
	echo "who are you?";
}