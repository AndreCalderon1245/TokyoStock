<?php include("../../bd.php"); ?>
<?php
if (isset($_GET['vinyl_code'])) {
    $vinyl_code = (isset($_GET['vinyl_code'])) ? $_GET['vinyl_code'] : "";
    $query = "SELECT * FROM tbl_vinyl WHERE vinyl_code=:vinyl_code";
    $result = $conexion->prepare($query);
    $result->bindParam(":vinyl_code", $vinyl_code);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_LAZY);
    $stock = $row["stock"];
}

if (isset($_POST['confirm'])) {
    // Recolectamos los datos del método POST
    $vinyl_code = (isset($_GET['vinyl_code'])) ? $_GET['vinyl_code'] : "";
    $stock = (isset($_POST["stock"]) ? $_POST["stock"] : "");

    $stock_previous = $row["stock"];
    $stock_final = $stock_previous - $stock;

    // Prepara la actualización de los datos   
    $query = "UPDATE tbl_vinyl SET stock=:stock WHERE vinyl_code=:vinyl_code";

    // Asignando los valores que vienen del método POST
    $result = $conexion->prepare($query);
    $result->bindParam(":vinyl_code", $vinyl_code);
    $result->bindParam(":stock", $stock_final);
    $result->execute();

    $logQuery = "INSERT INTO tbl_inventory_log (id, id_user, datetime, event, description, status) VALUES (null, :id_user, :datetime, :event, :description, :status)";
    // Asignando los valores que vienen del método POST
    $id_user = "1";
    date_default_timezone_set('America/Guatemala'); // Establece la zona horaria a la Ciudad de Campeche
    $datetime = date("Y-m-d H:i:s"); // Obtiene la fecha y hora actual en la zona horaria especificada
    $event = "Disminución";
    $description = "Se disminuyo el stock del vinil con el código de producto $vinyl_code de $stock_previous -> $stock_final";
    $status = "Autorizado";
    $result = $conexion->prepare($logQuery);
    $result->bindParam(":id_user", $id_user);
    $result->bindParam(":datetime", $datetime);
    $result->bindParam(":event", $event);
    $result->bindParam(":description", $description);
    $result->bindParam(":status", $status);
    $result->execute();

    header('Location: index.php');
}
?>

<?php include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invetario de viniles</h1>
    <p class="mb-4">Registro de todos los bienes viniiles tangibles y en existentes dentro de la empresa, que pueden utilizarse su uso, transformación o venta.</p>

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
                            <th>Precio (m²):</th>
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
                                    <td><?php echo $row['stock']; ?> cm²</td>
                                    <td style="text-transform: uppercase;">$ <?php echo $row['unit_price']; ?> MXN</td>
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

<!-- /.decrease-container -->
<div class="modal show" id="decreaseModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Entradas de producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="increaseForm">
                    <div class="form-group">
                        <label for="name" class="form-label">Código del producto:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $vinyl_code ?>" readonly>
                        <input type="text" id="stock_start" name="stock_start" class="form-control" value="<?php echo $stock ?>" hidden>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="form-label">Cantidad</label>
                        <div class="input-group">
                            <button name="decrease" type="button" class="btn btn-danger" id="decrease-btn">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                            <input type="number" id="stock" name="stock" class="form-control text-center" placeholder="Cantidad de producto" value="0" required>
                            <button name="decrease" type="button" class="btn btn-success" id="increase-btn">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="decrease" name="decrease" type="submit" class="btn btn-success" onclick="mostrarValores()">Guardar</button>
                <button id="close" name="close" type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.decrease-container -->

<!-- /.confirm-container -->
<div class="modal show" id="confirmModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">¿Estás seguro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="form-label">Estás a punto de <strong>DISMINUIR</strong> la cantidad del vinil con el código "<strong><?php echo $vinyl_code ?></strong>"</label>
                    <ul>
                        <li id="nombreView"><span id="stockInicial"></span></li>
                        <li id="nombreView"><span id="stockFinal"></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button name="confirm" type="submit" class="btn btn-success" formmethod="POST" form="increaseForm">Guardar</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.confirm-container -->

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
    function mostrarValores() {
        var stockStartInput = document.getElementById('stock_start');
        var stockInput = document.getElementById('stock');
        var stockInicial = document.getElementById('stockInicial');
        var stockFinal = document.getElementById('stockFinal');

        var stockStartValue = parseInt(stockStartInput.value, 10);
        var stockValue = parseInt(stockInput.value, 10);

        var suma = stockStartValue - stockValue;

        stockInicial.textContent = 'Stock Inicial: ' + stockStartValue;
        stockFinal.textContent = 'Stock Final: ' + suma;
    }
</script>

<script>
    // Apartir de aqui empieza el codigo de las funciones de los botones del editModalCenter
    // crear el elemento "backdrop"
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';

    // agregar el elemento "backdrop" al final del <body>
    document.body.appendChild(backdrop);

    document.querySelector('#decreaseModalCenter .close').addEventListener('click', function() {
        document.querySelector('#decreaseModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.querySelector('#decreaseModalCenter #close').addEventListener('click', function() {
        document.querySelector('#decreaseModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    // Apartir de aqui empieza el codigo de las funciones de los botones del confirmModalCenter
    document.querySelector('#decreaseModalCenter #decrease').addEventListener('click', function() {
        document.querySelector('#decreaseModalCenter').style.display = 'none';
        document.querySelector('#confirmModalCenter').style.display = 'block';
    });

    document.querySelector('#confirmModalCenter .close').addEventListener('click', function() {
        document.querySelector('#confirmModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.querySelector('#confirmModalCenter .btn-danger').addEventListener('click', function() {
        document.querySelector('#confirmModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    // crear el elementos de los botones
    const decreaseBtn = document.getElementById("decrease-btn");
    const increaseBtn = document.getElementById("increase-btn");
    const stockInput = document.getElementById("stock");

    decreaseBtn.addEventListener("click", () => {
        if (parseInt(stockInput.value) > 0) {
            stockInput.value = parseInt(stockInput.value) - 1;
        }
    });

    increaseBtn.addEventListener("click", () => {
        stockInput.value = parseInt(stockInput.value) + 1;
    });
</script>

<?php include("../../templates/footer.php"); ?>