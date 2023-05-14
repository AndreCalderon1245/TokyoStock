<?php include("../../bd.php"); ?>
<?php
if (isset($_GET['product_code'])) {
    $product_code = (isset($_GET['product_code'])) ? $_GET['product_code'] : "";
    $query = "SELECT * FROM tbl_product WHERE product_code=:product_code";
    $result = $conexion->prepare($query);
    $result->bindParam(":product_code", $product_code);
    $result->execute();
}

if (isset($_POST['confirm'])) {
    // Recolectamos los datos del método POST
    $product_code = (isset($_GET['product_code'])) ? $_GET['product_code'] : "";
    $stock = (isset($_POST["stock"]) ? $_POST["stock"] : "");

    // Prepara la actualización de los datos   
    $query = "UPDATE tbl_product SET stock=stock + :stock WHERE product_code=:product_code";

    // Asignando los valores que vienen del método POST
    $result = $conexion->prepare($query);
    $result->bindParam(":product_code", $product_code);
    $result->bindParam(":stock", $stock);
    $result->execute();

    header('Location: index.php');
}
?>

<?php include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
            <button name="insert" type="button" class="btn btn-primary" onclick="window.location.href='insert.php'">
                <i class="bi bi-plus-circle-fill"></i> Nuevo
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código de producto</th>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Tamaño</th>
                            <th>Género</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Precio unitario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $conexion->prepare("SELECT * FROM `tbl_product`");
                        $query->execute();
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);

                        if (count($result) > 0) { // verificar si hay resultados
                            foreach ($result as $row) {
                        ?>
                                <tr>
                                    <td style="text-transform: uppercase;"><?php echo $row['product_code']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['name']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['color']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['size']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['gender']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['stock']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['description']; ?></td>
                                    <td style="text-transform: uppercase;">$ <?php echo $row['unit_price']; ?></td>
                                    <td class="d-inline-flex">
                                        <button name="decrease" type="button" class="btn btn-danger mx-1" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='decrease.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>
                                        <button name="increase" type="button" class="btn btn-success mx-1" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='increase.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                        <button name="edit" type="button" class="btn btn-warning mx-1" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='edit.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button name="delete" type="button" class="btn btn-secondary mx-1" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='delete.php?product_code='+this.getAttribute('data-id')">
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

<!-- /.edit-container -->
<div class="modal show" id="increaseModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: block;">
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
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $product_code ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="stock" class="form-label">Cantidad</label>
                            <div class="input-group">
                                <button name="decrease" type="button" class="btn btn-danger" id="decrease-btn">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" id="stock" name="stock" class="form-control text-center" placeholder="Cantidad de producto" value="0" required>
                                <button name="increase" type="button" class="btn btn-success" id="increase-btn">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="modal-footer">
                <button id="increase" name="increase" type="submit" class="btn btn-success">Guardar</button>
                <button id="close" name="close" type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.increase-container -->

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
                        <label for="name" class="form-label">Estás a punto de <strong>AUMENTAR</strong> la cantidad del producto con código "<strong><?php echo $product_code ?></strong>"</label>
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
    // Apartir de aqui empieza el codigo de las funciones de los botones del editModalCenter
    // crear el elemento "backdrop"
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';

    // agregar el elemento "backdrop" al final del <body>
    document.body.appendChild(backdrop);

    document.querySelector('#increaseModalCenter .close').addEventListener('click', function() {
        document.querySelector('#increaseModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.querySelector('#increaseModalCenter #close').addEventListener('click', function() {
        document.querySelector('#increaseModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    // Apartir de aqui empieza el codigo de las funciones de los botones del confirmModalCenter
    document.querySelector('#increaseModalCenter #increase').addEventListener('click', function() {
        document.querySelector('#increaseModalCenter').style.display = 'none';
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