<?php

function get_data($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response ? json_decode($response, true) : null;
}

function get_all_regions()
{
    return get_data("https://pokeapi.co/api/v2/region/");
}

function get_region_details($name)
{
    $region_data = get_data("https://pokeapi.co/api/v2/region/" . $name);

    if (isset($region_data['pokedexes'][0]['url'])) {
        return get_data($region_data['pokedexes'][0]['url']);
    }
    return null;
}

function get_pokemon_details($id_or_name)
{
    return get_data("https://pokeapi.co/api/v2/pokemon/" . $id_or_name);
}

function search_pokemon($query)
{
    return get_data("https://pokeapi.co/api/v2/pokemon/" . strtolower($query));
}
