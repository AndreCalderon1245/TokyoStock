<?php include("../../bd.php"); ?>
<?php include("../../templates/header.php"); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Invetario de viniles</h1>
    <p class="mb-4">Registro de todos los bienes viniiles tangibles y en existentes dentro de la empresa, que pueden utilizarse su uso, transformación o venta.</p>

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
<script>
    function redirectToInsertPage(button) {
        var vinyl_code = button.getAttribute('data-id');
        window.location.href = 'insert.php?vinyl_code=' + vinyl_code;
    }
</script>

<?php include("../../templates/footer.php"); ?>