<?php
class Rol {
    private $idRol;
    private $nombre;
    private $accion;
    private $con;

    function __construct($cn) {
        $this->con = $cn;
    }

    //*********************** METODO update_rol() **************************************************

    public function update_rol() {
        $this->idRol = $_POST['idRol'];
        $this->nombre = $_POST['nombre'];
        $this->accion = $_POST['accion'];

        $sql = "UPDATE roles SET Nombre='$this->nombre',
                                 Accion='$this->accion'
                                 WHERE IdRol=$this->idRol;";

        if ($this->con->query($sql)) {
            echo $this->_message_ok("modificó");
        } else {
            echo $this->_message_error("al modificar");
        }
    }

    //*********************** METODO save_rol() **************************************************

    public function save_rol() {
        $this->nombre = $_POST['nombre'];
        $this->accion = $_POST['accion'];

        $sql = "INSERT INTO roles VALUES(NULL,
                                        '$this->nombre', 
                                        '$this->accion');";

        if ($this->con->query($sql)) {
            echo $this->_message_ok("guardó");
        } else {
            echo $this->_message_error("guardar");
        }
    }

    //*************************************** PARTE I ************************************************************

    public function get_form($idRol = NULL) {
        if ($idRol == NULL) {
            $this->nombre = NULL;
            $this->accion = NULL;
            $flag = NULL;
            $op = "new";
        } else {
            $sql = "SELECT * FROM roles WHERE IdRol=$idRol;";
            $res = $this->con->query($sql);
            $row = $res->fetch_assoc();

            $num = $res->num_rows;
            if ($num == 0) {
                $mensaje = "tratar de actualizar el rol con idRol= " . $idRol;
                echo $this->_message_error($mensaje);
            } else {
                $this->nombre = $row['Nombre'];
                $this->accion = $row['Accion'];
                $flag = "disabled";
                $op = "update";
            }
        }

        $html = '
        <form name="rol" method="POST" action="index.php" enctype="multipart/form-data">

            <input type="hidden" name="idRol" value="' . $idRol  . '">
            <input type="hidden" name="op" value="' . $op  . '">

            <div class="container">
                    <div class="table-responsive">
						<table class="table table-striped mb-0">
                            
                            <thead style="background-color: #CD5237;">
                                <th style="color:white" colspan="2">DATOS ROL PERSONA</th>
                            </thead>

				<tbody>
				<tr>
                    <td>Nombre:</td>
					<td><input type="text" size="30" name="nombre" value="' . $this->nombre . '" required></td>
                </tr>
                <tr>
                    <td>Acciones:</td>
					<td><input type="text" size="30" name="accion" value="' . $this->accion . '" required></td>
                </tr>
                <tr>
					<th colspan="2"><input type="submit" name="Guardar" value="GUARDAR" class="btn btn-primary col-12 "></th>
					</tbody>
					</table>
					</div>
	</div>';
        return $html;
    }

    public function get_list() {
        $d_new = "new/0";
        $d_new_final = base64_encode($d_new);
        $html = '
        <div class="container">
            <div class="tab" role="tabpanel">
                    <div class="table-responsive">
											<table class="table table-striped mb-0">
			
											<thead style="background-color: #CD5237;">
												<th colspan="8" class="text-center" style="color: white;">LISTA DE ROLES</th>
											</thead>
											<tr>
												<th colspan="8" class="text-center"><a class="btn btn-primary " href="index.php?d=' . $d_new_final . '" class="align-midRoldle">Nuevo</a></th>
											</tr>
											<tr>
                                                <th>IdRol</th>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                            </tr>';
        $sql = "SELECT * FROM roles;";
        $res = $this->con->query($sql);
        while ($row = $res->fetch_assoc()) {
            $d_del = "del/" . $row['IdRol'];
            $d_del_final = base64_encode($d_del);
            $d_act = "act/" . $row['IdRol'];
            $d_act_final = base64_encode($d_act);
            $d_det = "det/" . $row['IdRol'];
			$d_det_final = base64_encode($d_det);	
            $html .= '
            <tr>
                <td>' . $row['IdRol'] . '</td>
                <td>' . $row['Nombre'] . '</td>
                <td>' . $row['Accion'] . '</td>

                <td>
                <td><a class="btn btn-primary " href="index.php?d=' . $d_del_final . '">Borrar</a></td>
					<td><a class="btn btn-primary " href="index.php?d=' . $d_act_final . '">Actualizar</a></td>
					<td><a class="btn btn-primary" href="index.php?d=' . $d_det_final . '">Detalle</a></td>
				</tr>';
        }
        $html .= '
       
		</table>
</div>

</div>';
        return $html;
    }

    public function get_detail_rol($idRol){
        $sql = "SELECT * FROM roles;";
        
        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();
        
        $num = $res->num_rows;
    
        if($num == 0){
            $mensaje = "tratar de editar el consulta con idRol= ".$idRol;
            echo $this->_message_error($mensaje);
        } else { 
            $html = '
            <div class="container">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead style="background-color: #CD5237;">
                        <th colspan="4" class="text-center" style="color:white;">DETALLES DEL ROL</th>
                    </thead>
                    <tbody>
                        <tr>
                                <td>Rol Nombre: </td>
                                <td>'. $row['Nombre'] .'</td>
                            </tr>
                            <tr>
                                <td>Accion: </td>
                                <td>'. $row['Accion'] .'</td>
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
    

    public function delete_rol($idRol)
{
    try {
        $sql = "DELETE FROM roles WHERE IdRol=$idRol;";
        $this->con->query($sql);
        echo $this->_message_ok("ELIMINÓ");
    } catch (mysqli_sql_exception $e) {
        $error_message = $e->getMessage();

        // Verificamos si el mensaje de error contiene la cadena específica
        if (strpos($error_message, 'a foreign key constraint fails') !== false) {
            echo $this->_message_error("No se puede eliminar el rol. Por favor, elimine las referencias en otras tablas primero.");
        } else {
            // Manejo de otros tipos de errores si es necesario
            echo $this->_message_error("Error al eliminar el rol: " . $error_message);
        }
    }
}


    //*****************************************************************************************

    private function _message_error($tipo) {
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

    private function _message_ok($tipo) {
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
}
?>
