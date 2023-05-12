<?php include("bd.php"); ?>
<?php include("templates/header.php"); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Productos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Color</th>
                            <th>Tamaño</th>
                            <th>Género</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Precio</th>
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
                                    <td style="text-transform: uppercase;"><?php echo $row['name']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['color']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['size']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['gender']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['stock']; ?></td>
                                    <td style="text-transform: uppercase;"><?php echo $row['description']; ?></td>
                                    <td style="text-transform: uppercase;">$ <?php echo $row['purcharse_cost']; ?></td>

                                    <td>
                                        <a class="btn btn-danger" href="">
                                            <i class="bi bi-dash-lg"></i>
                                        </a>

                                        <a class="btn btn-success" href="">
                                            <i class="bi bi-plus-lg"></i>
                                        </a>

                                        <button name="editID" type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?php echo $row['id']; ?>" onclick="window.location.href='edit.php?txtID='+this.getAttribute('data-id')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <a class="btn btn-secondary" href="">
                                            <i class="bi bi-trash3"></i>
                                        </a>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar datos del registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="edit.php" method="POST">
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label><br>
                        <input type="text" name="color" id="color" class="form-control" placeholder="" value="<?php echo $color ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="size" class="form-label">Tamaño</label>
                        <input type="text" id="size" name="size" class="form-control" value="<?php echo $size ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="form-label">Género:</label>
                        <select class="form-control" aria-label="Default select example" name="gender" required>
                            <option selected>Selecciona el género:</option>
                            <option value="D" <?php if ($gender == 'D') echo 'selected'; ?>>Dama</option>
                            <option value="C" <?php if ($gender == 'C') echo 'selected'; ?>>Caballero</option>
                            <option value="SG" <?php if ($gender == 'SG') echo 'selected'; ?>>Unisex</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="form-label">Cantidad</label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="Cantidad de producto" value="<?php echo $stock; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" id="description" name="description" class="form-control" value="<?php echo $description; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="purcharse_cost" class="form-label">Precio</label>
                        <input type="text" id="purcharse_cost" name="purcharse_cost" class="form-control" value="<?php echo $purcharse_cost; ?>" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.edit-container -->
<?php include("templates/footer.php"); ?>