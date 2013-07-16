<?php
	
	class queries {
		public function qInfoTablas($tabla,$campo) {
			$sql = "SELECT data_type, character_maximum_length, is_nullable, column_name
					FROM 
						information_schema.columns 
					WHERE 
						table_name = '{$tabla}' and column_name = '{$campo}'";
			return $sql;
		}
		
		public function qTipoIdentificacion() {
			$sql = "select
					*
					from tipoidentificacion
					order by 1";
			return $sql;
		}
		
		public function qValidarUsuario($arrData) {
			$sql = "select 
						us.idpersona,
						us.idusuario,
						pe.identificacion,
						pe.nombres,
						pe.apellidos,
						c.idcentro,
						c.nombre
					from persona as pe
					join usuario as us on (us.idpersona = pe.idpersona)
					join centro as c on (c.idcentro=us.idcentro)
					where
						pe.tipoidentificacion = {$arrData['idtype']} and
						pe.identificacion = '{$arrData['id']}' and
						us.contrasena = md5('{$arrData['password']}')
					";
			return $sql;
		}
		
		public function qValidarRegistro($data) {
			$sql = "select 
						us.idpersona,
						us.idusuario,
						pe.identificacion,
						pe.apellidos,
						pe.nombres,
						us.contrasena,
						us.idstatususuario,
						c.idcentro,
						c.nombre
					from persona as pe
					join usuario as us on (us.idpersona = pe.idpersona)
					join centro as c on (c.idcentro=us.idcentro)
					where
						(select md5(' '||us.fecharegistro||' ')) = '".$data."';";
			return $sql;
		}
		
		public function qValidarUsuarioTrabajador($arrData) {
			$sql = "select 
						pe.idpersonau,
						pe.identificacionu,
						pe.apellidos,
						pe.nombres
					from personau as pe
					where
						pe.identificacionu = '{$arrData['id']}' and
						pe.status = 0
					";
			return $sql;
		}
		
		public function qPerfilesUsuario($iduser){
			$sql = "select 
						pu.idperfil
					from perfilxusuario as pu
					where
						pu.idusuario = {$iduser}";
			return $sql;
		}
		
		public function qPermisologia($idperfiles){
			$sql = "select distinct on (5)
						ln.idmenu,
						ln.idlink,
						vi.idvista,
						tc.idtipodecontenido,
						vi.idplantilla,
						vi.idmodulo,
						me.nombre as nombre_menu,
						ln.nombre as nombre_link,
						ln.descripcion as descripcion_link,
						ln.padre,
						ln.url,
						ln.icono,
						pl.nombre as nombre_plantilla,
						pl.descripcion as descripcion_plantilla,
						mo.nombre as nombre_modulo,
						mo.descripcion as descripcion_modulo
					from menus as me
					join links as ln on ln.idmenu = me.idmenu
					left join vistas as vi on vi.idlink = ln.idlink
					left join plantillas as pl on pl.idplantilla = vi.idplantilla
					left join modulos as mo on mo.idmodulo = vi.idmodulo
					left join tiposdecontenido as tc on tc.idtipodecontenido = vi.idtipodecontenido
					join linksxperfil as lp on lp.idlink = ln.idlink
					where
						me.status = 1 and
						ln.status = 1 and
						vi.status = 1 and
						lp.idperfil in ({$idperfiles})
					";
			return $sql;
		}
		
		public function qValidarUsuarioEstudiante($arrData) {
			$sql = "select distinct
						e.cedulaidentidad,
						op.nombre as centro,
						e.apellidos,
						e.nombres,
						e.contrasena,
						e.direccion,
						e.email,
						e.sexo,
						e.telefono,
						e.operadora,
						e.celular,
						e.fechanacimiento,
						eo.status,
						SUBSTRING(e.cedulaidentidad, 1,1) as tipoidentificador
					from estudiante as e
					join estudianteorganizacion as eo on (eo.idestudiante = e.idestudiante)
					join pensumxorganizacion as pxo on (pxo.idpensumxorganizacion=eo.idpensumxorganizacion)
					join organizacion as o on (o.idorganizacion=pxo.organizacion)
					join organizacion as op on (op.idorganizacion=o.padre)
					where
						SUBSTRING(e.cedulaidentidad, 3) = '{$arrData['id']}' and
						e.contrasena = '".md5($arrData['password'])."' and
						eo.status = 1
					";
			return $sql;
		}
			
		public function qValidarUsuarioDocente($arrData) {
			$sql = "select distinct
						s.cedulaidentidad,
						d.apellidos,
						d.nombres,
						s.contrasena,
						d.direccion,
						d.email,
						d.sexo,
						d.telefono,
						d.operadora,
						d.celular,
						d.fechanacimiento,
						d.status,
						SUBSTRING(d.cedulaidentidad, 1,1) as tipoidentificador
					from docente as d
					join seguridad as s on (s.cedulaidentidad = d.cedulaidentidad)
					where
						SUBSTRING(s.cedulaidentidad, 3) = '{$arrData['id']}' and
						s.contrasena = '".md5($arrData['password'])."' and
						d.status = 1
					";
			return $sql;
		}
		
		public function qUsuarioEstudiante($id) {
			$sql = "select distinct
					e.cedulaidentidad as identificacion,
					e.contrasena as __contrasena,
					e.apellidos,
					e.nombres,
					e.direccion as direccion_de_habitacion,
					e.email as correo_electronico,
					e.sexo as id_sexo,
					e.telefono,
					e.operadora as id_operadora,
					e.celular,
					to_char(e.fechanacimiento,'DD/MM/YYYY') as fecha_de_nacimiento,
					op.nombre as carrera,
					SUBSTRING(e.cedulaidentidad,1,1) as id_tipo_identificacion,
					SUBSTRING(e.cedulaidentidad,3) as cedula_de_identidad
					from estudiante as e 
					join estudianteorganizacion as eo on (eo.idestudiante = e.idestudiante)
					join pensumxorganizacion as pxo on (pxo.idpensumxorganizacion=eo.idpensumxorganizacion)
					join organizacion as o on (o.idorganizacion=pxo.organizacion)
					join organizacion as op on (op.idorganizacion=o.padre)
					where
					SUBSTRING(e.cedulaidentidad, 3) = SUBSTRING('$id',3)
					";
			return $sql;
		}
		 
		public function qUsuarioDocente($id) {
			$sql = "select distinct 
							s.cedulaidentidad as cedula,
							s.contrasena as __contrasena,
							doc.apellidos,
							doc.nombres,
							doc.direccion as direccion_de_habitacion,
							doc.email as correo_electronico,
							doc.sexo as id_sexo,
							doc.telefono,
							doc.operadora as id_operadora,
							doc.celular,
							to_char(doc.fechanacimiento,'DD/MM/YYYY') as fecha_de_nacimiento,
							SUBSTRING(doc.cedulaidentidad, 1,1) as id_tipo_identificacion,
							SUBSTRING(doc.cedulaidentidad,3) as cedula_de_identidad
							from docente as doc 
							join seguridad as s on (s.cedulaidentidad = doc.cedulaidentidad)
							join perfil as p on (p.idperfil=s.perfil)
							where
							SUBSTRING(s.cedulaidentidad, 3) = SUBSTRING('$id',3)";
			return $sql;
		}

		public function qUsuarioTrabajador($id) {
			$sql = "select 
						pe.identificacionu as cedula_de_identidad,
						pe.idgenero as id_tipo_identificacion,
						pe.apellidos,
						pe.nombres,
						pe.direccionhabitacion as direccion_de_habitacion,
						pe.fechanacimiento as fecha_de_nacimiento,
						pe.correo as correo_electronico,
						pe.fechanacimiento as telefono,
						pe.idgenero as id_sexo
						from personau as pe 
						where
						pe.identificacionu = '{$id}'";
			return $sql;
		}	

		public function qIdenTable($table,$valores,$columnaOrden) {
			$tablaGuena=$table;
			if (strpos($table,'.')!='') {
				$table=substr($table, strpos($table,'.')+1); 
			}
			$sql = "select *
							from {$tablaGuena}
			".
			(($valores!='')?" where id{$table} {$valores}" : "").
		" order by ".($columnaOrden!=''?$columnaOrden:2);
			return ($sql);
		}
			
		//FUNCIONES DE NEWS
		
		
		
		public function qListaNoticiasEditar(){
		   $sql = "select 
				   i.idinformacion as id,
				   i.titulo as titulo____________,
				   ca.nombre as categoria,
				   to_char(fechapublicacion,'DD/MM/YYYY') as fecha,
				   i.autor as autor,
				   s.nombre as estado
				   from informacion as i
				   join statusinformacion as s on (s.idstatusinformacion = i.idstatusinformacion)
				   join noticiasxcategoria as c on (c.idinformacion = i.idinformacion)
				   join categoria as ca on (ca.idcategoria = c.idcategoria)
				   where idtipoinformacion = 3
				   order by fechapublicacion DESC";	
		   return $sql;
		}
		
		public function qFormularioNoticias(){
		   $id=$_GET['id'];
		   $sql = "select 
				   i.titulo as titulo,
				   i.descripcion as descripcion,
				   ca.nombre as categoria,
				   m.url as url,
				   i.autor as autor,
				   to_char(fechapublicacion,'DD/MM/YYYY') as fecha,
				   s.nombre as estado
				   from informacion as i
				   join statusinformacion as s on (s.idstatusinformacion = i.idstatusinformacion)
				   left join multimedia as m on (m.idinformacion = i.idinformacion)
				   join noticiasxcategoria as c on (c.idinformacion = i.idinformacion)
				   join categoria as ca on (ca.idcategoria = c.idcategoria)
				   where i.idinformacion = '{$id}'";	
		  return $sql;
		}
		
		public function qCategoriaxNoticia(){
		  $id=$_GET['id'];
		  $sql = "select
				  idcategoria as categoria
				  from noticiasxcategoria 
				  where idinformacion = '{$id}'";	
		  return $sql;
		}
		
		public function qEstatusNoticia(){
		  $id=$_GET['id'];
		  $sql = "select 
				  s.nombre as estado
				  from informacion as i
				  join statusinformacion as s on (s.idstatusinformacion = i.idstatusinformacion)
				  where i.idinformacion = '{$id}'";	
		  return $sql;
		}
		
	// FUNCIONES DE COMUNICATE

		public function qListaComunicados(){	
			$sql = "select
				   idinformacion as id,
				   titulo as titulo, 
				   to_char(fechapublicacion,'DD/MM/YYYY') as _fecha
				   from informacion as inf
				   where idtipoinformacion = 1
				   order by fechapublicacion DESC";
			return $sql;		  		
		}
		
		public function qListaBoletines(){	
			$sql = "select
				   idinformacion as id,
				   titulo as titulo, 
				   to_char(fechapublicacion,'DD/MM/YYYY') as _fecha
				   from informacion as inf
				   where idtipoinformacion = 2
				   order by fechapublicacion DESC";
			return $sql;		  		
		}
		
	// FUNCIONES DE BIBLIOTECA	

		/* QUERY: EXTRAE LOS EJEMPLARES DE UN LIBRO QUE PERTENEZCA A UN CENTRO DE
		 * LA TABLA LIBROUBICACION
		 */ 
		 
		 // ESTA SE VA A USAR EN ALGUN MOMENTO, DEJARLA AQUI
		 
		public function qEjemplaresLibros($idlibroubicacion){
			$sql = "select 
						ps.idpensum,
						ps.pensum,
						po.organizacion
					from estudiante as es
					join estudianteorganizacion as eo on (eo.idestudiante = es.idestudiante)
					join pensumxorganizacion as po on (po.idpensumxorganizacion = eo.idpensumxorganizacion)
					join pensum as ps on (ps.idpensum = po.pensum)
					join cursosxpensum as cp on (cp.pensum = ps.idpensum)
					where 
						es.idestudiante = {$idestudiante} and
						cp.curso = {$idCurso}
					order by
						ps.pensum";
			return $sql;
		}

		public function qBuscarDatosPersonas($identificacion){
			$sql = "select 
					u.idusuario,
					i.nombre as nacionalidad,
					p.apellidos,
					p.nombres,
					p.direccionhabitacion,
					c.nombre as correo,
					t.nombre as telefono,
					ce.nombre,
					pf.idperfil
					from 
					persona as p
					join tipoidentificacion as i on (p.tipoidentificacion = i.idtipoidentificacion)
					join usuario as u on p.idpersona = u.idpersona
					join perfilxusuario as pu on (pu.idusuario=u.idusuario)
					join perfil as pf on (pf.idperfil=pu.idperfil)
					join centro as ce on (ce.idcentro = u.idcentro)
					left join correo as c on c.idpersona=p.idpersona
					left join telefono as t on t.idpersona=p.idpersona
					where
					p.identificacion = ('{$identificacion}')
					order by 1
					LIMIT 1";
			return $sql;
		}

		public function qBuscarDatosCotas($cota){
			$sql = "select distinct
						l.cota as _cota_doc
					from biblioteca.libro as l 
						join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
						join centro as c on c.idcentro = lu.idcentro
	where cota ilike ('%{$cota}%')
						order by 1";
			return $sql;
		}
			
		public function qBuscarDatosCota($cota,$idcentro){
			$sql = "select
						lu.idlibroubicacion as ID,
						l.cota as _cota_doc,                               
						l.titulo as titulo_del_documento,
						td.nombre as tipologia,
						l.ano as ano,
						lu.ejemplares,
						c.idcentro as ID,
						c.nom as ceca
					from biblioteca.libro as l 
						join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
						join centro as c on c.idcentro = lu.idcentro
						where l.cota ilike ('{$cota}') ".
						($idcentro!=''?" and lu.idcentro = {$idcentro} " : "").
						" order by 1";
			return $sql;
		}
		
		public function qBuscarDatosPrestamo($iduser, $estatus){
			$sql = "select distinct u.idusuario as id, 
					ps.nombres || ' ' || ps.apellidos as Nombres_y_Apellidos____,
					ps.identificacion as _identificacion,
					pf.nombre as perfil_del_usuario,
					c.nombre as CECA,
					p.idprestamo,
					l.cota as cota__,
					l.titulo as documento____
					from usuario as u
					join biblioteca.prestamo as p  on p.idusuario = u.idusuario
					join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					left join biblioteca.statusprestamo as sp on (sp.idstatusprestamo=p.idstatusprestamo)
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfilxusuario as pu on pu.idusuario = u.idusuario
					join perfil as pf on pf.idperfil = pu.idperfil
					where u.idusuario= ({$iduser}) and sp.idstatusprestamo in (".$estatus.
					") order by 1 DESC";
			return $sql;
		}
		
		public function qBuscarDatosPrestamoPendiente($iduser, $estatus){
			$sql = "select 
						lu.idlibroubicacion,
						l.cota as cota,
						l.titulo as documento,
						tp.idtipoprestamo,
						c.idcentro,
						c.nom,
						p.ejemplar
					from usuario as u
						join biblioteca.prestamo as p  on p.idusuario = u.idusuario
						join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
						join biblioteca.libro as l on l.idlibro = lu.idlibro
						left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
						join biblioteca.statusprestamo as sp on (sp.idstatusprestamo=p.idstatusprestamo)
						join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
						join centro as c on c.idcentro=lu.idcentro
					where u.idusuario= ({$iduser}) and sp.idstatusprestamo ".$estatus.
					" order by sp.nombre DESC";
			return $sql;
		}
		
		public function qGenerarPersonas($iduser){
			$sql = "select 
					p.idpersona,
					i.nombre as nacionalidad,
					p.apellidos,
					p.nombres,
					p.direccionhabitacion,
					pf.nombre as usuario,
					c.nombre as correo,
					t.nombre as telefono
					from 
					persona as p
					join tipoidentificacion as i on (p.tipoidentificacion = i.idtipoidentificacion)
					join usuario as u on p.idpersona = u.idpersona
					left join correo as c on c.idpersona=p.idpersona
					left join telefono as t on t.idpersona=p.idpersona
					where
					u.idusuario = ({$iduser})
					order by 1";
			return $sql;
		}
		
		public function qPrestamoCirculanteGeneral(){
			$sql = "select 
					u.idusuario as id,
					sp.nombre as estado__,
					ps.identificacion,
					tp.nombre as prestamo,
					to_char(p.fechaentrega,'DD/MM/YYYY HH24:MI') as entregado,
					to_char(p.fechalimite,'DD/MM/YYYY HH24:MI') as devolver_antes,
					ps2.identificacion as por,
					
					ps.nombres || ' ' || ps.apellidos || ' - ' || pf.nombre || ' - ' || c.nombre || ' ('|| p.renovaciones ||')' as _Nombres_y_Apellidos
					from biblioteca.prestamo as p
					join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					join biblioteca.statusprestamo as sp on sp.idstatusprestamo=p.idstatusprestamo and p.idstatusprestamo!=2
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join usuario as u on u.idusuario = p.idusuario
					left join usuario as u2 on u2.idusuario = p.idusuarioentregado
					left join persona as ps2 on ps2.idpersona = u2.idpersona
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfil as pf on pf.idperfil = p.idperfil ".
					($_SESSION['criterioBusqueda']!='' ? " where ". $_SESSION['criterioBusqueda']:'').
					" group by 1,2,3,4,5,6,7,8 ".
					" order by sp.nombre DESC";
					$_SESSION['sql'] = $sql; //Linea agregada para la busqueda en el botón de búsqueda
									//echo $sql;
			return $sql;
		}
		
		public function qPrestamoSolicitudUsuarioDocumentos($iduser){
			$sql = "select p.idlibroubicacion as id
					from usuario as u
					join biblioteca.prestamo as p  on p.idusuario = u.idusuario
					join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					join biblioteca.statusprestamo as sp on (sp.idstatusprestamo=p.idstatusprestamo)
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					where u.idusuario= ({$iduser}) and sp.idstatusprestamo=3
					order by sp.nombre DESC";
			return $sql;
		}

		public function qPrestamoSolicitudUsuario($iduser,$idperfil){
			$sql = "select u.idusuario as id, 
					ps.nombres || ' ' || ps.apellidos as Nombres_y_Apellidos____,
					ps.identificacion as _identificacion,
					pf.nombre as perfil_del_usuario,
					c.nombre as CECA,
					p.idprestamo,
					l.cota as cota__,
					l.titulo as documento____
					from usuario as u
					join biblioteca.prestamo as p  on p.idusuario = u.idusuario
					join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					left join biblioteca.statusprestamo as sp on (sp.idstatusprestamo=p.idstatusprestamo)
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfilxusuario as pu on pu.idusuario = u.idusuario
					join perfil as pf on pf.idperfil = pu.idperfil
					where u.idusuario= ({$iduser}) and sp.idstatusprestamo=3 and pf.idperfil=({$idperfil})
					order by sp.nombre DESC";
			return $sql;
		}

		public function qPrestamoCirculanteUsuario($iduser){
			$sql = "select u.idusuario as id, 
					ps.nombres || ' ' || ps.apellidos as Nombres_y_Apellidos____,
					ps.identificacion as USUARIO,
					co.nombre as correo_electronico,
					te.nombre as telefono,
					pf.nombre as perfil_del_usuario,
					c.nombre as dependencia,
					p.idprestamo,
					tp.idtipoprestamo as prestamo,
					lu.ejemplares as idE,
					p.ejemplar as Nro,
					l.titulo as documento,
					l.cota as cota_,
					sp.nombre as estado_
					
					from biblioteca.prestamo as p 
					join biblioteca.libroubicacion as lu on p.idlibroubicacion = lu.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					left join biblioteca.statusprestamo as sp on sp.idstatusprestamo=p.idstatusprestamo
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join usuario as u on u.idusuario = p.idusuario
					join persona as ps on ps.idpersona = u.idpersona
					left join correo as co on co.idpersona = ps.idpersona
					left join telefono as te on te.idpersona = ps.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfil as pf on pf.idperfil = p.idperfil
					where p.idusuario= ({$iduser})
					order by sp.nombre DESC";
			return $sql;
		}

		
		public function qDocumentosPendientes(){
			$sql = "select 
					u.idusuario as id,
					l.cota as cota_______,
					to_char(p.fechalimite,'DD/MM/YYYY HH24:MI') as devolver_el,
					ps.identificacion,
					ps.apellidos  || ' ('|| p.renovaciones ||')' as apellidos__,
					tp.nombre as prestamo,
					sp.nombre as estado__,
					l.titulo as _Titulo_del_documento
					from biblioteca.prestamo as p
					join biblioteca.libroubicacion as lu on lu.idlibroubicacion = p.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					join biblioteca.statusprestamo as sp on sp.idstatusprestamo=p.idstatusprestamo
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join usuario as u on u.idusuario = p.idusuario
					left join usuario as u2 on u2.idusuario = p.idusuarioentregado
					left join persona as ps2 on ps2.idpersona = u2.idpersona
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfil as pf on pf.idperfil = p.idperfil ".
					($_SESSION['criterioBusqueda']!='' ? " where p.idstatusprestamo=1 ". $_SESSION['criterioBusqueda']:'').
					" group by 1,2,3,4,5,6,7,8 ".
					" order by 7 DESC";
					$_SESSION['sql'] = $sql; //Linea agregada para la busqueda en el botón de búsqueda
								//    echo $sql;
			return $sql;
		}
		
		public function qPrestamoCirculanteNuevo(){
			$sql = "select u.idusuario as id, 
					ps.tipoidentificacion as tipo_de_identificacion,
					ps.identificacion as cedula_de_identidad,
					pf.nombre as perfil,
					ps.nombres,
					ps.apellidos,
					ps.idgenero as genero,
					co.nombre as correo_electronico,
					te.nombre as Telefono,
					p.idprestamo,
					l.cota as cota__,
					l.titulo as documento,
					lu.ejemplares as nro,
					tp.nombre as prestamo,
					c.nom as ubic
					from biblioteca.prestamo as p 
					join biblioteca.libroubicacion as lu on p.idlibroubicacion = lu.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro			
					join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					join biblioteca.statusprestamo as sp on sp.idstatusprestamo=p.idstatusprestamo
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join usuario as u on u.idusuario = p.idusuario
					join persona as ps on ps.idpersona = u.idpersona
					left join correo as co on co.idpersona=ps.idpersona
					left join telefono as te on te.idpersona=ps.idpersona
					join centro as c on c.idcentro = u.idcentro
					join perfil as pf on pf.idperfil = p.idperfil
					where p.idusuario= (1) 
					LIMIT 1";
			return $sql;
		}

		public function qPrestamoCirculanteUsuarioEmergente($iduser){
			$sql = "select 
					u.idusuario as id,
					ps.apellidos || ', ' || ps.nombres as Apellidos_y_nombres____,
					pf.nombre || ' - ' || 'MENCION' as _CECA,
					c.nombre as CECA,
					ps.identificacion,
					p.idprestamo,
					l.cota as cota___,
					l.titulo as documento___,
					td.nombre as tipologia,
					cl.nom as CECCA,
					sp.nombre as estatus
					from biblioteca.prestamo as p
					join biblioteca.libroubicacion as lu on p.idlibroubicacion = lu.idlibroubicacion
					join biblioteca.libro as l on l.idlibro = lu.idlibro
					left join biblioteca.tipoprestamo as tp on tp.idtipoprestamo = p.idtipoprestamo
					join biblioteca.statusprestamo as sp on sp.idstatusprestamo=p.idstatusprestamo
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join usuario as u on u.idusuario = p.idusuario
					join persona as ps on ps.idpersona = u.idpersona
					join centro as c on c.idcentro = u.idcentro
					join centro as cl on cl.idcentro=lu.idcentro
					join perfil as pf on pf.idperfil = p.idperfil
					where p.idusuario= ({$iduser}) 
					order by 1";
			return $sql;
		}
		
		public function qDocumentoNuevo($id){
			$sql = "select l.idlibro as id,
						l.cota, 
						l.idtipodocumento as id_tipo_documento,
						c.idcentro as id_centro,
						lu.ejemplares,
						l.titulo,
						a.idautor as id_autor,
						a.nombre as nuevo_autor,
						l.ideditorial as id_editorial,
						e.nombre as nueva_editorial,
						l.ano, 
						l.edicion, 
						l.isbn, 
						m.idmateria as id_materia,
						m.nombre as nuevo_descriptor,
						l.resumen from biblioteca.libro as l 
						left join biblioteca.editorial as e on (e.ideditorial = l.ideditorial)
						left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
						left join biblioteca.autor as a on a.idautor = al.idautor
						left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro
						left join biblioteca.materia as m on m.idmateria = lm.idmateria
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
						join centro as c on c.idcentro = lu.idcentro".
						($id!='' ? " where lu.idlibroubicacion=$id" : " limit 1");
					//echo $sql;
			return $sql;
		}

		public function qDocumentoNuevoDetalle($id,$idTipoDatos){
			$sql = "select cd.idlibro as id,
						ti.idtipoimpresion as id_tipo_de_impresion,
						cd.pais, 
						cd.ciudad,
						cd.idioma,
						cd.titulotraducido as titulo_traducido,
						cd.serie as serie_o_coleccion, 
						cd.nroreferencia as numero_de_referencia,
						cd.nropaginas as numero_de_paginas,
						cd.tamano,
						to_char(cd.fechaadquisicion,'DD/MM/YYYY') as fecha_de_adquisicion,
						cd.idformaadquisicion as id_forma_de_adquisicion,
											 
						cd.sistema,
						cd.formato,

						cd.issn,
						cd.volumenes,
						cd.numero as numero_de_volumen,
						cd.mes_ano as mes_y_ano, 
						cd.periocidad from biblioteca.camposdocumentos as cd 
						left join biblioteca.tipoimpresion as ti on ti.idtipoimpresion = cd.idtipoimpresion
						join biblioteca.libro as l on (l.idlibro = cd.idlibro)
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro".
						($id!='' ? " where lu.idlibroubicacion=$id" : " limit 1");
						
			return $sql;
		}

		public function qDocumentoNuevoTabla($id){
			$sql = "select lc.idlibro as id,
						lc.nombre as titulos
						from biblioteca.librocontenido as lc 
						join biblioteca.libro as l on (l.idlibro = lc.idlibro)
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro".
						($id!='' ? " where lu.idlibroubicacion=$id" : " limit 1");
					
			return $sql;
		}

		public function qUltimaCotaDocumento(){
			$sql = "select SUBSTRING(l.cota, 5) as cota, l.idlibro
						from
						biblioteca.libro l
						where cota ilike ('S/C-%')
						order by 2 DESC
						LIMIT 1";
			return ($sql);
		}
		
		public function qCotaDocumento($id,$idCentro){
			$sql = "select l.idlibro as id,
						l.cota, 
						l.idtipodocumento as id_tipo_documento,
						lu.ejemplares,
						l.titulo,
						a.idautor as id_autor,
						l.ideditorial as id_editorial,
						l.ano, 
						l.edicion, 
						l.isbn, 
						c.idcentro as id_centro, 
						m.idmateria as id_materia,
						c.nombre as _nombrecentro,
						l.resumen,
						cd.*,
						lc.*,
						lu.idlibroubicacion
						from biblioteca.libro as l 
						left join biblioteca.editorial as e on (e.ideditorial = l.ideditorial)
						left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
						left join biblioteca.autor as a on a.idautor = al.idautor
						left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro
						left join biblioteca.materia as m on m.idmateria = lm.idmateria
						join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
						join centro as c on c.idcentro = lu.idcentro
						left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro
						left join biblioteca.librocontenido as lc on lc.idlibro = l.idlibro".
						($id!='' ? " where l.cota='{$id}'".( $idCentro!='' ? " and lu.idcentro={$idCentro}" : "" ) : "");
					
			return $sql;
		}

		public function qEstudianteSICE($arrData) {
			$sql = "select distinct
					e.cedulaidentidad,
					e.apellidos,
					e.nombres,
					e.contrasena,
					e.direccion,
					e.email,
					e.sexo,
					e.telefono,
					e.operadora,
					e.celular,
					e.fechanacimiento,
					SUBSTRING(e.cedulaidentidad, 1,1) as tipoidentificador
					from estudiante as e
					join estudianteorganizacion as eo on (eo.idestudiante = e.idestudiante)
					join pensumxorganizacion as pxo on (pxo.idpensumxorganizacion=eo.idpensumxorganizacion)
					join organizacion as o on (o.idorganizacion=pxo.organizacion)
					join organizacion as op on (op.idorganizacion=o.padre)
					where
					SUBSTRING(e.cedulaidentidad, 3) = '{$arrData}' 
					and eo.status = 1";
			return ($sql);
		}
			
		public function qDocenteSICE($arrData) {
			$sql = "select distinct
					s.cedulaidentidad,
					d.apellidos,
					d.nombres,
					s.contrasena,
					d.direccion,
					d.email,
					d.sexo,
					d.telefono,
					d.operadora,
					d.celular,
					d.fechanacimiento,
					SUBSTRING(d.cedulaidentidad, 1,1) as tipoidentificador
					from docente as d
					join seguridad as s on (s.cedulaidentidad = d.cedulaidentidad)
					where
					SUBSTRING(s.cedulaidentidad, 3) = '{$arrData}' and
									d.status = 1
					";
			return $sql;
		}
		
	// FIN FUNCIONES DE BIBILIOTECA

		public function qConsultaGeneralDetallada(){
			$sql = "select  
					lu.idlibroubicacion as id,
					l.cota as cota,
					a.nombre as autor_del_documento,
					c.nombre as CECA,                                
					lu.ejemplares,
					td.nombre as tipologia,
					l.titulo as titulo_del_documento,
					c.idcentro as idcentro,
					l.ano,
					l.isbn,
					e.nombre as editorial,
					m.nombre as descriptor,
					cd.pais,
					cd.idioma,
					cd.nropaginas,
					cd.tamano
					from biblioteca.libro as l 
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
					join centro as c on c.idcentro = lu.idcentro
					left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
					left join biblioteca.autor as a on a.idautor = al.idautor 
					left join biblioteca.editorial as e on e.ideditorial = l.ideditorial 
					left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro 
					left join biblioteca.materia as m on lm.idmateria = m.idmateria 
					left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro ".
					($_SESSION['criterioBusqueda']!='' ? " where ". $_SESSION['criterioBusqueda']:'').
					" order by 1";
					$_SESSION['sql'] = $sql; //Linea agregada para la busqueda en el botón de búsqueda
			return $sql;
		}
		
		public function qConsultaGeneralDetallada2(){
			$sql = "select distinct on (1) 
					lu.idlibroubicacion as id,
					l.cota as cota_doc,
					a.nombre as autor_del_documento,
					c.nombre as CECA,                                
					lu.ejemplares,
					td.nombre as tipologia,
					l.titulo as titulo_del_documento,
					c.idcentro as idcentro,
					l.ano,
					l.isbn,
					e.nombre as editorial,
					m.nombre as descriptor,
					cd.pais,
					cd.idioma,
					cd.nropaginas,
					cd.tamano
					from biblioteca.libro as l 
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
					join centro as c on c.idcentro = lu.idcentro
					left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
					left join biblioteca.autor as a on a.idautor = al.idautor 
					left join biblioteca.editorial as e on e.ideditorial = l.ideditorial 
					left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro 
					left join biblioteca.materia as m on lm.idmateria = m.idmateria 
					left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro ".
					($_SESSION['criterioBusqueda']!='' ? " where ". $_SESSION['criterioBusqueda']:'').
					" order by 1";
					$_SESSION['sql'] = $sql; //Linea agregada para la busqueda en el botón de búsqueda
			return $sql;
		}
		
		public function qConsultasLibroEmergente($libro){
			$sql = "select 
					l.idlibro as id,
					l.titulo as titulo_del_documento,
					td.nombre as tipologia,
					l.cota as cota,
					l.isbn as datos,
					e.nombre as editorial,  
					a.nombre as autor_del_documento,
					l.ano,
					l.edicion,
					c.nom as CECA____, 
					m.nombre as materia___,
					lu.ejemplares,
					l.resumen
					from biblioteca.libro as l 
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
									join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
					join centro as c on c.idcentro = lu.idcentro
									left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
									left join biblioteca.autor as a on a.idautor = al.idautor
									left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro
									left join biblioteca.materia as m on m.idmateria = lm.idmateria
									left join biblioteca.editorial as e on e.ideditorial = l.ideditorial
									where lu.idlibroubicacion= ({$libro})
					order by 1";
			return $sql;
		}
		
		public function qConsultaLibro($libro){
			$sql = "select
					lu.idlibroubicacion as ID,
					l.cota as _cota_doc, 
					l.titulo as titulo_del_documento,
					l.resumen,
					l.ano as ano,        
					cd.pais,               
					cd.sistema,               
					cd.idioma,               
					cd.formato,               
					cd.nropaginas as numero_de_paginas,               
					cd.titulotraducido as titulo_traducido,               
					cd.ciudad,               
					cd.serie,               
					cd.nroreferencia as numero_de_referencia,               
					cd.periocidad,                                  
					cd.issn,               
					cd.volumenes,               
					cd.numero,               
					cd.mes_ano as mes_y_ano,               
					ti.nombre as tipo_de_impresion,               
					cd.tamano,               
					a.idautor as ID,
					a.nombre as autor_del_documento,
					c.idcentro as ID,
					c.nombre as CECA___, 
					m.idmateria as ID,
					m.nombre as materia___
					from biblioteca.libro as l 
					join biblioteca.tipodocumento as td on td.idtipodocumento=l.idtipodocumento
					join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
					join centro as c on c.idcentro = lu.idcentro
					left join biblioteca.autorlibro as al on al.idlibro = l.idlibro
					left join biblioteca.autor as a on a.idautor = al.idautor
					left join biblioteca.libromateria as lm on lm.idlibro = l.idlibro
					left join biblioteca.materia as m on m.idmateria = lm.idmateria
					left join biblioteca.camposdocumentos as cd on cd.idlibro = l.idlibro
					left join biblioteca.tipoimpresion as ti on cd.idtipoimpresion = ti.idtipoimpresion
					where lu.idlibroubicacion= ({$libro})
					order by 1";
			return $sql;
		}

		// Funciones de Bilbioteca para Estadisticas //

		public function qEstadisticasDocumentos (){
			$sql = " select c.nombre,td.nombre,count (td.idtipodocumento) as titulos,sum(lu.ejemplares) as ejemplares from biblioteca.libro l
					join biblioteca.libroubicacion as lu on lu.idlibro = l.idlibro
					join centro as c on c.idcentro = lu.idcentro
					join biblioteca.tipodocumento as td on td.idtipodocumento = l.idtipodocumento
					left join biblioteca.libromateria as ml on ml.idlibro = l.idlibro
					left join biblioteca.materia as m on m.idmateria = ml.idmateria
					group by 1,2
					order by 1,2";	
			return $sql;
		}

		// Funciones de Bilbioteca para Auditoria //

		public function qAuditoria ($identificacion='',$fechainicio='',$fechafin=''){
			if ($fechafin=='') {
				$fechafin = date('d-m-Y');
			}
			$sql = " select p.identificacion, 
					p.apellidos || ', ' || p.nombres as usuario, 
					a.accion as accion_realizada____________, 
					a.hora, 
					a.fecha as _fecha
					from auditoria a
					join usuario as u on u.idusuario = a.idusuario
					join persona as p on p.idpersona = u.idpersona".
					($identificacion!='' ? " where identificacion = '{$identificacion}'" : "").
					($identificacion!='' && $fechainicio!='' ? " and a.fecha >= '{$fechainicio}' and a.fecha <= '{$fechafin}'" : "").
					" order by 5 DESC";	
			$_SESSION['sql'] = '';
			return $sql;
		}

		public function qPersonas (){
			$sql = " select p.identificacion, 
					p.apellidos || ', ' || p.nombres as apellido
					from persona p
					order by 2";	
			return $sql;
		}

	// FUNCIONES PARA LOS PERFILES

		public function qListaPerfiles (){
			$sql = "SELECT PF.IDPERFIL, PF.NOMBRE
					FROM PERFIL AS PF
							order by 1";
			return $sql;
		}

	// FUNCIONES PARA EL USUARIO

		public function qListaUsuarios (){
			$sql = "SELECT U.IDUSUARIO, P.IDENTIFICACION, P.APELLIDOS || ', ' || P.NOMBRES AS APELLIDOS_Y_NOMBRES, CT.IDCENTRO, CT.NOMBRE AS CENTRO, C.IDCARGO, C.NOMBRE AS CARGO, U.IDSTATUSUSUARIO, EU.NOMBRE AS ESTATUS, count(p.identificacion) as numperfiles
					FROM USUARIO AS U
					JOIN PERSONA AS P ON P.IDPERSONA = U.IDPERSONA
					JOIN CARGO AS C ON C.IDCARGO = U.IDCARGO
					JOIN CENTRO AS CT ON CT.IDCENTRO = U.IDCENTRO
					JOIN STATUSUSUARIO AS EU ON EU.IDSTATUSUSUARIO = U.IDSTATUSUSUARIO 
					JOIN PERFILXUSUARIO AS PU ON PU.IDUSUARIO=U.IDUSUARIO
					group by U.IDUSUARIO, P.IDENTIFICACION,APELLIDOS_Y_NOMBRES, CT.IDCENTRO, CENTRO, C.IDCARGO, CARGO, U.IDSTATUSUSUARIO, ESTATUS ".
					" order by 1";
			return $sql;
		}
		
		public function qListaUsuariosPerfil ($id){
			$sql = "SELECT U.IDUSUARIO, P.IDENTIFICACION, P.APELLIDOS || ', ' || P.NOMBRES AS APELLIDOS_Y_NOMBRES, CT.IDCENTRO, CT.NOMBRE AS CENTRO, C.IDCARGO, C.NOMBRE AS CARGO, U.IDSTATUSUSUARIO, EU.NOMBRE AS ESTATUS
					FROM USUARIO AS U
					JOIN PERSONA AS P ON P.IDPERSONA = U.IDPERSONA
					JOIN CARGO AS C ON C.IDCARGO = U.IDCARGO
					JOIN CENTRO AS CT ON CT.IDCENTRO = U.IDCENTRO
					JOIN STATUSUSUARIO AS EU ON EU.IDSTATUSUSUARIO = U.IDSTATUSUSUARIO 
					JOIN PERFILXUSUARIO AS PU ON PU.IDUSUARIO=U.IDUSUARIO 
					Where PU.IDPERFIL=({$id})
					order by 1";
			return $sql;
		}
		
		public function qListaUsuarioDetalle($user){
			$sql = "SELECT DISTINCT U.IDUSUARIO as ID, PF.IDPERFIL as id, PF.NOMBRE AS PERFIL, PA.IDPANTALLA as id, PA.NOMBRE, PAPADRE.IDPANTALLA AS ID, PAPADRE.NOMBRE AS DEPENDE, PA.PADRE as IDpadre, PA.IDTIPOSOFTWARE as id
						FROM USUARIO AS U
						JOIN PERSONA AS P ON P.IDPERSONA = U.IDPERSONA
						JOIN CARGO AS C ON C.IDCARGO = U.IDCARGO
						JOIN CENTRO AS CT ON CT.IDCENTRO = U.IDCENTRO
						JOIN STATUSUSUARIO AS EU ON EU.IDSTATUSUSUARIO = U.IDSTATUSUSUARIO
						LEFT JOIN PERFILXUSUARIO AS PXU ON PXU.IDUSUARIO = U.IDUSUARIO
						LEFT JOIN PERFIL AS PF ON PF.IDPERFIL = PXU.IDPERFIL
						LEFT JOIN PANTALLAXPERFIL AS PPF ON PPF.IDPERFIL = PF.IDPERFIL
						LEFT JOIN PANTALLAXPERFILXACCION AS PPPA ON PPPA.IDPANTALLAXPERFIL = PPF.IDPANTALLAXPERFIL
						LEFT JOIN PANTALLA AS PA ON PA.IDPANTALLA = PPF.IDPANTALLA
						LEFT JOIN PANTALLA AS PAPADRE ON PAPADRE.IDPANTALLA=PA.PADRE
					where U.IDUSUARIO= ({$user})
					order by PERFIL, IDPADRE";
			return $sql;
		}
		
		public function qUsuarioDetalle($user){
			$sql = "SELECT DISTINCT U.IDUSUARIO as IDusuario, P.IDENTIFICACION, PF.NOMBRE AS PERFIL, P.nombres, P.apellidos, ct.nombre, co.nombre, T.NOMBRE, C.NOMBRE
						FROM USUARIO AS U
						JOIN PERSONA AS P ON P.IDPERSONA = U.IDPERSONA
						LEFT JOIN CORREO AS CO ON CO.IDPERSONA = P.IDPERSONA
						LEFT JOIN TELEFONO AS T ON T.IDPERSONA = P.IDPERSONA
						JOIN CARGO AS C ON C.IDCARGO = U.IDCARGO
						JOIN CENTRO AS CT ON CT.IDCENTRO = U.IDCENTRO
						JOIN STATUSUSUARIO AS EU ON EU.IDSTATUSUSUARIO = U.IDSTATUSUSUARIO
						LEFT JOIN PERFILXUSUARIO AS PXU ON PXU.IDUSUARIO = U.IDUSUARIO
						LEFT JOIN PERFIL AS PF ON PF.IDPERFIL = PXU.IDPERFIL
					where U.IDUSUARIO= ({$user})";
			return $sql;
		}
		
		public function qListaUsuarioPerfilDetalle($perfil){
			$sql = "SELECT PA.IDPANTALLA, PA.PADRE, PA.IDTIPOSOFTWARE, PA.DESCRIPCION
						FROM PANTALLAXPERFIL AS PPF
						JOIN PANTALLAXPERFILXACCION AS PPPA ON PPPA.IDPANTALLAXPERFIL = PPF.IDPANTALLAXPERFIL
						JOIN PANTALLA AS PA ON PA.IDPANTALLA = PPF.IDPANTALLA
						where PPF.IDPERFIL= ({$perfil})";
			return $sql;
		}
		
		public function qListaPerfilDetalle($user){
			$sql = "SELECT DISTINCT PF.IDPERFIL as id, PF.NOMBRE AS PERFIL, PA.IDPANTALLA as id, PA.NOMBRE, PAPADRE.IDPANTALLA AS ID, PAPADRE.NOMBRE AS DEPENDE, PA.PADRE as IDpadre, PA.IDTIPOSOFTWARE as id
						FROM PERFIL AS PF
						LEFT JOIN PANTALLAXPERFIL AS PPF ON PPF.IDPERFIL = PF.IDPERFIL
						LEFT JOIN PANTALLAXPERFILXACCION AS PPPA ON PPPA.IDPANTALLAXPERFIL = PPF.IDPANTALLAXPERFIL
						LEFT JOIN PANTALLA AS PA ON PA.IDPANTALLA = PPF.IDPANTALLA
						LEFT JOIN PANTALLA AS PAPADRE ON PAPADRE.IDPANTALLA=PA.PADRE
					where PF.IDPERFIL= ({$user})
					order by PERFIL, IDPADRE";
			return $sql;
		}
		
		public function qListaPantallas(){
			$sql = "SELECT * FROM PANTALLA AS PA
					order by IDPANTALLA";
			return $sql;
		}
		
		public function qListaPerfil($id){
			$sql = "SELECT P.NOMBRE FROM PERFIL AS P
					where idperfil = ({$id})
					order by IDPERFIL";
			return $sql;
		}
		
		public function qListaPerfilUsuario ($id){
			$sql = "SELECT P.idperfil, P.NOMBRE FROM PERFIL AS P
					JOIN perfilxusuario as pxu on pxu.idperfil=p.idperfil
					JOIN usuario as u on pxu.idusuario=u.idusuario
					where u.idusuario = ({$id})
					order by 1";
			return $sql;
		}
		   
		public function qListaUsuarioNroPerfiles($user){
			$sql = "SELECT DISTINCT PF.IDPERFIL
					FROM USUARIO AS U
						JOIN PERSONA AS P ON P.IDPERSONA = U.IDPERSONA
						JOIN CARGO AS C ON C.IDCARGO = U.IDCARGO
						JOIN CENTRO AS CT ON CT.IDCENTRO = U.IDCENTRO
						JOIN STATUSUSUARIO AS EU ON EU.IDSTATUSUSUARIO = U.IDSTATUSUSUARIO
						LEFT JOIN PERFILXUSUARIO AS PXU ON PXU.IDUSUARIO = U.IDUSUARIO
						LEFT JOIN PERFIL AS PF ON PF.IDPERFIL = PXU.IDPERFIL
						LEFT JOIN PANTALLAXPERFIL AS PPF ON PPF.IDPERFIL = PF.IDPERFIL
						LEFT JOIN PANTALLAXPERFILXACCION AS PPPA ON PPPA.IDPANTALLAXPERFIL = PPF.IDPANTALLAXPERFIL
						LEFT JOIN PANTALLA AS PA ON PA.IDPANTALLA = PPF.IDPANTALLA
						LEFT JOIN PANTALLA AS PAPADRE ON PAPADRE.IDPANTALLA=PA.PADRE
						WHERE U.IDUSUARIO = ({$user})";
			return $sql;
		}
		
	}
?>
