<?php
class consultas
{
	private $IdConsulta;
	private $idPaciente;
	private $idMedico;
	private $fechaConsulta;
	private $HI;
	private $HF;
	private $diagnostico;
	private $foto;
	private $con;

	function __construct($cn)
	{
		$this->con = $cn;
	}


	//*********************** 3.1 METODO update_consulta() **************************************************	

	public function update_consultas($nombreUser)
	{
		$this->IdConsulta = $_POST['IdConsulta'];
		$this->idPaciente = $_POST['idPacienteCMB'];
		$this->idMedico = $_POST['idMedicoCMB'];
		$this->fechaConsulta = $_POST['fechaConsulta'];
		$this->HI = $_POST['HI'];
		$this->HF = $_POST['HF'];

		// // Verificar la regla de negocio para pacientes femeninas y ginecólogo
		// $generoPaciente = $this->_get_genero_paciente($this->idPaciente);
		// if ($generoPaciente == 'Femenino' && $this->idMedico != '4') {
		// 	echo $this->_message_error("Las pacientes femeninas solo pueden tomar consulta con la Dra. Lopez de ginecología",$nombreUser);
		// 	exit;
		// }

		// // Verificar la regla de negocio para pacientes masculinos y ginecólogo
		// if ($generoPaciente == 'Masculino' && $this->idMedico == '4') {
		// 	echo $this->_message_error("Los pacientes masculinos no pueden tomar consulta con el Ginecólogo",$nombreUser);
		// 	exit;
		// }

		$this->diagnostico = $_POST['diagnostico'];

		$sql = "UPDATE consultas SET idPaciente='$this->idPaciente',
									idMedico=$this->idMedico,
									fechaConsulta='$this->fechaConsulta',
									HI='$this->HI',
									HF='$this->HF',
									diagnostico='$this->diagnostico'
				WHERE IdConsulta=$this->IdConsulta;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó",$nombreUser);
		} else {
			echo $this->_message_error("al modificar",$nombreUser);
		}
	}


	//*********************** 3.2 METODO save_consulta() **************************************************	

	public function save_consultas($nombreUser)
	{

		$this->fechaConsulta = $_POST['fechaConsulta'];
		$this->diagnostico = $_POST['diagnostico'];
		$this->HI = $_POST['HI'];
		$this->HF = $_POST['HF'];


		$this->idPaciente = $_POST['idPacienteCMB'];
		$this->idMedico = $_POST['idMedicoCMB'];

		// // Verificar la regla de negocio para pacientes femeninas y ginecólogo
		// $generoPaciente = $this->_get_genero_paciente($this->idPaciente);
		// if ($generoPaciente == 'Femenino' && $this->idMedico != '4') {
		// 	echo $this->_message_error("Las pacientes femeninas solo pueden tomar consulta con la Dra. Lopez de ginecología",$nombreUser);
		// 	exit;
		// }

		// // Verificar la regla de negocio para pacientes masculinos y ginecólogo
		// if ($generoPaciente == 'Masculino' && $this->idMedico == '4') {
		// 	echo $this->_message_error("Los pacientes masculinos no pueden tomar consulta con el Ginecólogo",$nombreUser);
		// 	exit;
		// }

		/*PRUEBA DE ESCRITORIO*/ /*MANIPULACION DE LA FOTO*/
		/*echo "<br> FILES <br>";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";*/
 
		$sql = "INSERT INTO consultas VALUES(NULL,
											'$this->idPaciente',
											'$this->idMedico',
											'$this->fechaConsulta',
											'$this->HI',
											'$this->HF',
											'$this->diagnostico');";
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

	public function get_form($nombreUser, $IdConsulta = NULL)
	{

		if ($IdConsulta == NULL) {
			$this->idPaciente = NULL;
			$this->idMedico = NULL;
			$this->fechaConsulta = NULL;
			$this->HI = NULL;
			$this->HF = NULL;
			$this->diagnostico = NULL;

			$flag = NULL;
			$op = "new";
		} else {
			$sql = "SELECT * FROM consultas WHERE IdConsulta=$IdConsulta;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar el consulta con IdConsulta= " . $IdConsulta;
				echo $this->_message_error($mensaje,$nombreUser);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/*echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>";*/

				$this->idPaciente = $row['IdPaciente'];
				$this->idMedico = $row['IdMedico'];
				$this->fechaConsulta = $row['FechaConsulta'];
				$this->HI = $row['HI'];
				$this->HF = $row['HF'];
				$this->diagnostico = $row['Diagnostico'];

				$flag = "disabled";
				$op = "update";
			}
		}

		$html = '
		<form name="consultas" method="POST" action="index.php?op='.$nombreUser.'" enctype="multipart/form-data">
		
		<input type="hidden" name="IdConsulta" value="' . $IdConsulta  . '">
		<input type="hidden" name="operacion" value="' . $op  . '">
		
		<div class="container">
                    <div class="table-responsive">
										<table class="table table-striped mb-0">
				
				<thead style="background-color: #CD5237;">
					<th style="color:white" colspan="2">DATOS DE LA CONSULTA</th>
				</thead>

				<tbody>
				<tr>
					<td>Paciente:</td>
					<td>' . $this->_get_combo_db("pacientes", "idPaciente", "Nombre", "idPacienteCMB", $this->idPaciente) . '</td>
				</tr>
				<tr>
					<td>Medico:</td>
					<td>' . $this->_get_combo_db("medicos", "idMedico", "Nombre", "idMedicoCMB", $this->idMedico) . '</td>
				</tr>
				<tr>
					<td>Fecha Consulta:</td>
					<td><input type="date" size="15" name="fechaConsulta" value="' . $this->fechaConsulta . '" required></td>
				</tr>	
				<tr>
					<td>Hora de Inicio:</td>
					<td><input type="time" size="15" name="HI" value="' . $this->HI . '" required></td>
				</tr>	
				<tr>
					<td>Hora Final:</td>
					<td><input type="time" size="15" name="HF" value="' . $this->HF . '" required></td>
				</tr>	
				<tr>
					<td>Diagnostico:</td>
					<td><input type="text" size="15" name="diagnostico" value="' . $this->diagnostico . '" required></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR"></th>
					</table>
					</div>
	</div>';
		return $html;
	}

	public function get_list($nombreUsuario,$idUsuario,$rolId){
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
												<th colspan="9" class="text-center" style="color: white;">DATOS DE LA CONSULTA</th>
											</thead>
											<tr>
												<th colspan="9" class="text-center"><a class="btn btn-primary '.$flag.'" href="index.php?d=' . $d_new_final . '&op='.$nombreUsuario.'" class="align-middle">Nuevo</a></th>
											</tr>
											<tr>
												<th>Paciente</th>
												<th>Medico</th>
												<th>Fecha Consulta</th>
												<th colspan="3">Acciones</th>
											</tr>';
		$sql = "SELECT c.IdConsulta, p.Nombre AS pacientes, m.Nombre AS medicos, c.FechaConsulta
				FROM consultas c
				JOIN pacientes p ON c.IdPaciente = p.IdPaciente
				JOIN medicos m ON c.IdMedico = m.IdMedico
				WHERE m.IdUsuario = $idUsuario OR p.IdUsuario = $idUsuario";

		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&IdConsulta=' . $row['IdConsulta'] . '">Borrar</a></td>
		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdConsulta'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['IdConsulta'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['IdConsulta'];
			$d_det_final = base64_encode($d_det);
			$html .= '
				<tr>
					<td>' . $row['pacientes'] . '</td>
					<td>' . $row['medicos'] . '</td>
					<td>' . $row['FechaConsulta'] . '</td>
					
					<td><a class="btn btn-primary disabled" href="index.php?d=' . $d_del_final . '&op='.$nombreUsuario.'">Borrar</a></td>
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


	public function get_detail_consultas($IdConsulta,$nombreUsuario)
	{
		$sql = "SELECT c.IdConsulta, p.Nombre as pacientes, p.Edad as pacienteEdad, p.Genero as pacientesGenero, m.Nombre as medicos, e.Descripcion as medicosEspecialidad, c.fechaConsulta, c.HI, c.HF, c.diagnostico  
				FROM consultas c, pacientes p, medicos m, especialidades e
				WHERE c.idPaciente=p.idPaciente AND c.idMedico=m.idMedico AND IdConsulta=$IdConsulta;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();

		$num = $res->num_rows;

		//Si es que no existiese ningun registro debe desplegar un mensaje 
		//$mensaje = "tratar de eliminar el consulta con IdConsulta= ".$IdConsulta;
		//echo $this->_message_error($mensaje);
		//y no debe desplegarse la tablas

		if ($num == 0) {
			$mensaje = "tratar de editar el consulta con IdConsulta= " . $IdConsulta;
			echo $this->_message_error($mensaje,$nombreUsuario);
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
						<td>IdPaciente: </td>
						<td>' . $row['pacientes'] . '</td>
					</tr>
					<tr>
						<td>Edad: </td>
						<td>' . $row['pacienteEdad'] . '</td>
					</tr>
					<tr>
						<td>Genero: </td>
						<td>' . $row['pacientesGenero'] . '</td>
					</tr>
					<tr>
						<td>IdMedico: </td>
						<td>' . $row['medicos'] . '</td>
					</tr>
					<tr>
						<td>Especialidad del Médico: </td>
						<td>' . $row['medicosEspecialidad'] . '</td>
					</tr>
					<tr>
						<td>FechaConsulta: </td>
						<td>' . $row['fechaConsulta'] . '</td>
					</tr>
					<tr>
						<td>Hora de Inicio: </td>
						<td>' . $row['HI'] . '</td>
					</tr>
					<tr>
						<td>Hora Final: </td>
						<td>' . $row['HF'] . '</td>
					</tr>
					<tr>
						<td>Diagnostico: </td>
						<td>' . $row['diagnostico'] . '</td>
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


	public function delete_consultas($IdConsulta,$nombreUser)
	{
		$sql = "DELETE FROM consultas WHERE IdConsulta=$IdConsulta;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ",$nombreUser);
		} else {
			echo $this->_message_error("eliminar",$nombreUser);
		}
	}

	//*************************************************************************

	// private function _get_genero_paciente($idPaciente)
	// {
	// 	$sql = "SELECT genero FROM pacientes WHERE idPaciente = $idPaciente";
	// 	$result = $this->con->query($sql);

	// 	if ($result) {
	// 		$row = $result->fetch_assoc();
	// 		return $row['genero'];
	// 	}

	// 	return null;
	// }

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
