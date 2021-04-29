<?php
	require_once 'framework/Controller.php';
	require_once 'models/App.php';
	require_once 'class/class_client.php';
	require_once 'class/class_globales.php';
	
	class ControllerRewards extends Controller {

		private $db;
		private $gf;
		private $auth;

		public function __construct() {
			$this->db = new App();
			$this->gf = new Globales();	
			$this->auth = $this->gf->Authentification('private');
			$this->gf->isWalletSynchronized($this->auth["id"], "rewards");
		}

		public function index() {			
			$dataTemplate = array("titre"      => "Rewards",
								  "visibility" => true, 
								  "menu"       => $this->gf->InitMenuArray("rewards", "active"));				
			
			$dataView = array("Rewards" => $this->GenRewardsTab());
			
			$this->buildView(array("dataTemplate" => $dataTemplate, "dataView" => $dataView));			
		}

		private function GenRewardsTab(){
			$Table = "";	
			$Rewards = $this->db->getUserRewardsStatistics(array($this->auth["id"]));								
			foreach($Rewards as $reward){
				$Table .= "<tr>";
				$Table .= "	<td style=\"max-width: 50px;\">".$reward['epoch']."</td>";
				$Table .= "	<td style=\"width:250px;color: green;\">".$this->gf->ConvertLovelaceToAda($reward['delegation_rewards'])."</td>";
				$Table .= "	<td style=\"width:250px;color: green;\">".$this->gf->ConvertLovelaceToAda($reward['affilatation_rewards'])."</td>";
				$Table .= "	<td class=\"text-center\" style=\"width:200px;\">".$reward['date']."</td>";
				$Table .= "</tr>";
			}
			return $Table;
		}
	}
?>