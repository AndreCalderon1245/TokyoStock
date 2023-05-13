<?php include("../../bd.php"); ?>
<?php
if (isset($_GET['product_code'])) {
    $product_code = (isset($_GET['product_code'])) ? $_GET['product_code'] : "";
    $query = "SELECT * FROM tbl_product WHERE product_code=:product_code";
    $result = $conexion->prepare($query);
    $result->bindParam(":product_code", $product_code);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_LAZY);
    $name = $row["name"];
    $color = $row["color"];
    $size = $row["size"];
    $gender = $row["gender"];
    $stock = $row["stock"];
    $description = $row["description"];
    $purcharse_cost = $row["purcharse_cost"];
}

if (isset($_POST['edit'])) {
    // Recolectamos los datos del método POST
    $product_code = (isset($_GET['product_code'])) ? $_GET['product_code'] : "";
    $name = (isset($_POST["name"]) ? $_POST["name"] : "");
    $color = (isset($_POST["color"]) ? $_POST["color"] : "");
    $size = (isset($_POST["size"]) ? $_POST["size"] : "");
    $gender = (isset($_POST["gender"]) ? $_POST["gender"] : "");
    $stock = (isset($_POST["stock"]) ? $_POST["stock"] : "");
    $description = (isset($_POST["description"]) ? $_POST["description"] : "");
    $purcharse_cost = (isset($_POST["purcharse_cost"]) ? $_POST["purcharse_cost"] : "");

    // Prepara la insercción de los datos   
    $query = "UPDATE tbl_product SET name=:name, color=:color, size=:size, gender=:gender, stock=:stock, description=:description, purcharse_cost=:purcharse_cost WHERE product_code=:product_code";

    // Asignando los valores que vienen del método POST
    $result = $conexion->prepare($query);
    $result->bindParam(":product_code", $product_code);
    $result->bindParam(":name", $name);
    $result->bindParam(":color", $color);
    $result->bindParam(":size", $size);
    $result->bindParam(":gender", $gender);
    $result->bindParam(":stock", $stock);
    $result->bindParam(":description", $description);
    $result->bindParam(":purcharse_cost", $purcharse_cost);
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
                                    <td style="text-transform: uppercase;">$ <?php echo $row['purcharse_cost']; ?></td>

                                    <td>
                                        <button name="decrease" type="button" class="btn btn-danger" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='decrease.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-dash-lg"></i>
                                        </button>

                                        <button name="increase" type="button" class="btn btn-success" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='increase.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>

                                        <button name="edit" type="button" class="btn btn-warning" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='edit.php?product_code='+this.getAttribute('data-id')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button name="delete" type="button" class="btn btn-secondary" data-id="<?php echo $row['product_code']; ?>" onclick="window.location.href='delete.php?product_code='+this.getAttribute('data-id')">
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
<div class="modal show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Entradas de producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php if (isset($row)) : ?>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label">Código del producto:</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $product_code ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="stock" class="form-label">Cantidad</label>
                            <div class="input-group">
                                <button name="decrease" type="button" class="btn btn-danger">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" id="stock" name="stock" class="form-control" placeholder="Cantidad de producto" value="<?php echo $stock; ?>" required>
                                <button name="increase" type="button" class="btn btn-success">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                </div>
            <?php endif; ?>
            <div class="modal-footer">
                <button name="edit" type="submit" class="btn btn-success">Guardar</button>
                </form>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.edit-container -->

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