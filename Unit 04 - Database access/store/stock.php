<?php
// Conexión
$dwes = mysqli_connect('localhost', 'dwes', 'dwes', 'tienda');
if (!$dwes) {
    die('Error de conexión: ' . mysqli_connect_error());
}

// Recuperar y validar 'cod' o 'producto' (evita notices)
$cod_producto = filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$cod_producto) {
    $cod_producto = filter_input(INPUT_GET, 'producto', FILTER_SANITIZE_SPECIAL_CHARS);
}

if (!$cod_producto) {
    echo "<p>Error: problema con el código del producto.";
    mysqli_close($dwes);
    exit;
}

// Obtener nombre corto del producto (prepared statement)
$stmt = $dwes->prepare("SELECT nombre_corto FROM producto WHERE cod = ?");
if (!$stmt) {
    echo "<p>Error en la consulta: " . htmlspecialchars($dwes->error) . "</p>";
    mysqli_close($dwes);
    exit;
}

$stmt->bind_param("s", $cod_producto);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();
$stmt->close();

if (!$producto) {
    echo "<p>Producto con código <strong>" . htmlspecialchars($cod_producto) . "</strong> no encontrado.</p>";
    echo "<p><a href='index.php'>Volver a la lista de productos</a></p>";
    mysqli_close($dwes);
    exit;
}

echo "<h1>Stock del producto: " . htmlspecialchars($producto['nombre_corto']) . "</h1>";

// Procesar envío del formulario
if (isset($_POST['actualizar'])) {
    // Validar y sanear valores
    $unidades_central = isset($_POST['unidades_1']) ? intval($_POST['unidades_1']) : 0;
    $unidades_sucursal = isset($_POST['unidades_2']) ? intval($_POST['unidades_2']) : 0;
    
    if ($unidades_central < 0 || $unidades_sucursal < 0) {
        echo "<p style='color:red;'>Error: las unidades no pueden ser negativas.</p>";
    } else {
        // Iniciar transacción
        $dwes->begin_transaction();
        
        try {
            // Prepared statement para UPDATE
            $stmt_upd = $dwes->prepare("UPDATE stock SET unidades = ? WHERE producto = ? AND tienda = ?");
            
            if (!$stmt_upd) {
                throw new Exception("Error preparando la consulta: " . $dwes->error);
            }
            
            // Array con los datos a actualizar
            $tiendas_data = [
                ['tienda' => 1, 'unidades' => $unidades_central],
                ['tienda' => 2, 'unidades' => $unidades_sucursal]
            ];
            
            // Ejecutar UPDATE para cada tienda
            foreach ($tiendas_data as $data) {
                $stmt_upd->bind_param("isi", $data['unidades'], $cod_producto, $data['tienda']);
                
                if (!$stmt_upd->execute()) {
                    throw new Exception("Error actualizando tienda " . $data['tienda'] . ": " . $stmt_upd->error);
                }
            }
            
            $stmt_upd->close();
            
            // Si todo va bien, confirmar transacción
            $dwes->commit();
            echo "<p style='color:green;'>Stock actualizado correctamente.</p>";
            
        } catch (Exception $e) {
            // Si hay error, revertir cambios
            $dwes->rollback();
            echo "<p style='color:red;'>Error al actualizar el stock: " . htmlspecialchars($e->getMessage()) . ". Operación revertida.</p>";
        }
    }
}

// Obtener stock actual para tienda 1 y 2 (prepared)
$unidades_central = 0;
$unidades_sucursal = 0;

$stmt_sel = $dwes->prepare("SELECT tienda, unidades FROM stock WHERE producto = ? AND tienda IN (1, 2)");

if ($stmt_sel) {
    $stmt_sel->bind_param("s", $cod_producto);
    $stmt_sel->execute();
    $res = $stmt_sel->get_result();
    
    while ($row = $res->fetch_assoc()) {
        if ($row['tienda'] == 1) {
            $unidades_central = intval($row['unidades']);
        } elseif ($row['tienda'] == 2) {
            $unidades_sucursal = intval($row['unidades']);
        }
    }
    $stmt_sel->close();
} else {
    echo "<p style='color:red;'>Error en la consulta de stock: " . htmlspecialchars($dwes->error) . "</p>";
}

// Mostrar formulario
echo "<h2>Stock del producto en las tiendas:</h2>";
echo "<form method='POST'>";
echo "<p>Tienda CENTRAL: <input type='number' name='unidades_1' min='0' value='" . htmlspecialchars($unidades_central) . "' required> unidades.</p>";
echo "<p>Tienda SUCURSAL: <input type='number' name='unidades_2' min='0' value='" . htmlspecialchars($unidades_sucursal) . "' required> unidades.</p>";
echo "<input type='submit' name='actualizar' value='Actualizar'>";
echo "</form>";
echo "<p><a href='index.php'>Volver a la lista de productos</a></p>";

mysqli_close($dwes);
?>