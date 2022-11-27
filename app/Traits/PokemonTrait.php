<?php
namespace App\Traits;

use App\Models\Pokemon;

trait PokemonTrait
{
    public function createPokemon($pokemon)
    {

        $objPokemon = new Pokemon;
        $objPokemon->name = $pokemon['name'];
        $objPokemon->url_species = $pokemon['species']['url'];
        $objPokemon->url_photo = $pokemon['sprites']['other']['dream_world']['front_default'];
        $objPokemon->stats = json_encode($pokemon['stats']);
        $objPokemon->base_experience = $pokemon['base_experience'];
        $objPokemon->weight = $pokemon['weight'];
        $objPokemon->height = $pokemon['height'];

        if (!$objPokemon->save()) {

            return false;
        }

        return $objPokemon;
    }
    public function updatePokemon($id, $pokemon)
    {

        $objPokemon = Pokemon::find($id);
        $objPokemon->name = $pokemon['name'];
        $objPokemon->url_species = $pokemon['species']['url'];
        $objPokemon->url_photo = $pokemon['sprites']['other']['dream_world']['front_default'];
        $objPokemon->stats = json_encode($pokemon['stats']);
        $objPokemon->base_experience = $pokemon['base_experience'];
        $objPokemon->weight = $pokemon['weight'];
        $objPokemon->height = $pokemon['height'];

        if (!$objPokemon->save()) {

            return false;
        }

        return $objPokemon;
    }

    public function getPokemon($name)
    {
        $pokemon = Pokemon::where('name', $name)->first();

        if (!$pokemon) {
            return false;
        }

        return $pokemon;
    }

    public function getPokemones()
    {
        return Pokemon::all();
    }

    public function deletePokemon($id)
    {
        $pokemon = Pokemon::find($id);

        if (!$pokemon->delete()) {
            return false;
        }

        return true;
    }

    public function getPokemonById($id)
    {
        return Pokemon::find($id);
    }
}