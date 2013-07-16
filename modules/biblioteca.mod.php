<?php

	class biblioteca {

		public function qConsultaGeneral(){
			$sql = "select l.*,cd.*,
						l.cota as cota_imagen,
						td.nombre as nombre_documento,
						cd.nroreferencia as referencia,
						cd.tamano as medida,
						cd.nropaginas as paginas,
						ti.nombre as impreso,
				array_to_string(array(select
								lc.nombre as contenido
								from biblioteca.libro as l
								join biblioteca.librocontenido as lc on lc.idlibro = l.idlibro
								where lc.idlibro = l.idlibro),'; ') as titulos,
				array_to_string(array(select
								a.idautor as autor
								from biblioteca.autor as a
								join biblioteca.autorlibro as al on al.idautor = a.idautor
								where al.idlibro = l.idlibro),',') as idemautores,
				array_to_string(array(select
								a.idmateria as autor
								from biblioteca.materia as a
								join biblioteca.libromateria as al on al.idmateria = a.idmateria
								where al.idlibro = l.idlibro),',') as idemmaterias,
				array_to_string(array(select
								a.ideditorial as autor
								from biblioteca.editorial as a
								join biblioteca.libroeditorial as al on al.ideditorial = a.ideditorial
								where al.idlibro = l.idlibro),',') as idemeditoriales,
				array_to_string(array(select
								a.nombre as autor
								from biblioteca.autor as a
								join biblioteca.autorlibro as al on al.idautor = a.idautor
								where al.idlibro = l.idlibro),'; ') as autores,
				array_to_string(array(select
								m.nombre as materia
								from biblioteca.materia as m
								join biblioteca.libromateria as lm on lm.idmateria = m.idmateria
								where lm.idlibro = l.idlibro),'; ') as materias,
				array_to_string(array(select
								e.nombre as editorial
								from biblioteca.editorial as e
								join biblioteca.libroeditorial as le on le.ideditorial = e.ideditorial
								where le.idlibro = l.idlibro),'; ') as editoriales,
				array_to_string(array(select
								c.nombre as centro
								from biblioteca.libroubicacion as lu
								join centro as c on c.idcentro = lu.idcentro
								where lu.idlibro = l.idlibro),'; ') as centros,
				array_to_string(array(select
								sum (lu.ejemplares)as ejemplar
								from biblioteca.libroubicacion as lu
								where lu.idlibro = l.idlibro),'; ') as ejemplares,
				array_to_string(array(select
								lc.nombre
								from biblioteca.librocontenido as lc
								where lc.idlibro = l.idlibro),'; ') as titulos
				from biblioteca.libro l
				left join biblioteca.tipodocumento as td on td.idtipodocumento = l.idtipodocumento
				left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro
				left join biblioteca.tipoimpresion as ti on ti.idtipoimpresion = cd.idtipoimpresion
				order by 1 DESC
				LIMIT 40";
			return $sql;
		}
		
		public function qPrestamosGeneral(){
			$sql = "select tp.nombre as prestamo, sp.nombre, p.*, pr.*, pr.nombres||' '||pr.apellidos as apenom,
			l.*,cd.*,
						l.cota as cota_imagen,
						td.nombre as nombre_documento,
						cd.nroreferencia as referencia,
						cd.tamano as medida,
						cd.nropaginas as paginas,
						ti.nombre as impreso,
			array_to_string(array(select
							a.nombre as autor
							from biblioteca.autor as a
							join biblioteca.autorlibro as al on al.idautor = a.idautor
							where al.idlibro = l.idlibro),'; ') as autores,
			array_to_string(array(select
							e.nombre as editorial
							from biblioteca.editorial as e
							join biblioteca.libroeditorial as le on le.ideditorial = e.ideditorial
							where le.idlibro = l.idlibro),'; ') as editoriales,
			array_to_string(array(select
							sum (lu.ejemplares)as ejemplar
							from biblioteca.libroubicacion as lu
							where lu.idlibro = l.idlibro),'; ') as ejemplares,
			array_to_string(array(select
							count(pre.idprestamo) as centro
							from biblioteca.prestamo as pre
							join biblioteca.libroubicacion as lub on lub.idlibroubicacion = pre.idlibroubicacion
							join centro as c on c.idcentro = lub.idcentro
							where lub.idlibroubicacion = p.idlibroubicacion),'; ') as centros
			from biblioteca.libro l
			join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
			join biblioteca.prestamo as p on p.idlibroubicacion = lu.idlibroubicacion
			join usuario as u on u.idusuario = p.idusuario
			join persona as pr on pr.idpersona = u.idpersona
			join cargo as c on c.idcargo = u.idcargo
			join biblioteca.statusprestamo as sp on sp.idstatusprestamo = p.idstatusprestamo
			join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
			left join biblioteca.tipodocumento as td on td.idtipodocumento = l.idtipodocumento
			left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro
			left join biblioteca.tipoimpresion as ti on ti.idtipoimpresion = cd.idtipoimpresion
			order by 7 DESC";
			return $sql;
		}
		
		public function consultaGeneral(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qConsultaGeneral());
			$bd->dbCloseConection();

			return $data;
		}
		
		public function consultaPrestamos(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qPrestamosGeneral());
			$bd->dbCloseConection();

			return $data;
		}
		
		private function tipoDocumento(){	
			$sql = "select *
		            from biblioteca.tipodocumento 
		            order by 2 ASC";
			return $sql;		  		
		}
		
		public function qTipoDocumento(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->tipoDocumento());
			$bd->dbCloseConection();

			return $data;
		}
		
		public function qCentro(){
			global $bd;
			$sql = "select *
		            from centro 
		            order by 2 ASC";
			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($sql);
			$bd->dbCloseConection();

			return $data;
		}
		
		private function autores(){	
			$sql = "select a.idautor, a.nombre || ' (' || ta.nombre || ')' as nombre
		            from biblioteca.autor a
		            join biblioteca.tipoautor as ta on ta.idtipoautor= a.idtipoautor
		            order by 2 ASC";
			return $sql;		  		
		}
		
		public function qAutores(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->autores());
			$bd->dbCloseConection();

			return $data;
		}
		
		public function qMaterias(){
			global $bd;
			$sql = "select *
		            from biblioteca.materia
		            order by 2 ASC";
			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($sql);
			$bd->dbCloseConection();

			return $data;
		}
		
		public function qEditoriales(){
			global $bd;
			$sql = "select e.ideditorial, e.nombre || ' (' || te.nombre || ')' as nombre
		            from biblioteca.editorial e
		            join biblioteca.tipoeditorial as te on te.idtipoeditorial = e.idtipoeditorial
		            order by 2 ASC";
			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($sql);
			$bd->dbCloseConection();

			return $data;
		}
		
		public function qTipoImpresion(){
			global $bd;
			$sql = "select *
		            from biblioteca.tipoimpresion
		            order by 2 ASC";
			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($sql);
			$bd->dbCloseConection();

			return $data;
		}
		
		public function qFormaAdquisicion(){
			global $bd;
			$sql = "select *
		            from biblioteca.formaadquisicion
		            order by 2 ASC";
			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($sql);
			$bd->dbCloseConection();

			return $data;
		}
	}

	$biblioteca = new biblioteca();

?>
