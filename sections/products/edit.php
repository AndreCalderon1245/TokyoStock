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
    $description = $row["description"];
    $unit_price = $row["unit_price"];
}

if (isset($_POST['confirm'])) {
    // Recolectamos los datos del método POST
    $product_code = (isset($_GET['product_code'])) ? $_GET['product_code'] : "";
    $name = (isset($_POST["name"]) ? $_POST["name"] : "");
    $color = (isset($_POST["color"]) ? $_POST["color"] : "");
    $size = (isset($_POST["size"]) ? $_POST["size"] : "");
    $gender = (isset($_POST["gender"]) ? $_POST["gender"] : "");
    $description = (isset($_POST["description"]) ? $_POST["description"] : "");
    $unit_price = (isset($_POST["unit_price"]) ? $_POST["unit_price"] : "");

    // Obtener los valores anteriores
    $name_previous = $row["name"];
    $color_previous = $row["color"];
    $size_previous = $row["size"];
    $gender_previous = $row["gender"];
    $description_previous = $row["description"];
    $unit_price_previous = $row["unit_price"];

    // Prepara la insercción de los datos   
    $query = "UPDATE tbl_product SET name=:name, color=:color, size=:size, gender=:gender, description=:description, unit_price=:unit_price WHERE product_code=:product_code";
    // Asignando los valores que vienen del método POST
    $result = $conexion->prepare($query);
    $result->bindParam(":product_code", $product_code);
    $result->bindParam(":name", $name);
    $result->bindParam(":color", $color);
    $result->bindParam(":size", $size);
    $result->bindParam(":gender", $gender);
    $result->bindParam(":description", $description);
    $result->bindParam(":unit_price", $unit_price);
    $result->execute();

    $description_log = "Se ha modificado el registro para el producto con el código de producto $product_code ";
    if ($name_previous !== $name) {
        $description_log .= "de $name_previous a $name ";
    }
    if ($color_previous !== $color) {
        $description_log .= "de $color_previous a $color ";
    }
    if ($size_previous !== $size) {
        $description_log .= "de $size_previous a $size ";
    }
    if ($gender_previous !== $gender) {
        $description_log .= "de $gender_previous a $gender ";
    }
    if ($description_previous !== $description) {
        $description_log .= "de $description_previous a $description ";
    }
    if ($unit_price_previous !== $unit_price) {
        $description_log .= "de $unit_price_previous a $unit_price";
    }

    $logQuery = "INSERT INTO tbl_inventory_log (id, user, datetime, event, description, status) VALUES (null, :user, :datetime, :event, :description, :status)";
    // Asignando los valores que vienen del método POST
    $user = "Heribé";
    date_default_timezone_set('America/Guatemala'); // Establece la zona horaria a la Ciudad de Campeche
    $datetime = date("Y-m-d H:i:s"); // Obtiene la fecha y hora actual en la zona horaria especificada
    $event = "Modificación";
    $status = "Autorizado";
    $result = $conexion->prepare($logQuery);
    $result->bindParam(":user", $user);
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
                                    <td style="text-transform: uppercase;"><?php echo $row['stock']; ?> unidades</td>
                                    <td style="text-transform: uppercase;"><?php echo $row['description']; ?></td>
                                    <td style="text-transform: uppercase;">$ <?php echo $row['unit_price']; ?> MXN</td>
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
<div class="modal show" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar datos del producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="form-group">
                        <label for="product_code" class="form-label">Código del producto:</label>
                        <input type="text" id="product_code" name="product_code" class="form-control" value="<?php echo $product_code ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo $name ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="color">Color:</label><br>
                        <input type="text" name="color" id="color" class="form-control" placeholder="" value="<?php echo $color ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="size" class="form-label">Tamaño:</label>
                        <input type="text" id="size" name="size" class="form-control" value="<?php echo $size ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="form-label">Género:</label>
                        <select class="form-control" aria-label="Default select example" id="gender" name="gender" required>
                            <option selected>Selecciona el género:</option>
                            <option value="Dama" <?php if ($gender == 'Dama') echo 'selected'; ?>>Dama</option>
                            <option value="Caballero" <?php if ($gender == 'Caballero') echo 'selected'; ?>>Caballero</option>
                            <option value="Unisex" <?php if ($gender == 'Unisex') echo 'selected'; ?>>Unisex</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">Descripción:</label>
                        <input type="text" id="description" name="description" class="form-control" value="<?php echo $description; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="unit_price" class="form-label">Precio unitario (MXN):</label>
                        <input type="number" id="unit_price" name="unit_price" class="form-control" value="<?php echo $unit_price; ?>" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="edit" name="edit" type="submit" class="btn btn-success" onclick="obtenerValoresFormulario()" disabled>Guardar</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal" >Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.edit-container -->

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
                    <label for="name" class="form-label">Estás a punto de <strong>MODIFICAR</strong> la información del producto con código "<strong><?php echo $product_code ?></strong>"</label>
                    <ul>
                        <li id="nombreView" style="display: none;"><span id="nombreValor"></span></li>
                        <li id="colorView" style="display: none;"><span id="colorValor"></span></li>
                        <li id="tamanoView" style="display: none;"><span id="tamanoValor"></span></li>
                        <li id="generoView" style="display: none;"><span id="generoValor"></span></li>
                        <li id="descripcionView" style="display: none;"><span id="descripcionValor"></span></li>
                        <li id="precioView" style="display: none;"><span id="precioValor"></span></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button name="confirm" type="submit" class="btn btn-success" formmethod="POST" form="editForm">Guardar</button>
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- /.confirm-container -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener los elementos del formulario y el botón de edición
        var form = document.getElementById('editForm');
        var inputs = form.querySelectorAll('input, select');
        var editButton = document.getElementById('edit');

        // Obtener los valores originales de los campos de entrada
        var originalValues = {};
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            originalValues[input.id] = input.value;
        }

        // Función para comprobar si los valores han cambiado
        function checkFormChanges() {
            var hasChanges = false;
            for (var i = 0; i < inputs.length; i++) {
                var input = inputs[i];
                if (input.value !== originalValues[input.id]) {
                    hasChanges = true;
                    break;
                }
            }
            editButton.disabled = !hasChanges;
        }

        // Escuchar los eventos de cambio en los campos de entrada
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            input.addEventListener('input', checkFormChanges);
        }
    });
</script>

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

<!-- /.inputs-container -->
<script>
    function obtenerValoresFormulario() {
        var formulario = document.getElementById("editForm");
        var inputs = formulario.getElementsByTagName("input");
        var selects = formulario.getElementsByTagName("select");

        var valores = {};

        // Obtener los valores de los inputs
        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];
            valores[input.getAttribute("name")] = input.value;
        }

        // Obtener los valores de los selects
        for (var i = 0; i < selects.length; i++) {
            var select = selects[i];
            valores[select.getAttribute("name")] = select.value;
        }

        // Mostrar los valores en los elementos correspondientes si son diferentes a los valores originales
        if (valores.name !== "<?php echo $name ?>") {
            document.getElementById("nombreValor").textContent = "Nombre: <?php echo $name ?> -> " + valores.name;
            document.getElementById("nombreView").style.display = "";
        }
        if (valores.color !== "<?php echo $color ?>") {
            document.getElementById("colorValor").textContent = "Color: <?php echo $color ?> -> " + valores.color;
            document.getElementById("colorView").style.display = "";
        }
        if (valores.size !== "<?php echo $size ?>") {
            document.getElementById("tamanoValor").textContent = "Tamaño: <?php echo $size ?> -> " + valores.size;
            document.getElementById("tamanoView").style.display = "";
        }
        if (valores.gender !== "<?php echo $gender ?>") {
            document.getElementById("generoValor").textContent = "Género: <?php echo $gender ?> -> " + valores.gender;
            document.getElementById("generoView").style.display = "";
        }
        if (valores.description !== "<?php echo $description ?>") {
            document.getElementById("descripcionValor").textContent = "Descripción: <?php echo $description ?> -> " + valores.description;
            document.getElementById("descripcionView").style.display = "";
        }
        if (valores.unit_price !== "<?php echo $unit_price ?>") {
            document.getElementById("precioValor").textContent = "Precio unitario: <?php echo $unit_price ?> -> " + valores.unit_price;
            document.getElementById("precioView").style.display = "";
        }

        return valores;
    }
</script>
<!-- /.inputs-container -->

<!-- /.modal-container -->
<script>
    // Apartir de aqui empieza el codigo de las funciones de los botones del editModalCenter
    // crear el elemento "backdrop"
    var backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';

    // agregar el elemento "backdrop" al final del <body>
    document.body.appendChild(backdrop);

    document.querySelector('#editModalCenter .close').addEventListener('click', function() {
        document.querySelector('#editModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    document.querySelector('#editModalCenter .btn-danger').addEventListener('click', function() {
        document.querySelector('#editModalCenter').style.display = 'none';

        // eliminar el elemento "backdrop"
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    // Apartir de aqui empieza el codigo de las funciones de los botones del confirmModalCenter
    document.querySelector('#editModalCenter #edit').addEventListener('click', function() {
        document.querySelector('#editModalCenter').style.display = 'none';
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
</script>
<!-- /.modal-container -->
<?php include("../../templates/footer.php"); ?>