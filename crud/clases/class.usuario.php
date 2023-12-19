<?php

class usuario{
	/* Atributos*/

	private $idUsuario;
	private $Nombre;
	private $Password;
    private $Rol;
    private $Foto;
    private $con;
	
	/*Constructor*/
	function __construct($cn){
		$this->con = $cn;
	}

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function getNombre(){
        return $this->Nombre;  
    }
    public function getPassword(){
        return $this->Password;
    }
    public function getRol(){
        return $this->Rol;
    }

	public function get_usuarios() {
        $sql = "SELECT u.IdUsuario ,u.Nombre, u.Password, u.Rol, u.Foto FROM usuarios u";
        $res = $this->con->query($sql);
        
        $usuarios = array();
    
        while ($row = $res->fetch_assoc()) {
            $usuario = new usuario($this->con); 
            $usuario->idUsuario = $row['IdUsuario'];
            $usuario->Nombre = $row['Nombre'];
            $usuario->Password = $row['Password'];
            $usuario->Rol = $row['Rol'];
            $usuario->Foto = $row['Foto'];
    
            $usuarios[$usuario->Nombre] = $usuario;
        }
    
        return $usuarios;
    }
    private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

    public function getRedirectPage() {
        $rolesPagesMapping = [
            1 => 'Inicio_Sistema_ADM.php',
            2 => 'Inicio_Sistema_Medico.php',
            3 => 'Inicio_Sistema_Paciente.php',
        ];

        $Rol = $this->getRol();

        if (isset($rolesPagesMapping[$Rol])) {
            return $rolesPagesMapping[$Rol];
        } else {
          
            return 'ErrorAutentificacion.php';
        }
    }

    public function validarUsuario($usuario, $clave) {
        $sql = "SELECT * FROM usuarios WHERE Nombre = '$usuario' AND Password = '$clave'";
        $res = $this->con->query($sql);

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $this->Nombre = $row['Nombre'];
            $this->Password = $row['Password'];
            $this->Rol = $row['Rol'];
            $this->idUsuario = $row['IdUsuario'];
            return true;
        } else {
            return false;
        }
    }

    public function update_usuario() {
        $this->idUsuario = $_POST['IdUsuario'];
        $this->Nombre = $_POST['nombre'];
        $this->Password = $_POST['password'];
        $this->Rol = $_POST['RolCMB'];

        $sql = "UPDATE usuarios SET Nombre='$this->Nombre',
                                   Password='$this->Password',
                                   Rol=$this->Rol
                WHERE IdUsuario=$this->idUsuario;";
        
        echo $sql;

        if ($this->con->query($sql)) {
            echo $this->_message_ok("modificó");
        } else {
            echo $this->_message_error("al modificar");
        }
    }

    public function save_usuario() {
        $this->Nombre = $_POST['nombre'];
        $this->Password = $_POST['password'];
        $this->Rol = $_POST['RolCMB'];

		$rolUsuario = $this->Rol;
		switch ($rolUsuario) {
			case '1':
				$dirFoto = PATH_administrador;
				break;
			case '2':
				$dirFoto = PATH_medicos;
				break;
			case '3':
				$dirFoto = PATH_pacientes;
				break;
			// Puedes agregar más casos según sea necesario
			default:
				// Ruta predeterminada si el rol no coincide con ninguno de los casos anteriores
				$dirFoto = 'ruta_a_la_imagen_predeterminada.jpg';
				break;
		}

        $this->Foto = $this->_get_name_file($_FILES['foto']['name'],12);
		
		$path = $dirFoto . $this->Foto;
		
		//exit;
		if(!move_uploaded_file($_FILES['foto']['tmp_name'],$path)){
			$mensaje = "Cargar la imagen";
			echo $this->_message_error($mensaje);
			exit;
		}

        $sql = "INSERT INTO usuarios VALUES(NULL,
                                            '$this->Nombre',
                                            '$this->Password',
                                            $this->Rol,
                                            '$this->Foto');";

        echo $sql;
        if ($this->con->query($sql)) {
            echo $this->_message_ok("guardó");
        } else {
            echo $this->_message_error("guardar");
        }
    }

    public function get_form($id = NULL){
    if ($id == NULL) {
        $this->idUsuario = NULL;
        $this->Nombre = NULL;
        $this->Password = NULL;
        $this->Rol = NULL;

        $flag = NULL;
        $op = "new";
    } else {
        $sql = "SELECT u.IdUsuario, u.Nombre, u.Password, u.Rol, u.Foto
                FROM usuarios u
                WHERE u.IdUsuario = $id;";
        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();

        $num = $res->num_rows;
        if ($num == 0) {
            $mensaje = "tratar de actualizar el usuario con IdUsuario= " . $id;
            echo $this->_message_error($mensaje);
        } else {
            $this->Nombre = $row['Nombre'];
            $this->Password = $row['Password'];
            $this->Rol = $row['Rol'];
            $this->Foto = $row['Foto'];

            $flag = "disabled";
            $op = "update";
        }
    }

    $html = '<div class="container text-center">
		<form name="usuario" method="POST" action="index.php" enctype="multipart/form-data">
		
		<input type="hidden" name="IdUsuario" value="' . $id  . '">
		<input type="hidden" name="operacion" value="' . $op  . '">
		
		<div class="container">
		<div class="table-responsive">
							<table class="table table-striped mb-0">
	
	<thead style="background-color: #CD5237;">
		<th style="color:white" colspan="2">REGISTRO USUARIOS</th>
	</thead>

	<tbody>
	<tr>
					<td>Usuario</td>
					<td><input type="text" size="15" name="nombre" value="' . $this->Nombre . '" required></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="text" size="15" name="password" value="' . $this->Password . '" required></td>
				</tr>
				<tr>
					<td>Rol:</td>
					<td>' . $this->_get_combo_db("roles","IdRol","Nombre","RolCMB",$this->Rol) . '</td>
				</tr>
                <tr>
					<td>Foto:</td>
					<td><input type="file" name="foto" ' . $flag . '></td>
				</tr>
				<tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR"></th>
				</tr>												
				</tbody>
				</table>
				</div>
</div>';
	return $html;
}


	/*********************** 3.6 METODO get_list() ***********************/
	// Metodo para obtener todos los registros de la tabla usuario
	public function get_list(){
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '<div class="container">
		<div class="tab" role="tabpanel">
						<div class="table-responsive">
												<table class="table table-striped mb-0">
				
												<thead style="background-color: #CD5237;">
													<th colspan="8" class="text-center" style="color: white;">DATOS DE LOS USUARIOS</th>
												</thead>
												<tr>
													<th colspan="8" class="text-center"><a class="btn btn-primary " href="index.php?d=' . $d_new_final . '" class="align-middle">Nuevo</a></th>
												</tr>
												<tr>
				<th>Nº</th>
				<th>Usuario</th>
				<th colspan="3">Acciones</th>
			</tr>';
		$sql = "SELECT u.IdUsuario AS idUsuario, u.Nombre
                FROM usuarios u;";	
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&idUsuario=' . $row['idUsuario'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			$d_del = "del/" . $row['idUsuario'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['idUsuario'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['idUsuario'];
			$d_det_final = base64_encode($d_det);					
			$html .= '
				<tr>
					<td>' . $row['idUsuario'] . '</td>
					<td>' . $row['Nombre'] . '</td>
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

	public function get_detail_usuario($id){
		$sql = "SELECT u.Nombre, u.Password, u.Rol, u.Foto
                FROM usuarios u
                WHERE u.IdUsuario = $id;";
        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();
		$rolUsuario = $row['Rol'];
		switch ($rolUsuario) {
			case '1':
				$dirFoto = PATH_administrador;
				break;
			case '2':
				$dirFoto = PATH_medicos;
				break;
			case '3':
				$dirFoto = PATH_pacientes;
				break;
			// Puedes agregar más casos según sea necesario
			default:
				// Ruta predeterminada si el rol no coincide con ninguno de los casos anteriores
				$dirFoto = 'ruta_a_la_imagen_predeterminada.jpg';
				break;
		}
        $num = $res->num_rows;

        if ($num == 0) {
            $mensaje = "tratar de editar el usuario con IdUsuario= " . $id;
            echo $this->_message_error($mensaje);
        } else {
				$html = '<div class="container">
				<div class="table-responsive">
					<table class="table table-striped mb-0">
						<thead style="background-color: #CD5237;">
							<th colspan="4" class="text-center" style="color:white;">USUARIOS</th>
						</thead>
						<tbody>
							<tr>
						<td>Usuario: </td>
						<td>'. $row['Nombre'] .'</td>
					</tr>
					<tr>
						<td>Password: </td>
						<td>'. $row['Password'] .'</td>
					</tr>
					<tr>
						<td>Rol: </td>
						<td>'. $row['Rol'] .'</td>
					</tr>	
                    <tr>
						<th colspan="2"><img src="'. $dirFoto . $row['Foto'] . '" width="300px"/></th>
					</tr>
					<tr>
						<th colspan="2"><a href="index.php">Regresar</a></th>
						</tr>';

						$html .= '
									</tbody>
								</table>
							</div>
						</div>';
				
							return $html;
		}
	}
	
	/*********************** 3.8 METODO delete_usuario() ***********************/
	// Metodo para Borrar un registro de la DB
	public function delete_usuario($id){
        $sql = "DELETE FROM usuarios WHERE IdUsuario=$id;";
        if ($this->con->query($sql)) {
            echo $this->_message_ok("ELIMINÓ");
        } else {
            echo $this->_message_error("eliminar");
        }
    }

    private function _get_name_file($nombre_original, $tamanio){
		$tmp = explode(".",$nombre_original); //Divido el nombre por el punto y guardo en un arreglo
		$numElm = count($tmp); //cuento el número de elemetos del arreglo
		$ext = $tmp[$numElm-1]; //Extraer la última posición del arreglo.
		$cadena = "";
			for($i=1;$i<=$tamanio;$i++){
				$c = rand(65,122);
				if(($c >= 91) && ($c <=96)){
					$c = NULL;
					 $i--;
				 }else{
					$cadena .= chr($c);
				}
			}
		return $cadena . "." . $ext;
	}

    /*********************** 3.9 METODO _message_error() ***********************/
	// Metodo para el mensaje de Error
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a class="btn btn-success" href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	/*********************** 3.10 METODO _message_ok() ***********************/
	// Metodo para el mensaje de OK
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a class="btn btn-success" href="index.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
}
    

?>