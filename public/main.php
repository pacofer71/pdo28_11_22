<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";

use Src\Users;

(new Users)->crearUsuarios(100);
$usuarios = (new Users)->read();

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
    <h5 class="text-center mt-3">Listado de Usuarios</h5>
    <div class="container mt-4">
        <table class="table table-striped" id="users">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Perfil</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usuarios as $item) {
                    $perfil = ($item['perfil'] == "Admin") ? "<p class='btn btn-info' style='width:6em; height:2em'>Admin</p>" :  "<p class='btn btn-success' style='width:6em;height:2em'>Normal</p>";
                    echo <<<TXT
                         <tr>
                         <th scope="row">{$item['id']}</th>
                         <td>{$item['nombre']} {$item['apellidos']}</td>
                         <td class="text-primary">{$item['email']}</td>
                         <td>$perfil</td>
                         <td>
                         <form class='form-inline' action='borrar.php' method='POST' />
                         <input type='hidden' name='id' value='{$item['id']}' />
                         <a href='update.php?id={$item['id']}' class='btn btn-info btn-sm'><i class="fas fa-edit"></i></a>
                         <button type="submit" class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></button>
                         </form>
                         </td>
                         </tr>
                        TXT;
                }
                ?>

            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#users').DataTable();
        });
        
    </script>
    <?php
        if(isset($_SESSION['txt'])){
            echo <<<TXT
            <script>
            Swal.fire({
                icon: 'success',
                title: '{$_SESSION['txt']}',
                showConfirmButton: false,
                timer: 1500
              })
              </script>
            TXT;
            unset($_SESSION['txt']);
        }
     ?>

</body>

</html>