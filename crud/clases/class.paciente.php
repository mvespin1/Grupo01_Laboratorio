<?php
class paciente
{
	private $IdPaciente;
	private $IdUsuario;
	private $nombre;
	private $cedula;
	private $edad;
	private $genero;
	private $estatura;
	private $peso;
	private $con;

	function __construct($cn)
	{
		$this->con = $cn;
	}


	//*********************** 3.1 METODO update_consulta() **************************************************	

	public function update_paciente()
	{
		$this->IdPaciente = $_POST['IdPaciente'];
		$this->IdUsuario = $_POST['IdUsuarioCMB'];
		$this->nombre = $_POST['nombre'];
		$this->cedula = $_POST['cedula'];
		$this->edad = $_POST['edad'];
		$this->genero = $_POST['generoCMB'];
		$this->estatura = $_POST['estatura'];
		$this->peso = $_POST['peso'];

		$sql = "UPDATE pacientes SET idUsuario=$this->IdUsuario,
									nombre='$this->nombre',
									cedula='$this->cedula',
									edad='$this->edad',
									genero='$this->genero',
									estatura='$this->estatura',
									peso='$this->peso'
				WHERE IdPaciente=$this->IdPaciente;";
		//echo $sql;
		//exit;
		if ($this->con->query($sql)) {
			echo $this->_message_ok("modificó");
		} else {
			echo $this->_message_error("al modificar");
		}
	}


	//*********************** 3.2 METODO save_consulta() **************************************************	

	public function save_paciente()
	{
		$this->IdUsuario = $_POST['IdUsuarioCMB'];
		$this->nombre = $_POST['nombre'];
		$this->cedula = $_POST['cedula'];
		$this->edad = $_POST['edad'];
		$this->genero = $_POST['generoCMB'];
		$this->estatura = $_POST['estatura'];
		$this->peso = $_POST['peso'];

		/*PRUEBA DE ESCRITORIO*/ /*MANIPULACION DE LA FOTO*/
		/*echo "<br> FILES <br>";
		echo "<pre>";
		print_r($_FILES);
		echo "</pre>";*/


		if ($this->IdUsuario == 14) {
			echo $this->_message_warning("Recuerde crear un usuario nuevo para este paciente antes de guardar.");
		} else {
			// Construir la consulta SQL
			$sql = "INSERT INTO pacientes VALUES(NULL,
												$this->IdUsuario,
												'$this->nombre',
												'$this->cedula',
												'$this->edad',
												'$this->genero',
												'$this->estatura',
												'$this->peso');";
	
			// Ejecutar la consulta
			if ($this->con->query($sql)) {
				echo $this->_message_ok("Guardado correctamente");
			} else {
				echo $this->_message_error("Error al guardar");
			}
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

	/*Aquí se agregó el parámetro:  $defecto*/
	private function _get_radio($arreglo, $nombre, $defecto)
	{

		$html = '
		<table border=0 align="left">';

		//CODIGO NECESARIO EN CASO QUE EL USUARIO NO SE ESCOJA UNA OPCION

		foreach ($arreglo as $etiqueta) {
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';

			if ($defecto == NULL) {
				// OPCION PARA GRABAR UN NUEVO CONSULTA (IdPaciente=0)
				$html .= '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>';
			} else {
				// OPCION PARA MODIFICAR UN CONSULTA EXISTENTE
				$html .= ($defecto == $etiqueta) ? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>' : '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
			}

			$html .= '</tr>';
		}
		$html .= '
		</table>';
		return $html;
	}


	//************************************* PARTE II ****************************************************	

	public function get_form($IdPaciente = NULL)
	{

		if ($IdPaciente == NULL) {
			$this->IdUsuario = NULL;
			$this->nombre = NULL;
			$this->cedula = NULL;
			$this->edad = NULL;
			$this->genero = NULL;
			$this->estatura = NULL;
			$this->peso = NULL;

			$flag = NULL;
			$op = "new";
		} else {
			$sql = "SELECT pa.IdPaciente, u.Nombre as IdUsuario, pa.Nombre, pa.Cedula, pa.Edad, pa.Genero, pa.Estatura, pa.Peso
			FROM pacientes pa
			JOIN usuarios u ON u.IdUsuario = pa.IdUsuario WHERE IdPaciente=$IdPaciente;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();

			$num = $res->num_rows;
			if ($num == 0) {
				$mensaje = "tratar de actualizar el consulta con IdPaciente= " . $IdPaciente;
				echo $this->_message_error($mensaje);
			} else {

				// ***** TUPLA ENCONTRADA *****
				/*echo "<br>TUPLA <br>";
				echo "<pre>";
				print_r($row);
				echo "</pre>";*/

				$this->nombre = $row['Nombre'];
				$this->IdUsuario = $row['IdUsuario'];
				$this->cedula = $row['Cedula'];
				$this->edad = $row['Edad'];
				$this->genero = $row['Genero'];
				$this->estatura = $row['Estatura'];
				$this->peso = $row['Peso'];

				$flag = "disabled";
				$op = "update";
			}
		}

		$genero = [
			"Masculino",
			"Femenino",
			"Otro"
		];

		$html = '
		<form name="paciente" method="POST" action="index.php" enctype="multipart/form-data">
		
		<input type="hidden" name="IdPaciente" value="' . $IdPaciente  . '">
		<input type="hidden" name="op" value="' . $op  . '">
		
		<div class="container">
                    <div class="table-responsive">
										<table class="table table-striped mb-0">
				
				<thead style="background-color: #CD5237;">
					<th style="color:white" colspan="2">DATOS DE LOS PACIENTES</th>
				</thead>

				<tbody>
				<tr>
					<td>Nombre:</td>
					<td><input type="text" size="30" name="nombre" value="' . $this->nombre . '" required></td>
				</tr>
				<tr>
					<td>Usuario:</td>
					<td>' . $this->_get_combo_db("usuarios", "IdUsuario", "Nombre", "IdUsuarioCMB", $this->IdUsuario) . '</td>
				</tr>
				<tr>
					<td>Cedula:</td>
					<td><input type="number" size="30" name="cedula" value="' . $this->cedula . '" required></td>
				</tr>
				<tr>
					<td>Edad:</td>
					<td><input type="number" size="15" name="edad" value="' . $this->edad . '" required></td>
				</tr>
				<tr>
					<td>Genero:</td>
					<td>' . $this->_get_radio($genero, "generoCMB", $this->genero) . '</td>
				</tr>
				<tr>
					<td>Estatura:</td>
					<td><input type="number" size="15" name="estatura" value="' . $this->estatura . '" required></td>
				</tr>
				<tr>
					<td>Peso:</td>
					<td><input type="number" size="15" name="peso" value="' . $this->peso . '" required></td>
				</tr>
			
				<tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR"></th>
					</tbody>
					</table>
					</div>
	</div>';
		return $html;
	}



	public function get_list()
	{
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
	
		<div class="container">
    <div class="tab" role="tabpanel">
                    <div class="table-responsive">
											<table class="table table-striped mb-0">
			
											<thead style="background-color: #CD5237;">
												<th colspan="8" class="text-center" style="color: white;">DATOS DE LOS PACIENTES</th>
											</thead>
											<tr>
												<th colspan="8" class="text-center"><a class="btn btn-primary " href="index.php?d=' . $d_new_final . '" class="align-middle">Nuevo</a></th>
											</tr>
											<tr>
												<th>Nombre</th>
												<th>Edad</th>
												<th>Genero</th>
												<th colspan="3">Acciones</th>
											</tr>';
		$sql = "SELECT pa.IdPaciente, u.Nombre as IdUsuario, pa.Nombre, pa.Cedula, pa.Edad, pa.Genero, pa.Estatura, pa.Peso
				FROM pacientes pa
				JOIN usuarios u ON u.IdUsuario = pa.IdUsuario;";
				
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&IdPaciente=' . $row['IdPaciente'] . '">Borrar</a></td>
		while ($row = $res->fetch_assoc()) {
			$d_del = "del/" . $row['IdPaciente'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['IdPaciente'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['IdPaciente'];
			$d_det_final = base64_encode($d_det);
			$html .= '
				<tr>
					<td>' . $row['Nombre'] . '</td>
					<td>' . $row['Edad'] . '</td>
					<td>' . $row['Genero'] . '</td>
					<td><a class="btn btn-primary " href="index.php?d=' . $d_del_final . '">Borrar</a></td>
					<td><a class="btn btn-primary " href="index.php?d=' . $d_act_final . '">Actualizar</a></td>
					<td><a class="btn btn-primary" href="index.php?d=' . $d_det_final . '">Detalle</a></td>
				</tr>
				';
		}
		$html .= '  
	
		</table>
</div>

</div>';

		return $html;
	}


	public function get_detail_paciente($IdPaciente)
	{
		$sql = "SELECT pa.IdPaciente, u.Nombre as IdUsuario, pa.Nombre, pa.Cedula, pa.Edad, pa.Genero, pa.Estatura, pa.Peso, u.Foto 
				FROM pacientes pa
				JOIN usuarios u ON u.IdUsuario = pa.IdUsuario
				AND IdPaciente=$IdPaciente;";

		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();

		$num = $res->num_rows;

		//Si es que no existiese ningun registro debe desplegar un mensaje 
		//$mensaje = "tratar de eliminar el consulta con IdPaciente= ".$IdPaciente;
		//echo $this->_message_error($mensaje);
		//y no debe desplegarse la tablas

		if ($num == 0) {
			$mensaje = "tratar de editar el consulta con IdPaciente= " . $IdPaciente;
			echo $this->_message_error($mensaje);
		} else {
			$html = '
			<div class="container">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead style="background-color: #CD5237;">
                        <th colspan="4" class="text-center" style="color:white;">PACIENTES</th>
                    </thead>
                    <tbody>
                        <tr>
						<td>Nombre: </td>
						<td>' . $row['Nombre'] . '</td>
					</tr>
					<tr>
						<td>Usuario: </td>
						<td>' . $row['IdUsuario'] . '</td>
					</tr>
					<tr>
						<td>Cédula: </td>
						<td>' . $row['Cedula'] . '</td>
					</tr>
					<tr>
						<td>Edad: </td>
						<td>' . $row['Edad'] . '</td>
					</tr>
					<tr>
						<td>Genero: </td>
						<td>' . $row['Genero'] . '</td>
					</tr>	
					<tr>
						<td>Estatura (cm): </td>
						<td>' . $row['Estatura'] . '</td>
					</tr>
					<tr>
						<td>Peso (kg): </td>
						<td>' . $row['Peso'] . '</td>
					</tr>
					<tr>
                            <th colspan="2"><img src="' . PATH_pacientes . $row['Foto'] . '" width="300px"/></th>
                        </tr>
					<tr>
							<th colspan="2"><a class="btn btn-primary col-12 " href="index.php">Regresar</a></th>
						</tr>';

			$html .= '
                    </tbody>
                </table>
            </div>
        </div>';

			return $html;
		}
	}


	public function delete_paciente($IdPaciente)
	{
		$sql = "DELETE FROM pacientes WHERE IdPaciente=$IdPaciente;";
		if ($this->con->query($sql)) {
			echo $this->_message_ok("ELIMINÓ");
		} else {
			echo $this->_message_error("eliminar");
		}
	}

	//*************************************************************************

	private function _get_genero_paciente($nombre)
	{
		$sql = "SELECT Genero FROM pacientes WHERE nombre = $nombre";
		$result = $this->con->query($sql);

		if ($result) {
			$row = $result->fetch_assoc();
			return $row['genero'];
		}

		return null;
	}

	//*************************************************************************	

	private function _message_error($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}


	private function _message_ok($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	private function _message_warning($tipo)
	{
		$html = '
		<table border="0" align="center">
			<tr>
				<th> ' . $tipo . ' </th>
			</tr>
			<tr>
				<th><a href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

	//****************************************************************************	

} // FIN SCRPIT
