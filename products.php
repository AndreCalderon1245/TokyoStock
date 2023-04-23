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
                                            <th>Name</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Category</th>
                                            <th>Gender</th>
                                            <th>Stock</th>
                                            <th>Details</th>
                                            <th>Purcharse_Cost</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        $conexion = mysqli_connect("localhost:3307", "root", "", "tokyostock");
                                        $SQL = "SELECT name, color, size, id_category, gender, stock, details, purcharse_cost FROM tbl_product order by name";
                                        $dato = mysqli_query($conexion, $SQL);

                                        if ($dato->num_rows > 0) {
                                            while ($fila = mysqli_fetch_array($dato)) {

                                        ?>
                                                <tr>

                                                    <td style="text-transform: uppercase;"><?php echo $fila['name']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['color']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['size']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['id_category']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['gender']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['stock']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['details']; ?></td>
                                                    <td style="text-transform: uppercase;">$ <?php echo $fila['purcharse_cost']; ?></td>

                                                    <td>
                                                        <a class="btn btn-danger" href="">
                                                            <i class="bi bi-dash-lg"></i>
                                                        </a>

                                                        <a class="btn btn-success" href="">
                                                            <i class="bi bi-plus-lg"></i>
                                                        </a>

                                                        <a class="btn btn-warning" href="" method="post">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>

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
<?php include("templates/footer.php"); ?>