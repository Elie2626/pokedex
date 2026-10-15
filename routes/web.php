<?php

use App\Models\Pokemon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// PAGE ACCUEIL
Route::get('/accueil', function () {

    $humeur = 'gentil';
    $user = 'elie';

    return view('accueil', [
        'Utilisateur' => $user,
        'humeur' => $humeur
    ]);
});


// PAGE POKEMON
Route::get('/pokemon', function () {

    // Même ordre que la vidéo (2 secondes par Pokémon)
    $pokemon = [
        [
            'nom' => 'Dracaufeu', 'numero' => 6, 'rarete' => 'Très rare',
            'type' => 'Feu / Vol', 'couleur' => 'feu',
            'description' => 'Il crache des flammes capables de faire fondre la roche. Il ne s\'en prend jamais à plus faible que lui.',
            'pouvoirs' => ['Lance-Flammes', 'Déflagration', 'Vol', 'Danse Draco'],
            'stats' => ['PV' => 78, 'Attaque' => 84, 'Défense' => 78, 'Vitesse' => 100],
        ],
        [
            'nom' => 'Pikachu', 'numero' => 25, 'rarete' => 'Rare',
            'type' => 'Électrik', 'couleur' => 'electrik',
            'description' => 'Ses joues stockent de l\'électricité. Quand il est menacé, il libère des décharges foudroyantes.',
            'pouvoirs' => ['Tonnerre', 'Fatal-Foudre', 'Vive-Attaque', 'Queue de Fer'],
            'stats' => ['PV' => 35, 'Attaque' => 55, 'Défense' => 40, 'Vitesse' => 90],
        ],
        [
            'nom' => 'Bulbizarre', 'numero' => 1, 'rarete' => 'Commun',
            'type' => 'Plante / Poison', 'couleur' => 'plante',
            'description' => 'Le bulbe sur son dos grandit en absorbant la lumière du soleil depuis sa naissance.',
            'pouvoirs' => ['Fouet Lianes', 'Tranch\'Herbe', 'Vampigraine', 'Lance-Soleil'],
            'stats' => ['PV' => 45, 'Attaque' => 49, 'Défense' => 49, 'Vitesse' => 45],
        ],
        [
            'nom' => 'Carapuce', 'numero' => 7, 'rarete' => 'Commun',
            'type' => 'Eau', 'couleur' => 'eau',
            'description' => 'Il se réfugie dans sa carapace pour se protéger, puis riposte avec de puissants jets d\'eau.',
            'pouvoirs' => ['Pistolet à O', 'Hydrocanon', 'Repli', 'Aqua-Queue'],
            'stats' => ['PV' => 44, 'Attaque' => 48, 'Défense' => 65, 'Vitesse' => 43],
        ],
        [
            'nom' => 'Mewtwo', 'numero' => 150, 'rarete' => 'Légendaire',
            'type' => 'Psy', 'couleur' => 'psy',
            'description' => 'Créé par manipulation génétique, c\'est l\'un des Pokémon les plus puissants jamais découverts.',
            'pouvoirs' => ['Psyko', 'Frappe Psy', 'Ball\'Ombre', 'Soin'],
            'stats' => ['PV' => 106, 'Attaque' => 110, 'Défense' => 90, 'Vitesse' => 130],
        ],
    ];

    // Pokémon enregistrés dans la base de données (table pokemons)
    $captures = Pokemon::orderBy('id')->get();

    return view('pokemon', [
        'pokemon' => $pokemon,
        'captures' => $captures,
    ]);
});
