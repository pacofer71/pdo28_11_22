<?php
require __DIR__ . "/../vendor/autoload.php";
if (!isset($_GET['id'])) {
    header("Location:main.php");
    die();
}
$id = $_GET['id'];


use Src\Users;

$datos = (new Users)->existeId($id);
if (!$datos) {
    header("Location:main.php");
    die();
}

session_start();
$error = false;

function comprobarCampo(string $c, string $n, int $tam): void
{
    global $error;
    if (strlen($c) < $tam) {
        $_SESSION['err' . $n] = "*** El campo $n debe tener más de $tam caracteres";
        $error = true;
    }
}

function mostrarError($nombre)
{
    if (isset($_SESSION[$nombre])) {
        echo <<<TXT
            <p class="text-danger" style="font-size:small;font-weight:bold;">{$_SESSION[$nombre]}</p>
TXT;

        unset($_SESSION[$nombre]);
    }
}

if (isset($_POST['btnEnviar'])) {
    $nombre = trim(ucwords($_POST['nombre']));
    $apellidos = trim(ucwords($_POST['apellidos']));
    $email = trim($_POST['email']);
    $perfil = (isset($_POST['perfil'])) ? $_POST['perfil'] : "";
    comprobarCampo($nombre, "Nombre", 4);
    comprobarCampo($apellidos, "Apellidos", 8);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $_SESSION['errEmail'] = "El email NO tiene un formato válido";
    }
    if ($error) {
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
        die();
    }
    (new Users())->setNombre($nombre)
        ->setApellidos($apellidos)
        ->setEmail($email)
        ->setPerfil($perfil)
        ->update($id);
    $_SESSION['txt'] = "Registro Actualizado con éxito.";
    header("Location:main.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <!-- jquery para datatables -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <!-- Sweetalert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Usuarios</title>
    </head>

    <body style="background-color:#aaffcc">
        <h5 class="text-center mt-3">Editar Usuario</h5>
        <div class="container mt-4">
            <form name="a" action="<?php echo $_SERVER['PHP_SELF'] . "?id=$id"; ?>" method="POST">
                <div class="mb-3 mx-auto bg-secondary border rounded-lg shadow-lg py-4 px-4 text-light" style="width:42rem">
                    <label for="n1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="n1" placeholder="Nombre" name="nombre" value="<?php echo $datos->nombre ?>">
                    <?php
                    mostrarError('errNombre');
                    ?>
                    <label for="ap" class="form-label mt-2">Apellidos</label>
                    <input type="text" class="form-control" id="ap" placeholder="Apellidos" name="apellidos" value="<?php echo $datos->apellidos ?>">
                    <?php
                    mostrarError('errApellidos');
                    ?>
                    <label for="em" class="form-label mt-2">Email address</label>
                    <input type="email" class="form-control" id="em" placeholder="Email" name="email" value="<?php echo $datos->email ?>">
                    <?php
                    mostrarError('errEmail');
                    ?>
                    <label for="pf" class="form-label mt-2">Perfil</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="perfil" id="f1" value="Normal" <?php echo ($datos->perfil == 'Admin') ? "" : "checked" ?>>
                        <label class="form-check-label mr-4" for="f1">
                            Normal
                        </label>
                        <input class="form-check-input" type="radio" name="perfil" id="f2" value="Admin" <?php echo ($datos->perfil == 'Normal') ? "" : "checked" ?>>
                        <label class="form-check-label" for="f2">
                            Administrador
                        </label>

                    </div>
                    <div class="d-flex my-2 flex-row-reverse">
                        <button type="submit" class="btn btn-success ml-4" name="btnEnviar"><i class="fas fa-edit"></i>
                            Editar
                        </button>
                        <a href="main.php" class="btn btn-info"><i class="fas fa-backward"></i> Volver</a>
                    </div>
                </div>

            </form>
        </div>
    </body>

    </html>
<?php } ?>