<?php

namespace folosuru\PMControlPanel;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class connectCheckTask extends AsyncTask {

	public function __construct(private $URL){}

	public function onRun(): void{
		$url = $this->URL."api.php";
		$data = array(
			"request" =>"return_file_path"
		);

        $context = array(
			'http' => array(
				'method'  => 'POST',
				'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',)),
				'content' => http_build_query($data)
			)
		);

        $result = @file_get_contents($url, false, stream_context_create($context));
		if ($result === false){
			$this->setResult(false);
		}else{
			$this->setResult($result);
		}
	}

	public function onCompletion(): void{
		$plugin = PMControlPanel::getInstance();
		if ($this->getResult() === false or !file_exists($this->getResult())){
			$plugin->getLogger()->emergency("Cannot connect http server. Maybe http server is not working.");
			Server::getInstance()->getPluginManager()->disablePlugin(PMControlPanel::getInstance());
		}else{
			$plugin->setTmpPath($this->getResult());
			$plugin->getScheduler()->scheduleRepeatingTask(new dataWriteTask($plugin->getTmpPath()),10);
		}
	}
}