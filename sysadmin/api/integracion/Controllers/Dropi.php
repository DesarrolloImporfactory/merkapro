<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Dropi extends Controller
{

	public function index()
	{

		//echo json_encode($this->departamento($token));

		//echo json_encode($this->ciudades($token, 53));

		//echo json_encode($this->categorias($token));

		//$this->model->login();
	}

	public function departamento($token)
	{
		return $this->model->get_department($token);
	}

	public function ciudades($token, $department_id)
	{
		return $this->model->get_bycity($token, $department_id);
	}

	public function categorias($token)
	{
		return $this->model->get_categories($token);
	}

	public function productos($token, $keywords)
	{
		return $this->model->get_products($token, $keywords);
	}

	public function autentificacion($usuario, $contrasena)
	{
		$existe = $this->model->existe_usuario($usuario);

		if ($existe == 1) {
			//echo 'existe en la base de datos';
			if ($this->model->expiro_token($usuario)) {
				$token = $this->model->actualizar_token($usuario, $contrasena);
				return $token;
			} else {
				$token = $this->model->get_token($usuario);
				return $token;
			}
		} else {
			//echo 'no existe en la base de datos';
			$token = $this->model->guardar_usuario($usuario, $contrasena);
			if (empty($token)) {
				return false;
			}
			return $token;
		}
	}
	public function login()
	{
		$usuario = $_POST["correo"];
		$contrasena = $_POST["contrasena"];

		if ($usuario && $contrasena) {
			$token = $this->autentificacion($usuario, $contrasena);

			if (empty($token)) {
				$response = array('status' => false, 'msg' => 'Las credenciales ingresadas son incorrectas');
			} else {
				$response = array('status' => true, 'msg' => 'su cuenta ha sido registrada correctamente en nuetro sistema', 'data' => $token);
			}
		}
		echo json_encode($response);
	}

	public function enviar_datos()
	{
		$usuario = $_POST['correo'];
		$contrasena = $_POST['contrasena'];

		$credenciales = "<?php\n";
		$credenciales .= "include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado\n";
		$credenciales .= "define('DB_USER', '".$usuario."');\n";
		$credenciales .= "define('DB_PASS', '".$contrasena."');\n";
		$credenciales .= "\$credenciales= array('usuario' => DB_USER, 'contrasena' => DB_PASS);\n";
		$credenciales .= "echo json_encode(\$credenciales);";

		$destino_url = "../../../sysadmin/vistas/ajax/texto_plano.php";
		file_put_contents($destino_url, $credenciales);
	}
}
