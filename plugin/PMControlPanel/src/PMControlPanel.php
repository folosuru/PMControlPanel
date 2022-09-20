<?php

declare(strict_types=1);

namespace folosuru\PMControlPanel;
use pocketmine\utils\Config;
use function yaml_emit;
use function yaml_parse;
use pocketmine\plugin\PluginBase;

class PMControlPanel extends PluginBase{
	private static $instance;
	private string $tmppath;
	private array $log;

	protected function onEnable(): void{
		$config = new Config($this->getDataFolder()."config.yml",Config::YAML);
		if ($config->exists("path")){
			$this->tmppath = $config->get("path");
		}else{
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
		$this->getServer()->getAsyncPool()->submitTask(new connectCheckTask("http://localhost"));


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


	public function addLog(string $name, array $data, string $tag1, string $tag2, string $tag3) : void{
		$this->log[] = [
			"name" => $name,
			"data" => $data,
			"tag1" => $tag1,
			"tag2" => $tag2,
			"tag3" => $tag3,
			];
	}






}
