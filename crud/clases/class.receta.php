<?php
class receta
{
	private $IdReceta;
	private $consulta;
	private $medicamento;
	private $cantidad;
	private $con;

	function __construct($cn)
	{
		$this->con = $cn;
	}


	//*********************** 3.1 METODO update_consulta() **************************************************	

	public function update_receta($nombreUser)
	{
		$this->IdReceta = $_POST['IdReceta'];
		$this->consulta = $_POST['consulta'];
		$this->medicamento = $_POST['medicamentoCMB'];

		$this->cantidad = $_POST['cantidad'];

		$sql = "UPDATE recetas SET idConsulta='$this->consulta',
									idMedicamento=$this->medicamento,
									cantidad='$this->cantidad'
				WHERE IdReceta=$this->IdReceta;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó",$nombreUser);
		} else {
			echo $this->_message_error("al modificar",$nombreUser);
		}
	}


	//*********************** 3.2 METODO save_consulta() **************************************************	

	public function save_receta($nombreUser)
	{

		$this->consulta = $_POST['consulta'];
		$this->medicamento = $_POST['medicamentoCMB'];
		$this->cantidad = $_POST['cantidad'];

		/*PRUEBA DE ESCRITORIO*/ /*MANIPULACION DE LA FOTO*/
		/*echo "<br> FILES <br>";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";*/

		//exit;

		$sql = "INSERT INTO recetas VALUES(NULL,
											'$this->consulta',
											'$this->medicamento',
											'$this->cantidad');";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("guardó",$nombreUser);
		} else {
			echo $this->_message_error("guardar",$nombreUser);
		}
	}


	//*************************************** PARTE I ************************************************************


	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_db($tabla, $valor, $etiqueta, $nombre, $defecto)
	{
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while ($row = $res->fetch_assoc()) {
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor]) ? '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}


	//************************************* PARTE II ****************************************************	

	public function get_form($nombreUser, $IdReceta = NULL)
	{

		if ($IdReceta == NULL) {
			$this->consulta = NULL;
			$this->medicamento = NULL;
			$this->cantidad = NULL;

			$flag = NULL;
			$op = "new";
		} else {
			$sql = "SELECT * FROM recetas WHERE IdReceta=$IdReceta;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar el consulta con IdReceta= " . $IdReceta;
				echo $this->_message_error($mensaje,$nombreUser);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/*echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>";*/

				$this->consulta = $row['IdConsulta'];
				$this->medicamento = $row['IdMedicamento'];
				$this->cantidad = $row['Cantidad'];

				$flag = "disabled";
				$op = "update";
			}
		}

		$html = '
		<form name="consultas" method="POST" action="index.php?op='.$nombreUser.'" enctype="multipart/form-data">
		
		<input type="hidden" name="IdReceta" value="' . $IdReceta  . '">
		<input type="hidden" name="operacion" value="' . $op  . '">
		
		<div class="container">
                    <div class="table-responsive">
										<table class="table table-striped mb-0">
				
				<thead style="background-color: #CD5237;">
					<th style="color:white" colspan="2">DATOS DE LA RECETA</th>
				</thead>

				<tbody>
				<tr>
					<td>Consulta:</td>
					<td>' . $this->_get_combo_db("consultas", "idConsulta", "Diagnostico", "consulta", $this->consulta) . '</td>
				</tr>
				<tr>
					<td>Medicamento:</td>
					<td>' . $this->_get_combo_db("medicamentos", "IdMedicamento", "Nombre", "medicamentoCMB", $this->medicamento) . '</td>
				</tr>
				<tr>
					<td>Cantidad:</td>
					<td><input type="numbre" size="15" name="cantidad" value="' . $this->cantidad . '" required></td>
				</tr>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR"></th>
					</table>
					</div>
	</div>';
		return $html;
	}



	public function get_list($nombreUsuario,$idUsuario,$rolId)
	{
		$flag = NULL;
		if($rolId == 3){
			$flag = "disabled";
		}
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
	
		<div class="container">
    <div class="tab" role="tabpanel">
                    <div class="table-responsive">
											<table class="table table-striped mb-0">
			
											<thead style="background-color: #CD5237;">
												<th colspan="8" class="text-center" style="color: white;">DATOS DE LA RECETA</th>
											</thead>
											<tr>
												<th colspan="8" class="text-center"><a class="btn btn-primary '.$flag.'" href="index.php?d=' . $d_new_final . '&op='.$nombreUsuario.'" class="align-middle">Nuevo</a></th>
											</tr>
											<tr>
												<th>Consulta</th>
												<th>Medicamento</th>
												<th>Cantidad</th>
												<th colspan="3">Acciones</th>
											</tr>';
		$sql = "SELECT r.IdReceta, c.Diagnostico AS consultas, m.Nombre AS medicamentos, r.Cantidad
				FROM recetas r
				JOIN consultas c ON r.IdConsulta = c.IdConsulta
				JOIN medicamentos m ON r.IdMedicamento = m.IdMedicamento
				JOIN medicos med ON c.IdMedico = med.IdMedico
				JOIN pacientes pa ON c.IdPaciente = pa.IdPaciente
				WHERE med.IdUsuario = $idUsuario OR pa.IdUsuario = $idUsuario;";

		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&IdReceta=' . $row['IdReceta'] . '">Borrar</a></td>
		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdReceta'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['IdReceta'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['IdReceta'];
			$d_det_final = base64_encode($d_det);
			$html .= '
				<tr>
					<td>' . $row['consultas'] . '</td>
					<td>' . $row['medicamentos'] . '</td>
					<td>' . $row['Cantidad'] . '</td>
					<td><a class="btn btn-primary '.$flag.'" href="index.php?d=' . $d_del_final . '&op='.$nombreUsuario.'">Borrar</a></td>
					<td><a class="btn btn-primary '.$flag.'" href="index.php?d=' . $d_act_final . '&op='.$nombreUsuario.'">Actualizar</a></td>
					<td><a class="btn btn-primary" href="index.php?d=' . $d_det_final . '&op='.$nombreUsuario.'">Detalle</a></td>
				</tr>
				';
		}
		$html .= '  
	
		</table>
</div>

</div>';

		return $html;
	}


	public function get_detail_receta($IdReceta, $nombreUsuario)
	{
		$sql = "SELECT 
				r.IdReceta,
				c.Diagnostico as consultas,
				m.Nombre as medicamentos,
				r.Cantidad,
				p.Nombre as nombre_paciente,
				med.Nombre as nombre_medico
				FROM 
					recetas r
				JOIN 
					consultas c ON r.idConsulta = c.IdConsulta
				JOIN 
					medicamentos m ON r.idMedicamento = m.IdMedicamento
				JOIN 
					pacientes p ON c.IdPaciente = p.IdPaciente
				JOIN 
					medicos med ON c.IdMedico = med.IdMedico
				WHERE 
					r.IdReceta = $IdReceta;";
		
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();

		$num = $res->num_rows;

		//Si es que no existiese ningun registro debe desplegar un mensaje 
		//$mensaje = "tratar de eliminar el consulta con IdReceta= ".$IdReceta;
		//echo $this->_message_error($mensaje);
		//y no debe desplegarse la tablas

		if ($num == 0) {
			$mensaje = "tratar de editar el consulta con IdReceta= " . $IdReceta;
			echo $this->_message_error($mensaje, $nombreUsuario);
		} else {
			$html = '
			<div class="container">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead style="background-color: #CD5237;">
                        <th colspan="4" class="text-center" style="color:white;">CONSULTAS MEDICAS</th>
                    </thead>
                    <tbody>
					<tr>
						<td>Nombre Médico: </td>
						<td>' . $row['nombre_medico'] . '</td>
					</tr>
					<tr>
						<td>Nombre Paciente: </td>
						<td>' . $row['nombre_paciente'] . '</td>
					</tr>
                        <tr>
						<td>Consulta: </td>
						<td>' . $row['consultas'] . '</td>
					</tr>
					<tr>
						<td>Medicamento: </td>
						<td>' . $row['medicamentos'] . '</td>
					</tr>
					<tr>
						<td>Cantidad: </td>
						<td>' . $row['Cantidad'] . '</td>
					</tr>
					<tr>
							<th colspan="2"><a class="btn btn-primary col-12 " href="index.php?op='.$nombreUsuario.'">Regresar</a></th>
						</tr>';

        $html .= '
                    </tbody>
                </table>
            </div>
        </div>';

			return $html;
		}
	}


	public function delete_receta($IdReceta, $nombreUser)
	{
		$sql = "DELETE FROM recetas WHERE IdReceta=$IdReceta;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ", $nombreUser);
		} else {
			echo $this->_message_error("eliminar", $nombreUser);
		}
	}

	//*************************************************************************	

	private function _message_error($tipo,$nombreUser)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
			<th><a href="index.php?op='.$nombreUser.'">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}


	private function _message_ok($tipo,$nombreUser)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
			<th><a href="index.php?op='.$nombreUser.'">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	//****************************************************************************	

} // FIN SCRPIT
