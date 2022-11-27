<?php

namespace App\Http\Controllers;

use App\Traits\PokemonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    use PokemonTrait;
    public function main()
    {
        $pokemones = $this->getPokemones();
        $html = "";
        foreach ($pokemones as $objPokemon) {

            $html .= view('card', compact('objPokemon'))->render();
        }
        //return view('pokemon')->with('tasks', $this->tasksUser);
        return view('pokemon', compact('html'));

    }

    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name_pokemon' => 'required|regex:/^[a-zA-Z]+$/u'
        ], [
                'regex' => 'Only letters are allowed.',
                'required' => 'Name pokemon is required.'
            ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $name = strtolower($request->input('name_pokemon'));
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name);

        if ($response == "Not Found") {
            return response()->json([
                'error' => 'Pokemon not found.'
            ]);
        }

        $pokemon = json_decode($response, true);

        $objPokemon = $this->getPokemon($pokemon['name']);

        if ($objPokemon) {
            return response()->json([
                'error' => 'Pokemon already exists.'
            ]);

        }
        $objPokemon = $this->createPokemon($pokemon);
        if (!$objPokemon) {
            return response()->json([
                'error' => 'Error add pokemon.'
            ]);
        }

        $html = view('card', compact('objPokemon'))->render();
        return response()->json([
            'success' => 'true',
            'response' => $html
        ]);

    }

    public function delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_pokemon' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        if (!$this->deletePokemon($request->input('id_pokemon'))) {
            return response()->json([
                'error' => 'Error delete pokemon'
            ]);
        }

        return response()->json([
            'success' => 'true',
            'response' => 'Successfully removed Pokemon'
        ]);

    }

    public function evolution(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pokemon' => 'required|integer',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        $response = Http::get($request->input('url'));

        if ($response == "Not Found") {
            return response()->json([
                'error' => 'Pokemon not found.'
            ]);
        }

        $species = json_decode($response, true);


        $evolution = Http::get($species['evolution_chain']['url']);

        $evolution_pokemon = json_decode($evolution, true);

        $pokemon = $this->getPokemonById($request->input('id_pokemon'));

        $name_pokemon = $evolution_pokemon['chain']['species']['name']; //charmeleon

        if ($pokemon->name === $name_pokemon) {
            $name_pokemon = $evolution_pokemon['chain']['evolves_to'][0]['species']['name'];

        } else {

            $name_pokemon = $evolution_pokemon['chain']['evolves_to'][0]['species']['name'];

            if (count($evolution_pokemon['chain']['evolves_to'][0]['evolves_to']) == 0) {
                return response()->json([
                    'error' => 'No more evolution.'
                ]);
            }

            if ($pokemon->name === $name_pokemon) {
                $name_pokemon = $evolution_pokemon['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];

            } else {
                return response()->json([
                    'error' => 'No more evolution.'
                ]);
            }
        }

        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $name_pokemon);

        $response = json_decode($response, true);
        $objPokemon = $this->updatePokemon($request->input('id_pokemon'), $response);

        if (!$objPokemon) {
            return response()->json([
                'error' => 'Error update pokemon.'
            ]);
        }

        $html = view('card', compact('objPokemon'))->render();

        return response()->json([
            'success' => 'true',
            'response' => $html
        ]);

    }
}