<?php

class DropiModel extends Query
{

    public function existe_usuario($usuario)
    {
        $existe = $this->select("SELECT usuario FROM dropi WHERE usuario = '$usuario'");
        if (!empty($existe)) {
            $guia = $existe[0];

            if ($guia == '') {
                return false;
                exit;
            } else {
                return true;
            }
        }
    }

    public function expiro_token($usuario)
    {
        $ultima_fecha = $this->select("SELECT update_at FROM dropi WHERE usuario = '$usuario'");

        date_default_timezone_set('America/Guayaquil');
        $fecha_actual = date('Y-m-d H:i:s');
        $nueva_fecha = strtotime('+0 hour', strtotime($fecha_actual));
        $nueva_fecha = strtotime('+30 minute', $nueva_fecha);
        $nueva_fecha = date('Y-m-d H:i:s', $nueva_fecha);

        if ($ultima_fecha > $nueva_fecha) {
            return true;
        } else {
            return false;
        }
    }

    public function get_token($usuario)
    {
        $get_token = $this->select("SELECT token FROM dropi WHERE usuario = '$usuario'");
        return $get_token;
    }

    public function actualizar_token($usuario, $contrasena)
    {
        $datos_login = array('email' => $usuario, 'password' => $contrasena, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de');
        $response1 = $this->central('login', 'POST', $datos_login);

        if ($response1['isSuccess'] == false) {
            return false;
        }
        $token = $response1['token'];

        $sql_cc = "UPDATE `dropi` SET token = ?, update_at = ?";
        date_default_timezone_set('America/Guayaquil');
        $datos = array($token, date('Y-m-d H:i:s'));
        $query_insertar_cc = $this->insert($sql_cc, $datos);

        if ($query_insertar_cc) {
            //echo json_encode('ok');
            return $token;
        } else {
            echo json_encode('error');
        }
    }

    public function guardar_usuario($usuario, $contrasena)
    {
        $datos_login = array('email' => $usuario, 'password' => $contrasena, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de');
        $response1 = $this->central('login', 'POST', $datos_login);

        if (empty($response1['isSuccess'])) {
            return false;
        }

        $token = $response1['token'];

        $password_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql_cc = "INSERT INTO `dropi`(`usuario`, `contrasena_hash`, `token`) VALUES (?, ?, ?)";
        $datos = array($usuario, $password_hash, $token);
        $query_insertar_cc = $this->insert($sql_cc, $datos);

        if ($query_insertar_cc) {
            //echo json_encode('ok');
            return $token;
        } else {
            echo json_encode('error');
        }
    }

    public function get_department($token)
    {
        $datos_login = array('token' => $token, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de');
        $response = $this->central('department', 'GET', $datos_login);
        return $response;
    }

    public function get_bycity($token, $departmen_id)
    {
        $datos_login = array('token' => $token, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de', 'department_id' => $departmen_id, 'rate_type' => '');
        $response = $this->central('trajectory/bycity', 'POST', $datos_login);
        return $response;
    }

    public function get_categories($token)
    {
        $datos_login = array('token' => $token, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de');
        $response = $this->central('categories', 'GET', $datos_login);
        return $response;
    }

    public function get_products($token, $keywords= null, $pageSize= null, $startData= null, $userVerified= null)
    {
        $adicional= "";
        if(isset($keywords)){
            $adicional .= "'keywords: ". $keywords. "', ";
        }
        if(isset($pageSize)){
            $adicional .= "'pageSize: ". $pageSize. "', ";
        }
        if(isset($startData)){
            $adicional .= "'startData: ". $startData. "', ";
        }
        if(isset($userVerified)){
            $adicional .= "'userVerified: ". $userVerified. "' ";
        }
        $datos_login = array('token' => $token, 'white_brand_id' => 'df3e6b0bb66ceaadca4f84cbc371fd66e04d20fe51fc414da8d1b84d31d178de');
        $response = $this->central('products/index', 'POST', $datos_login, $adicional);
        return $response;
    }


    public function central($endpoint, $tipo, $datos, $adicional = null)
    {
        $destino_url = "https://api.dropi.ec/api/" . $endpoint;
        // Configuración de la solicitud cURL para el servicio de destino
        $ch = curl_init($destino_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $tipo);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (isset($datos['token'])) {
            if (isset($adicional)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $datos['token'],
                    $adicional
                ));
            } else {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $datos['token']
                ));
            }
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
        }


        // Realizar la solicitud cURL al servicio de destino

        $response = curl_exec($ch);


        // Verificar si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'Error en la solicitud cURL para el servicio de destino: ' . curl_error($ch);
            exit();
        }
        curl_close($ch);
        return $response1 = json_decode($response, true);
    }
}
