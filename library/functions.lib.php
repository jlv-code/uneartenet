<?php
	
	class functions {

		public function sendMessage($array){
			$message = '<script languaje="javascript">';
			$message.= "sendMessage('{$array[tipo]}','{$array[mensaje]}');";
			$message.= '</script>';
			return $message;
		}// FIN function sendMessage

		public function actions($permissions,$subMod){
			for($i=0;$i<count($permissions);$i++){
				if($permissions[$i]['nombre_menu']==$subMod){
					$actions[] = $permissions[$i];
				}
			}
			return $actions;
		}// FIN function actions

	}// FIN class functions
	
?>
