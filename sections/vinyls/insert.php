<?php include("../../bd.php"); ?>
<?php
if (isset($_GET['vinyl_code'])) {
    $vinyl_code = (isset($_GET['vinyl_code'])) ? $_GET['vinyl_code'] : "";
    $query = "SELECT * FROM tbl_vinyl WHERE vinyl_code=:vinyl_code";
    $result = $conexion->prepare($query);
    $result->bindParam(":vinyl_code", $vinyl_code);
    $result->execute();
}

if (isset($_POST['insert'])) {
    // Recolectamos los datos del método POST
    $vinyl_code = (isset($_POST["vinyl_code"]) ? $_POST["vinyl_code"] : "");
    $color = (isset($_POST["color"]) ? $_POST["color"] : "");
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $stock = (isset($_POST["stock"]) ? $_POST["stock"] : "");
    $unit_price = (isset($_POST["unit_price"]) ? $_POST["unit_price"] : "");

    // Prepara la insercción de los datos   
    $query = "INSERT INTO tbl_vinyl(vinyl_code, color, type, stock, unit_price) VALUES (:vinyl_code, :color, :type, :stock, :unit_price)";

    // Asignando los valores que vienen del método POST
    $result = $conexion->prepare($query);
    $result->bindParam(":vinyl_code", $vinyl_code);
    $result->bindParam(":color", $color);
    $result->bindParam(":type", $type);
    $result->bindParam(":stock", $stock);
    $result->bindParam(":unit_price", $unit_price);
    $result->execute();

    $description_log = "Se ha creado el registro para el vinil ・ $vinyl_code";
    if ($color_previous !== $color) {
        $description_log .= "・ $color ";
    }
    if ($size_previous !== $size) {
        $description_log .= "・ $type ";
    }
    if ($gender_previous !== $gender) {
        $description_log .= "・ $stock ";
    }
    if ($unit_price_previous !== $unit_price) {
        $description_log .= "・ $unit_price";
    }

    $logQuery = "INSERT INTO tbl_inventory_log (id, id_user, datetime, event, description, status) VALUES (null, :id_user, :datetime, :event, :description, :status)";
    // Asignando los valores que vienen del método POST
    $id_user = "1";
    date_default_timezone_set('America/Guatemala'); // Establece la zona horaria a la Ciudad de Campeche
    $datetime = date("Y-m-d H:i:s"); // Obtiene la fecha y hora actual en la zona horaria especificada
    $event = "Insertado";
    $status = "Autorizado";
    $result = $conexion->prepare($logQuery);
    $result->bindParam(":id_user", $id_user);
    $result->bindParam(":datetime", $datetime);
    $result->bindParam(":event", $event);
    $result->bindParam(":description", $description_log);
    $result->bindParam(":status", $status);
    $result->execute();

    header('Location: index.php');
}
?>

<?php include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invetario de productos</h1>
    <p class="mb-4">Registro de todos los bienes tangibles y en existentes dentro de la empresa, que pueden utilizarse para su alquiler, uso, transformación, consumo o venta.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Viniles</h6>
            <button name="insert" type="button" class="btn btn-primary" onclick="window.location.href='insert.php'">
                <i class="bi bi-plus-circle-fill"></i> Nuevo
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código de vinil</th>
                            <th>Color</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $conexion->prepare("SELECT * FROM `tbl_vinyl`");
                        $query->execute();
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);

                        if (count($result) > 0) { // verificar si hay resultados
                            foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td style="text-transform: uppercase;"><?php echo $row['vinyl_code']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['color']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['type']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['stock']; ?></td>
                                    <td style="text-transform: uppercase;">$ <?php echo $row['unit_price']; ?></td>
                                    <td>
                                        <button name="decrease" type="button" class="btn btn-danger mx-1" data-id="<?php echo $row['vinyl_code']; ?>" onclick="window.location.href='decrease.php?vinyl_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <button name="increase" type="button" class="btn btn-success mx-1" data-id="<?php echo $row['vinyl_code']; ?>" onclick="window.location.href='increase.php?vinyl_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                        <button name="edit" type="button" class="btn btn-warning mx-1" data-id="<?php echo $row['vinyl_code']; ?>" onclick="window.location.href='edit.php?vinyl_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button name="delete" type="button" class="btn btn-secondary mx-1" data-id="<?php echo $row['vinyl_code']; ?>" onclick="window.location.href='delete.php?vinyl_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="16">No data available :</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- /.insert-container -->
<div class="modal show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ingresar datos del nuevo producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertForm" action="" method="POST">
                    <div class="form-group">
                        <label for="vinyl_code">Codigo del vinil:</label><br>
                        <input type="text" name="vinyl_code" id="vinyl_code" class="form-control" placeholder="Escribe el codigo del vinil" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label><br>
                        <input type="text" name="color" id="color" class="form-control" placeholder="Escribe el color" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="type" class="form-label">Tipo:</label>
                        <input type="text" id="type" name="type" class="form-control" placeholder="Escribe el tamaño" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="form-label">Cantidad:</label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="Cantidad de producto" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_price" class="form-label">Precio:</label>
                        <input type="number" id="unit_price" name="unit_price" class="form-control" placeholder="Escribe el precio" value="" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button name="insert" type="submit" class="btn btn-success">Guardar</button>
                </form>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.insert-container -->

<script>
    // Función para manejar el evento keydown
    function bloquearEnter(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Cancelar la acción predeterminada del Enter
        }
    }

    // Agregar el event listener al documento
    document.addEventListener("keydown", bloquearEnter);
</script>

<script>
    // crear el elemento "backdrop"
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';

    // agregar el elemento "backdrop" al final del <body>
    document.body.appendChild(backdrop);

    document.querySelector('#exampleModalCenter .close').addEventListener('click', function() {
        document.querySelector('#exampleModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.querySelector('#exampleModalCenter .btn-danger').addEventListener('click', function() {
        document.querySelector('#exampleModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });
</script>
<!-- /.edit-container -->
<?php include("../../templates/footer.php"); ?>