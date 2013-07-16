<?php

	/*	PLANTA FISICA
 	 *	Todos los queries y métodos relacionados con la
 	 *	aplicación de Planta Física
 	 * 	@autor: José V.
 	 * 	@date: 2012-07-02 : 1451
 	 */ 
	
	class plantafisica {

		private function qSolicitudesInfraestructura(){
			$sql = "select
					pfs.*,
					uo.idunidadorganizativa,
					uo.nombre as unidadorganizativa,
					pft.*,
					pfss.*,
					pe.idpersona,
					pe.identificacion,
					pe.apellidos,
					pe.nombres,
					array_to_string(array(
					select
					pfas.idactividad
					from plantafisica.actividadesxsolicitudes as pfas
					where pfas.idsolicitud = pfs.idsolicitud),',') as actividades
					from plantafisica.solicitudes as pfs
					join unidadesorganizativas as uo on (uo.idunidadorganizativa = pfs.idunidadorganizativa)
					join plantafisica.tipificaciones as pft on (pft.idtipificacion = pfs.idtipificacion)
					join plantafisica.statussolicitudes as pfss on (pfss.idstatussolicitudes = pfs.idstatus_solicitud)
					join persona as pe on (pe.idpersona = pfs.idresponsable)
					order by
					pfs.idsolicitud DESC;";
			return $sql;
		}

		public function listInfraestructura(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qSolicitudesInfraestructura());
			$bd->dbCloseConection();

			return $data;
		}// FIN function listInfraestructura

		private function qUnidadesOrg(){
			$sql = "select
					uo.idunidadorganizativa,
					uo.nombre
					from unidadesorganizativas as uo
					order by uo.nombre;";
			return $sql;
		}

		public function unidadesOrg(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qUnidadesOrg());
			$bd->dbCloseConection();

			return $data;
		}// FIN function sedes

		private function qPersonasResponsables(){
			$sql = "select
					p.idpersona,
					p.apellidos || ', ' || p.nombres
					from persona as p
					where
					p.idpersona not in (1,2)
					order by p.apellidos, p.nombres;";
			return $sql;
		}

		public function personasResponsables(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qPersonasResponsables());
			$bd->dbCloseConection();

			return $data;
		}// FIN function personasResponsables

		private function qTipificacion(){
			$sql = 'select
					t.idtipificacion,
					t.nombre_tipificacion
					from plantafisica.tipificaciones t
					order by 1;';
			return $sql;
		}

		public function tipificacion(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qTipificacion());
			$bd->dbCloseConection();

			return $data;
		}// FIN function tipificacion

		private function qStatusSolicitudes(){
			$sql = 'select
					ss.idstatussolicitudes,
					ss.statussolicitudes
					from plantafisica.statussolicitudes ss
					order by 2;';
			return $sql;
		}

		public function statusSolicitudes(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qStatusSolicitudes());
			$bd->dbCloseConection();

			return $data;
		}// FIN function statusSolicitudes

		private function qActividades(){
			$sql = 'select
					pfa.idactividad,
					pfa.nombre_actividad
					from plantafisica.actividades pfa
					order by 2;';
			return $sql;
		}

		public function actividades(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qActividades());
			$bd->dbCloseConection();

			return $data;
		}// FIN function statusSolicitudes

		public function nuevaSolicitudInfraestructura($fields=''){
			global $bd;

			if ($fields=='') return false;
			$nActividades = count($fields['actividades']);

			$inSolicitud = "insert into plantafisica.solicitudes (
							idunidadorganizativa,
							idlugar,
							descripcion,
							observacion,
							idtipificacion,
							fecha_deteccion,
							fecha_compromiso,
							fecha_ejecucion,
							idstatus_solicitud,
							idresponsable
							) values (
							".$fields['unidadorganizativa'][0].",
							0,
							'".$fields['descripcion']."',
							'".$fields['observacion']."',
							".$fields['tipificacion'][0].",
							'".$fields['fechadet']."',
							'".$fields['fechacom']."',
							'".$fields['fechaeje']."',
							'".$fields['status'][0]."',
							".$fields['responsableobra'][0]."
							)returning idsolicitud;";

			$bd->dbConection();
			$idSolicitud = $bd->getContentASSOC($inSolicitud);
			$bd->dbCloseConection();

			if ($idSolicitud[0]!=''){
				for($i=0; $i<$nActividades; $i++){
					if ($nActividades==0) return true;
					$inActxSol	=	"insert into plantafisica.actividadesxsolicitudes (
									idsolicitud,
									idactividad,
									idresponsable,
									observaciones,
									fecha_deteccion,
									fecha_compromiso,
									fecha_ejecucion,
									idstatus_actividad,
									idproveedor,
									costo) values (
									".$idSolicitud[0]['idsolicitud'].",
									".$fields['actividades'][$i].",
									0,
									'',
									'2012-10-26 00:00:00',
									'2012-10-26 00:00:00',
									'2012-10-26 00:00:00',
									1,
									0,
									0) returning idactividadesxsolicitudes;";
					$bd->dbConection();
					$idActividadxSolicitud = $bd->getContentASSOC($inActxSol);
					$bd->dbCloseConection();
				}//fin FOR
				return true;
			} else {
				return false;
			}
		}// FIN function nuevaSolicitudInfraestructura

		public function editarSolicitudInfraestructura($fields=''){
			global $bd;

			if ($fields=='') return -1;
			$nActividades = count($fields['actividades']);

			$upSolicitud = "update plantafisica.solicitudes set
							idunidadorganizativa = ".$fields['unidadorganizativa'][0].",
							idlugar = 0,
							idtipificacion = ".$fields['tipificacion'][0].",
							descripcion = '".$fields['descripcion']."',
							observacion = '".$fields['observacion']."',
							fecha_deteccion = '".$fields['fechadet']."',
							fecha_compromiso = '".$fields['fechacom']."',
							fecha_ejecucion = '".$fields['fechaeje']."',
							idstatus_solicitud = ".$fields['status'][0].",
							idresponsable = ".$fields['responsableobra'][0]."
							where
							idsolicitud = ".$fields['idsolicitud']."
							returning idsolicitud;";

			$bd->dbConection();
			$idSolicitud = $bd->getContentASSOC($upSolicitud);
			$bd->dbCloseConection();

			if ($idSolicitud[0]!=''){
				$sqlActxSol =	"select
								idactividadesxsolicitudes,
								idsolicitud,
								idactividad
								from plantafisica.actividadesxsolicitudes
								where
								idsolicitud = ".$idSolicitud[0]['idsolicitud'];
				$bd->dbConection();
				$seActxSol = $bd->getContentASSOC($sqlActxSol);
				$bd->dbCloseConection();

				if ($nActividades==0){
					if ($seActxSol[0]!=''){
						$sql = "delete from plantafisica.actividadesxsolicitudes where idsolicitud = ".$idSolicitud[0]['idsolicitud'];
						$bd->dbConection();
						$upSolxAct = $bd->getContentASSOC($sql);
						$bd->dbCloseConection();
						return true;
					}
				} else {
					$bd->dbConection();
					$ins = "";
					for($i=0;$i<$nActividades;$i++){
						$sql = "select * from plantafisica.actividadesxsolicitudes 
								where idsolicitud = ".$idSolicitud[0]['idsolicitud']." and idactividad = ".$fields['actividades'][$i];
						
						$idActxSol = $bd->getContentASSOC($sql);
						if ($idActxSol=='') {
							$ins.= "insert into plantafisica.actividadesxsolicitudes (
									idsolicitud,
									idactividad,
									idresponsable,
									observaciones,
									fecha_deteccion,
									fecha_compromiso,
									fecha_ejecucion,
									idstatus_actividad,
									idproveedor,
									costo) values (
									".$idSolicitud[0]['idsolicitud'].",
									".$fields['actividades'][$i].",
									0,
									'',
									'2012-10-26 00:00:00',
									'2012-10-26 00:00:00',
									'2012-10-26 00:00:00',
									1,
									0,
									0); \n";
						}
					}
					$idActividadxSolicitud = $bd->getContentASSOC($ins);
					$sql = "";
					for($i=0;$i<count($seActxSol);$i++){
						$key = array_search($seActxSol[$i]['idactividad'], $fields['actividades']);
						if ($seActxSol[$i]['idactividad']==$fields['actividades'][$key]){
							continue;
						} else {
							$sql.= "delete from plantafisica.actividadesxsolicitudes where idactividadesxsolicitudes = ".$seActxSol[$i]['idactividadesxsolicitudes'].";\n";
						}
					}
					$seActxSol = $bd->getContentASSOC($sql);
					$bd->dbCloseConection();
					return true;
				}

			} else {
				return false;
			}
		}// FIN function editarSolicitudInfraestructura

	}// FIN class plantafisica

	$plantafisica = new plantafisica();
	switch($xget['action']){
		case 'add':
			print $plantafisica->nuevaSolicitudInfraestructura($xget);
			break;
		case 'update':
			print $plantafisica->editarSolicitudInfraestructura($xget);
			break;
		case 'delete':
			echo json_encode($_POST);
			break;
	}//Fin switch

?>
