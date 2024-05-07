<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();
        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        } elseif (isset($_POST["recovery"])) {
            $this->passwordRecovery();
        } elseif (isset($_POST["change"])) {
            $this->changePassword();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['usuario_users'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['con_users'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['usuario_users']) && !empty($_POST['con_users'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $usuario_users = $this->db_connection->real_escape_string($_POST['usuario_users']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT id_users, usuario_users, email_users, con_users
                        FROM users
                        WHERE  usuario_users = '" . $usuario_users . "' OR email_users = '" . $usuario_users . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['con_users'], $result_row->con_users)) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['id_users']          = $result_row->id_users;
                        $_SESSION['usuario_users']     = $result_row->usuario_users;
                        $_SESSION['email_users']       = $result_row->email_users;
                        $_SESSION['user_login_status'] = 1;
                    } else {
                        $this->errors[] = "Usuario y/o contraseña no coinciden.";
                    }
                } else {
                    $this->errors[] = "Usuario y/o contraseña no coinciden.";
                }
            } else {
                $this->errors[] = "Problema de conexión de base de datos.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "Has sido desconectado.";
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }

    public function passwordRecovery()
    {
        if (empty($_POST['email_users'])) {
            $this->errors[] = "El campo de correo electrónico estaba vacío.";
        } elseif (!empty($_POST['email_users'])) {
            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escape the POST stuff
                $email_users = $this->db_connection->real_escape_string($_POST['email_users']);
                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT email_users
                        FROM users
                        WHERE  email_users = '" . $email_users . "';";
                $result_of_recover_mail_check = $this->db_connection->query($sql);
                // if this user exists
                if (!$result_of_recover_mail_check->num_rows == 1) {
                    $this->errors[] = "El correo electrónico no existe.";
                } else {
                    $token = bin2hex(random_bytes(64));
                    date_default_timezone_set('America/Bogota');
                    $date_now = date("Y-m-d H:i:s");

                    $sql = "UPDATE users SET token_act = '" . $token . "', estado_token = 1, fecha_actualizacion = '" . $date_now . "'  WHERE email_users = '" . $email_users . "';";
                    $result_of_recover_mail_check = $this->db_connection->query($sql);



                    // send a mail to the user
                    require_once('PHPMailer/PHPMailer.php');
                    require_once('PHPMailer/SMTP.php');
                    require_once('PHPMailer/Exception.php');

                    if (
                        isset($_SERVER['HTTPS']) &&
                        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
                    ) {
                        $protocol = 'https://';
                    } else {
                        $protocol = 'http://';
                    }

                    $url_change = $protocol . $_SERVER['HTTP_HOST'] . '/sysadmin/change_password.php?token=' . $token;
                    include 'PHPMailer/Mail.php';


                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->SMTPDebug = $smtp_debug;
                    $mail->Host = $smtp_host;
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_user;
                    $mail->Password = $smtp_pass;
                    $mail->Port = 465;
                    $mail->SMTPSecure = $smtp_secure;

                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->setFrom($smtp_from, $smtp_from_name);
                    $mail->addAddress($email_users);
                    $mail->Subject = 'Recuperación de contraseña';
                    $mail->Body = $message_body;


                    if (!$mail->send()) {
                        $this->errors[] = $mail->ErrorInfo;
                    } else {
                        $this->messages[] = "Se ha enviado un correo electrónico a su dirección de correo electrónico.";
                    }
                }
            }
        }
    }

    public function changePassword()
    {
        if (empty($_POST['password'])) {
            $this->errors[] = "El campo de contraseña estaba vacío.";
        } elseif (empty($_POST['password_repeat'])) {
            $this->errors[] = "El campo de repetir contraseña estaba vacío.";
        } elseif ($_POST['password'] != $_POST['password_repeat']) {
            $this->errors[] = "Las contraseñas no coinciden.";
        } elseif (empty($_POST['token'])) {
            $this->errors[] = "El token no existe.";
        } elseif (!empty($_POST['password']) && !empty($_POST['password_repeat']) && !empty($_POST['token'])) {
            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escape the POST stuff
                $password = $this->db_connection->real_escape_string($_POST['password']);
                $token = $this->db_connection->real_escape_string($_POST['token']);
                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                print_r($token);
                $sql = "SELECT token_act
                        FROM users
                        WHERE  token_act = '" . $token . "';";
                $result_of_recover_token_check = $this->db_connection->query($sql);
                // if this user exists
                if (!$result_of_recover_token_check->num_rows == 1) {
                    $this->errors[] = $token;
                } else {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET con_users = '" . $password_hash . "', estado_token = 0 WHERE token_act = '" . $token . "';";
                    $result_of_recover_token_check = $this->db_connection->query($sql);
                    // se redirige a la página de inicio de sesión
                    $this->messages[] = "La contraseña se ha cambiado correctamente.";
                    header("location: login.php?change=success");
                }
            }
        }
    }

    public function verifyTokenStatus()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // change character set to utf8 and check it
        if (!$this->db_connection->set_charset("utf8")) {
            $this->errors[] = $this->db_connection->error;
        }
        // if no connection errors (= working database connection)
        if (!$this->db_connection->connect_errno) {
            // escape the POST stuff
            $token = $this->db_connection->real_escape_string($_GET['token']);
            // database query, getting all the info of the selected user (allows login via email address in the
            // username field)
            $sql = "SELECT estado_token
                    FROM users
                    WHERE  token_act = '" . $token . "';";
            $result_of_recover_token_check = $this->db_connection->query($sql);
            // if this user exists
            if (!$result_of_recover_token_check->num_rows == 1) {
                $this->errors[] = $token;
            } else {
                $result_row = $result_of_recover_token_check->fetch_object();
                if ($result_row->estado_token == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}
