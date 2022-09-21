<?php

namespace folosuru\PMControlPanel;

use pocketmine\scheduler\Task;

class dataWriteTask extends Task {

	public function __construct(string $path){
		$this->path =$path;
	}

	public function onRun(): void{
		$db = new \SQLite3($this->path."log.sqlite");
		$result = $db->query("SELECT COUNT(*) FROM sqlite_master WHERE TYPE='table' AND name='log';");
		if ($result->fetchArray()[0] == 0){
			$db->exec("create table log(
				    unix_time  integer,
				    event_name text,
   				    data  text,
				    tag1  text,
				    tag2  text,
				    tag3  text
				);");
		}
		$list = PMControlPanel::getInstance()->getAllLog();
		foreach ($list as $item){
			$db->exec("INSERT into log values(".
				time().",".
				$item["name"].",".
				$item["data"].",".
				($item["tag1"] !== null ? "'".$item["tag1"]."'" : "null").",".
				($item["tag2"] !== null ? "'".$item["tag2"]."'" : "null").",".
				($item["tag3"] !== null ? "'".$item["tag3"]."'" : "null").");");
		}

	}

}