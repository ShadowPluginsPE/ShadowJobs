<?php
# Спасибо за скачивание :) 

namespace Main;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntiyDamageByEntityEvent;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use pocketmine\nbt\tags\NameTag;
/* use pocketmine\utils\Config; (Передумал делать конфиг) */
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\permissible\Permissible;
use pocketmine\enchantment\Enchantment;
use pocketmine\level\Position;
/* Знаю, много лишнего, но лень было исправлять :) */
    
    class ProPlugJobs extends PluginBase implements Listener {
    	
const LEAVE = "§7(§6Работы§7) §rТы §aуволился §rс работы!";
const DJ = "§7(§6Работы§7) §rТы ещё не §aустроился!§r";
    public $eco, $cfg, $miner = [], $treecutter = [], $killer = [], $builder = [], $gardener = [];
    
public function onEnable() {
	
	$this->getLogger()->info("§7(§eShadowJobs§7) §rУспешный запуск плагина! Автор: vk.com/shadowpluginsPE");
	    	$this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
                $this->wg = $this->getServer()->getPluginManager()->getPlugin("WorldGuardian");
                    if(empty($this->wg)) {
                    	 $this->getLogger()->warning("§7(§eProPlugJobs§7) §7Плагин WorldGuardian §cне найден, Проверка на приват отключена");
                    }
    /*        @mkdir($this->getDataFolder());
        $this->cfg = new Config($this->getDataFolder(). "jobitems.yml", Config::YAML);
        $this->cfg->save(); (передумал делать конфиг) */
}

  public function Break(BlockBreakEvent $e) {
      $p = $e->getPlayer();
      $b = $e->getBlock();
$x = round($b->getX());
        $y = round($b->getY());
        $z = round($b->getZ());
        $level = $b->getLevel()->getName();
     if(isset($this->miner[strtolower($p->getName())])) {
      	        $ids = [1, 2, 3, 12, 13];
              $ids2 = [14, 15, 16, 56, 73, 129];
        	if(!$p->isCreative() && in_array($b->getId(), $ids)) {
             if(empty($this->wg->regionHere($x, $y, $z, $level)) || $this->wg == null) {
        $this->eco->addMoney($p, 1);
            $p->sendPopup("Вы получили §e1$§r");
                }
            } elseif(!$p->isCreative() && in_array($b->getId(), $ids2)) {
          	 if(empty($this->wg->regionHere($x, $y, $z, $level)) || $this->wg == null) {
            	$this->eco->addMoney($p, 5);
            $p->sendPopup("Вы получили §e5$§r");
               }
            }
        }
          
       if(isset($this->gardener[strtolower($p->getName())])) {
     
if(!$p->isCreative() && $b->getId() == "18") {
   if(empty($this->wg->regionHere($x, $y, $z, $level)) || $this->wg == null) {
     $this->eco->addMoney($p, 4);
          $p->sendTip("Вы получили §e4$§r");
     }
   }
       }
     if(isset($this->treecutter[strtolower($p->getName())])) {
        if(!$p->isCreative() && $b->getId() == "17") {
        	 if(empty($this->wg->regionHere($x, $y, $z, $level)) || $this->wg == null) {
        	  $this->eco->addMoney($p, 3);
        $p->sendTip("Вы получили §e3$§r");
      }
   } 
      }
      }
  public function Place(BlockPlaceEvent $e) {
  	
  foreach($this->getServer()->getOnlinePlayers() as $p) {
  $b = $e->getBlock();
$x = round($b->getX());
        $y = round($b->getY());
        $z = round($b->getZ());
        $level = $b->getLevel()->getName();
    
    if(!$p->isCreative()) {
if(isset($this->builder[strtolower($p->getName())])) {
	  $id = [1, 2, 3, 4, 5, 24, 35, 41, 42, 43, 44, 45, 97, 98, 99, 100];
if(!$p->isCreative() && in_array($b->getId(), $id)) {
	 if(empty($this->wg->regionHere($x, $y, $z, $level)) || $this->wg == null) {
	  $this->eco->addMoney($p, 2);
	$p->sendTip("Вы получили §e2$§r");
	}
}
  }
    }
    }
    }
	public function onDeath(PlayerDeathEvent $e) { 
				
	$entity = $e->getEntity();
  if(isset($this->killer[strtolower($p->getName())])) {
	$cause = $entity->getLastDamageCause();
	if($cause instanceof EntityDamageByEntityEvent) {
			
		$p = $cause->getDamager();
			
		if($p instanceof Player) {
			
			  if(!$p->isCreative() && $entity instanceof Player) {
				$this->eco->addMoney($p, 50);
			$p->sendTip("Вы получили §e50$§r"); 
			}
	    }
	  }
  }
}
		
		
 public function onCommand(CommandSender $p, Command $cmd, $label, array $args) {
 	switch($cmd->getName()) {
 	
case "job":
if(!isset($args[0])) {
  $p->sendMessage("§7(§6Работы§7) §rСписок команд: §e/job info§r");
  }
  if(isset($args[0])) {
  	if($args[0] == "info") {
  $p->sendMessage("§7(§6Работы§7)");
  $p->sendMessage("§b/job list §f- Список работ");
  $p->sendMessage("§b/job help §f- Подробнее о работах");
  }
  	if($args[0] == "list") {
  	    $p->sendMessage("§7(§6Работы§7)\n§3/miner §f– §rУсроиться шахтером\n§3/builder §f– §rУстроиться строителем\n§3/treecutter §f– §rУстроиться дровосеком\n§3/gardener §f– §rУстроиться садовником\n§3/job leave §f– §rУволиться с работы");
  }
      if($args[0] == "help") {
   $p->sendMessage("§7(§6Работы§7)");
   $p->sendMessage("§6Miner §7(Шахтер) §f– Ломайте §bруды§f, §bземлю§f, §bбулыжник§f, §bпесок §fи получайте за это деньги!");
   $p->sendMessage("§6TreeCutter §7(Дровосек) §f– Иногда на сервере идет дождь или снег, и чтобы согреться , стоит растопить печку. §bРубите дерево§f и зарабатывайте деньги!");
   $p->sendMessage("§6Builder §7(Строитель) §f– Скалы, горы, ямы... ну прям средневековье какое-то :). §bЗаймитесь архитектурой §bи зарабатывайте на этом!");
   $p->sendMessage("§6Gardener §7(Садовник) §f– Казалось, нет ничего проще, чем добывать листву. Однако растет она далеко не везде. Работа для кропотливых игроков!");
  }
  if($args[0] == "leave") {
$nick = strtolower($p->getName());
if(isset($this->miner[$nick]) || isset($this->treecutter[$nick]) || isset($this->gardener[$nick]) || isset($this->killer[$nick]) || isset($this->builder[$nick])) {
	unset($this->miner[$nick], $this->treecutter[$nick], $this->builder[$nick], $this->killer[$nick], $this->gardener[$nick]);
	$p->sendMessage(self::LEAVE);
  } else {
  	$p->sendMessage(self::DJ);
  }
    }
       }
    break;

  case "miner":

if(isset($this->builder[strtolower($p->getName())]) || isset($this->killer[strtolower($p->getName())]) || isset($this->gardener[strtolower($p->getName())]) || isset($this->treecutter[strtolower($p->getName())])) {
 $p->sendMessage("§7(§6Работы§7) §rСначала уволься с другой работы!");
}

elseif(isset($this->miner[strtolower($p->getName())])) {
	  $p->sendMessage("§7(§6Работы§7) §rТы уже работаешь §aшахтером!§r");
	} else {
		$this->miner[strtolower($p->getName())] = true;
		  $p->sendMessage("§7(§6Работы§7) §rТы устроился §aшахтером!§r");
		}
		break;
		
    case "builder":
    
 if($this->miner[strtolower($p->getName())] != null || $this->killer[strtolower($p->getName())] != null || $this->gardener[strtolower($p->getName())] != null || $this->treecutter[strtolower($p->getName())] != null) {
	 
         $p->sendMessage("§7(§6Работы§7) §rСначала уволься с другой работы!");
}

elseif(isset($this->builder[strtolower($p->getName())])) {
	$p->sendMessage("§7(§6Работы§7) §rТы уже работаешь §aстроителем!§r");

	} else {
		$this->builder[strtolower($p->getName())] = true;
		  $p->sendMessage("§7(§6Работы§7) §rТы устроился §aстроителем!§r");
		}
		break;
		
		case "killer":
		
if(isset($this->builder[strtolower($p->getName())]) || isset($this->miner[strtolower($p->getName())]) || isset($this->gardener[strtolower($p->getName())]) || isset($this->treecutter[strtolower($p->getName())])) {
	 $p->sendMessage("§7(§6Работы§7) §rСначала уволься с другой работы!");
}

elseif(isset($this->killer[strtolower($p->getName())])) {
	$p->sendMessage("§7(§6Работы§7) §rТы уже работаешь §aкиллером!§r");
	} else {
		$this->killer[strtolower($p->getName())] = true;
		  $p->sendMessage("§7(§6Работы§7) §rТы устроился §aкиллером!§r");
		}
		break;
 
     case "treecutter":
    
  if(isset($this->builder[strtolower($p->getName())]) || isset($this->killer[strtolower($p->getName())]) || isset($this->gardener[strtolower($p->getName())]) || isset($this->miner[strtolower($p->getName())])) {
	 $p->sendMessage("§7(§6Работы§7) §rСначала уволься с другой работы!");
	}
elseif(isset($this->treecutter[strtolower($p->getName())])) {
	$p->sendMessage("§7(§6Работы§7) §rТы уже работаешь §aдровосеком!§r");
	} else {
		$this->treecutter[strtolower($p->getName())] = true;
		  $p->sendMessage("§7(§6Работы§7) §rТы устроился §aдровосеком!§r");
		}
		break;
		
		case "gardener":
		
if(isset($this->treecutter[strtolower($p->getName())]) || isset($this->killer[strtolower($p->getName())]) || isset($this->killer[strtolower($p->getName())]) || isset($this->treecuttor[strtolower($p->getName())])) {
	 $p->sendMessage("§7(§6Работы§7) §rСначала уволься с другой работы!");
}

elseif(isset($this->gardener[strtolower($p->getName())])) {
	$p->sendMessage("§7(§6Работы§7) §rТы уже работаешь §aсадовником!§r");
	} else {
		$this->gardener[strtolower($p->getName())] = true;
		  $p->sendMessage("§7(§6Работы§7) §rТы устроился §aсадовником!§r");
		}
		break;
		}
    }
  }
   
		
?>
            