<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokémon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
<header>
	Mi blog de <img src="img/International_Pokémon_logo.svg.png" alt="Pokemon Logo">
</header>

<nav>
    <a href="index.php?region=kanto"><strong>G1 Kanto</strong></a>
    <a href="index.php?region=johto"><strong>G2 Johto</strong></a>
    <a href="index.php?region=hoenn"><strong>G3 Hoenn</strong></a>
    <a href="index.php?region=sinnoh"><strong>G4 Sinnoh</strong></a>
    <a href="index.php?region=unova"><strong>G5 Unova</strong></a>
    <a href="index.php?region=kalos"><strong>G6 Kalos</strong></a>
    <a href="index.php?region=alola"><strong>G7 Alola</strong></a>
    <a href="index.php?region=galar"><strong>G8 Galar</strong></a>
    <a href="index.php?region=paldea"><strong>G9 Paldea</strong></a>
    <a href="index.php?page=search"><strong>Búsqueda</strong></a>
</nav>

<div id="iniciales">
    <?php
    require_once 'functions.php';

    $region = $_GET['region'] ?? null;
    $pokemon_id = $_GET['pokemon'] ?? null;
    $page = $_GET['page'] ?? null;
    $search_query = $_POST['search'] ?? null;

    if ($search_query) {
        $pokemon = search_pokemon($search_query);
        if ($pokemon) {
            $pokemon_id = $pokemon['id'];
        } else {
            echo "<div class='error'>Pokémon no encontrado.</div>";
        }
    }

    if ($pokemon_id) {
        $p = get_pokemon_details($pokemon_id);
        if ($p) {
            $img = $p['sprites']['other']['official-artwork']['front_default'];
            echo "<div class='pokemon-detail'>";
            echo "<h1>" . ucfirst($p['name']) . "</h1>";
            echo "<img src='$img' alt='{$p['name']}'>";
            echo "<p><strong>Altura:</strong> " . ($p['height'] / 10) . " m</p>";
            echo "<p><strong>Peso:</strong> " . ($p['weight'] / 10) . " kg</p>";
            echo "<p><strong>Tipos:</strong> ";
            foreach($p['types'] as $t) {
                $type_name = $t['type']['name'];
                echo "<span class='type-badge type-" . $type_name . "'>" . ucfirst($type_name) . "</span>";
            }
            echo "</p>";
            
            echo "<div class='stats-section'>";
            echo "<h3>Estadísticas Base</h3>";
            foreach($p['stats'] as $stat) {
                $stat_name = ucfirst(str_replace('-', ' ', $stat['stat']['name']));
                $stat_value = $stat['base_stat'];
                $percentage = min(($stat_value / 255) * 100, 100);
                echo "<div class='stat-row'>";
                echo "<span class='stat-name'>" . $stat_name . ":</span>";
                echo "<div class='stat-bar-container'>";
                echo "<div class='stat-bar' style='width: " . $percentage . "%;'></div>";
                echo "</div>";
                echo "<span class='stat-value'>" . $stat_value . "</span>";
                echo "</div>";
            }
            echo "</div>";
            
            echo "<div class='moves-section'>";
            echo "<h3>Ataques (" . count($p['moves']) . " total)</h3>";
            echo "<div class='moves-grid'>";
            foreach($p['moves'] as $move) {
                echo "<div class='move-item'>" . ucfirst(str_replace('-', ' ', $move['move']['name'])) . "</div>";
            }
            echo "</div></div>";
            
            echo "<a href='javascript:history.back()' class='btn'>Volver</a>";
            echo "</div>";
        } else {
            echo "<div class='error'>Pokémon no encontrado.</div>";
        }
    } elseif ($region) {
        $pokedex = get_region_details($region);
        if ($pokedex) {
            echo "<h2>Pokémons en " . ucfirst($region) . " (" . count($pokedex['pokemon_entries']) . " total)</h2>";
            echo "<div class='pokemon-grid'>";
            foreach ($pokedex['pokemon_entries'] as $entry) {
                $name = $entry['pokemon_species']['name'];
                $pokedex_number = $entry['entry_number'];

                $url_parts = explode('/', rtrim($entry['pokemon_species']['url'], '/'));
                $id = end($url_parts);
                $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/$id.png";
                
                echo "<div class='card'>";
                echo "<a href='index.php?pokemon=$id'>";
                echo "<div class='pokemon-number'>#" . str_pad($pokedex_number, 3, '0', STR_PAD_LEFT) . "</div>";
                echo "<img src='$img' loading='lazy' alt='$name'>";
                echo "<h3>" . ucfirst($name) . "</h3>";
                echo "</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='error'>Región no encontrada o sin pokédex principal.</div>";
        }
    } elseif ($page === 'search') {
        echo "<div class='search-container'>";
        echo "<h2>Buscar Pokémon</h2>";
        echo "<form method='POST' action='index.php'>";
        echo "<input type='text' name='search' placeholder='Nombre o ID del Pokémon...' required>";
        echo "<button type='submit'>Buscar</button>";
        echo "</form>";
        echo "</div>";
    } else {
        $data = get_all_regions();
        echo "<h2>Regiones</h2>";
        echo "<div class='regions-grid'>";
        foreach ($data['results'] as $r) {
            echo "<div class='card region-card'>";
            echo "<a href='index.php?region={$r['name']}'>";
            echo "<h3>" . strtoupper($r['name']) . "</h3>";
            echo "</a>";
            echo "</div>";
        }
        echo "</div>";
    }
    ?>
</div>

<footer>
	Trabajo <strong>Desarrollo Web en Entorno Servidor</strong> 2024/2025
</footer>

</body>
</html>