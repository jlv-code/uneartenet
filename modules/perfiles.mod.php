<?php

	/*	PERFILES
 	 *	Todos los queries y métodos relacionados con la
 	 *	aplicación de Perfiles
 	 * 	@autor: José V.
 	 * 	@date: 2012-10-30 : 1440
 	 */ 
	
	class perfiles {

		private function qListaPerfiles(){
			$sql = "select
					pe.*,array_to_string(array(
						select 
						'{idlinkxperfil:' || lp.idlinkxperfil || 
						',idlink:' || li.idlink || 
						',idmenu:' || li.idmenu || 
						',nombrelink:\"' || li.nombre || 
						'\",descripcion:\"' || li.descripcion || 
						'\",padre:' || li.padre || 
						',url:\"' || li.url || 
						'\",icono:\"' || li.icono || 
						'\",statuslink:' || li.status || '}' as links
						from links li
						join linksxperfil as lp on (lp.idlink = li.idlink)
						where 
						lp.idperfil = pe.idperfil
						order by li.idmenu, lp.idlink
					),',') as links
					from perfil pe
					where
					pe.idperfil != 1
					order by pe.idperfil DESC;";
			return $sql;
		}

		public function listaPerfiles(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qListaPerfiles());
			$bd->dbCloseConection();

			return $data;
		}// FIN listaPerfiles

		private function qListaLinks(){
			$sql = "select 
					* 
					from links 
					order by orden;";
			return $sql;
		}

		public function listaLinks(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qListaLinks());
			$bd->dbCloseConection();

			//return $this->ordenarLinks($data);
			return $data;
		}// FIN function todosPerfiles

		/*private function ordenarLinks(){	
			global $bd;

			$bd->dbConection();

			$padresLinks = $bd->getContentASSOC('select * from links where padre = 0 order by padre, idlink, nombre');

			for($i=0;$i<count($padresLinks);$i++){
				$hijosLinks = $bd->getContentASSOC('select * from links where padre = '.$padresLinks[$i]['idlink'].' order by padre, idlink, nombre');
				$newLinks[] = $padresLinks[$i];
				for($j=0;$j<count($hijosLinks);$j++){
					$hijosLinks2 = $bd->getContentASSOC('select * from links where padre = '.$hijosLinks[$j]['idlink'].' order by padre, idlink, nombre');
					$newLinks[] = $hijosLinks[$j];
					for($k=0;$k<count($hijosLinks2);$k++){
						$hijosLinks3 = $bd->getContentASSOC('select * from links where padre = '.$hijosLinks2[$k]['idlink'].' order by padre, idlink, nombre');
						$newLinks[] = $hijosLinks2[$k];
						for($l=0;$l<count($hijosLinks3);$l++){
							$newLinks[] = $hijosLinks3[$l];
						}
					}
				}
			}

			$bd->dbCloseConection();
			return $newLinks;
		}// FIN function ordenarLinks*/

		public function nuevoPerfil($fields=''){
			global $bd;

			$sql = "select * from perfil where nombre = '".$fields['perfil']."';";
			$bd->dbConection();
			$data = $bd->getContentASSOC($sql);
			if ($data[0]['idperfil']!='') return false;
			$inPerfil = "insert into perfil
						(nombre) values ('".$fields['perfil']."') returning idperfil;";
			$data = $bd->getContentASSOC($inPerfil);
			$bd->dbCloseConection();
			return ($data!='')? true: false;
		}

		public function editarPerfil($fields){
			global $bd;

			if (empty($fields['idperfil'])) return false;

			$bd->dbConection();

			$data = $bd->getContentASSOC("select * from perfil where nombre = '".$fields['nombreperfil']."' and idperfil != ".$fields['idperfil']);
			if (!empty($data)) return false;
			else $bd->getContentASSOC("update perfil set nombre = '".$fields['nombreperfil']."' where idperfil = ".$fields['idperfil']);

			$data = $bd->getContentASSOC("select * from linksxperfil where idperfil = ".$fields['idperfil']);
			if (!empty($data)) $data = $bd->getContentASSOC("delete from linksxperfil where idperfil = ".$fields['idperfil']);

			for($i=0; $i<count($fields['links']);$i++){
				$iLP = "insert into linksxperfil
						(idlink,idperfil) values (".$fields['links'][$i].",".$fields['idperfil'].");";
				$data = $bd->getContentASSOC($iLP);
			}

			$bd->dbCloseConection();
			return true;
		}// FIN function editarPerfil

	}// FIN class perfiles

	$perfiles = new perfiles();
	switch($xget['action']){
		case 'add':
			print $perfiles->nuevoPerfil($xget);
			break;
		case 'update':
			print $perfiles->editarPerfil($xget);
			break;
		case 'delete':
			break;
	}//Fin switch

?>
