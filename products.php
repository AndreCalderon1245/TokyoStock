<?php include("templates/header.php"); ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Productos</h1>
                    <p class="mb-4">En esta sección, se incluyen los detalles importantes sobre cada producto, como su nombre, descripción, género, precio de compra, color, tamaño y cantidad en stock.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary" style="text-transform: uppercase;">Tabla de Productos</h6>
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
                                            <th>Precio</th>
                                            <th>Cantidad en Stock</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $conexion = mysqli_connect("localhost:3307", "root", "", "tokyostock");
                                        $SQL = "SELECT name, color, size, gender, stock, details, ROUND(purcharse_cost, 2) as purcharse_cost FROM tbl_product ORDER BY name";
                                        $dato = mysqli_query($conexion, $SQL);
                                        if ($dato->num_rows > 0) {
                                            while ($fila = mysqli_fetch_array($dato)) {
                                        ?>
                                                <tr>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['name']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['color']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['size']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['gender']; ?></td>
                                                    <td style="text-transform: uppercase;">$ <?php echo $fila['purcharse_cost']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['stock']; ?></td>
                                                    <td style="text-transform: uppercase;"><?php echo $fila['details']; ?></td>
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