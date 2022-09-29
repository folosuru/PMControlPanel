<?php

declare(strict_types=1);

namespace folosuru\PMControlPanel;
use pocketmine\utils\Config;
use pocketmine\plugin\PluginBase;

class PMControlPanel extends PluginBase{
	private static $instance;
	private string $tmppath;
	private array $log;

	protected function onEnable(): void{
        if (!file_exists($this->getDataFolder()."config.yml")){
            $this->saveDefaultConfig();
        }
		$config = new Config($this->getDataFolder()."config.yml",Config::YAML);
			$url = $config->get("web-URL");
            $this->getServer()->getAsyncPool()->submitTask(new connectCheckTask("http://localhost".$url));
            $this->getServer()->getPluginManager()->registerEvents(new basicListener(),$this);
	}

	protected function onLoad(): void{
		self::$instance = $this;
	}

	public static function getInstance() : PMControlPanel{
		return self::$instance;
	}

	public function setTmpPath(string $path) : void{
		$this->tmppath = $path;
	}

	public function getTmpPath() : string{
		return $this->tmppath;
	}

	public function getAllLog() : array{
		return $this->log;
	}

    public function resetLog(){
        $this->log = [];
    }


	public function addLog(string $name, array $data, string $tag1 = null, string $tag2 = null, string $tag3 = null) : void{
        $json_data = json_encode($data);
		$this->log[] = [
			"name" => $name,
			"data" => $json_data,
			"tag1" => $tag1,
			"tag2" => $tag2,
			"tag3" => $tag3,
			];
	}






}
