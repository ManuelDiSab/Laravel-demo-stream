<?php

use App\Http\Controllers\Api\v1\AnagraficaUtentiController;
use App\Http\Controllers\Api\v1\ConfigurazioniController;
use App\Http\Controllers\Api\v1\AccessoController;
use App\Http\Controllers\Api\v1\ComuniController;
use App\Http\Controllers\Api\v1\ContattiRecapitiController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\api\v1\episodiController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\GeneriController;
use App\Http\Controllers\Api\v1\IndirizziController;
use App\Http\Controllers\api\v1\nazioniController;
use App\Http\Controllers\Api\v1\PreferitiController;
use App\Http\Controllers\api\v1\serieTvController;
use App\Http\Controllers\Api\v1\TipologiaIndirizziController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

// Definisco una costante per le versione delle api
if (!defined("_VERS")) {
    define('_VERS', 'v1');
}           
//Route accessibili da chiunque non abbia un account 

//Route per i comuni e le nazioni
Route::get(_VERS . '/prova/{idFilm}', [FilmController::class, 'check']); //PEr prova e poi da cancellare        
Route::get(_VERS . '/comuni', [ComuniController::class, 'index']);
Route::get(_VERS . '/comune/{comune}', [ComuniController::class, 'show']);
Route::get(_VERS . '/provincia/{comune}', [ComuniController::class, 'showProvincia']);
Route::get(_VERS . '/sigla-provincia', [ComuniController::class, 'siglaAutoCollection']);
Route::get(_VERS . '/nazioni', [nazioniController::class, 'index']);
Route::get(_VERS . '/nazioni/{id}', [nazioniController::class, 'show']);

//Route pe l'accesso e la registrazione
Route::post(_VERS . '/logout', [AccessoController::class, 'logout']);
Route::get(_VERS . '/accedi/{user}/{hash?}', [AccessoController::class, 'login']);
Route::post(_VERS . '/register/', [AccessoController::class, 'register']);

//Api protette dall'autenticazione 
Route::middleware([EnsureTokenIsValid::class])->group(function () {
    //---------------------------------------------  SOLO ADMIN  -------------------------------------------------------
    #################################################################################################################################
    //Route per la gestione utenti
    Route::get(_VERS . '/lista-utenti', [UserController::class, 'indexAdmin']);
    Route::get(_VERS . '/lista-utenti/{idUser}', [UserController::class, 'showAdmin']);
    Route::put(_VERS . '/lista-utenti/{idUser}', [UserController::class, 'updateStatus']);
    Route::get(_VERS . '/lista-utenti/ricerca/{ricerca}', [UserController::class, 'ricercaUtente']);
    Route::delete(_VERS . '/elimina-utente/{idUser}', [UserController::class, 'destroyAdmin']);

    //Route per la gestione delle configurzioni
    Route::get(_VERS . '/configurazioni', [ConfigurazioniController::class, 'index']);
    Route::get(_VERS . '/configurazioni/{id}', [ConfigurazioniController::class, 'show']);
    Route::post(_VERS . '/configurazioni', [ConfigurazioniController::class, 'store']); //Da fare
    Route::post(_VERS . '/configurazioni/{id}', [ConfigurazioniController::class, 'update']); //Da fare
    Route::delete(_VERS . '/configurazioni/{id}', [ConfigurazioniController::class, 'destroy']); //Da fare

    //Route per indirizzi e tipologie indirizzi
    Route::post(_VERS . '/tipo-indirizzo', [TipologiaIndirizziController::class, 'store']);
    Route::put(_VERS . '/tipo-indirizzo/{tipologia}', [TipologiaIndirizziController::class, 'update']);
    Route::delete(_VERS . '/tipo-indirizzo/{idTipo}', [TipologiaIndirizziController::class, 'destroy']);
    Route::get(_VERS . '/indirizzi', [IndirizziController::class, 'index']);
    Route::get(_VERS . '/indirizzi/{idIndirizzo}', [IndirizziController::class, 'show']);


    //Route per i comuni
    Route::put(_VERS . '/comuni/{idComune}', [ComuniController::class, 'update']);
    Route::delete(_VERS . '/comuni/{idComune}', [ComuniController::class, 'destroy']);

    // Route per la gestione dei generi
    Route::post(_VERS . '/genere', [GeneriController::class, 'store']);
    Route::put(_VERS . '/genere/{idGenere}', [GeneriController::class, 'update']);
    Route::delete(_VERS . '/genere/{idGenere}', [GeneriController::class, 'destroy']);

    //Route per la gestione dei film
    Route::post(_VERS . '/film', [FilmController::class, 'store']);
    Route::put(_VERS . '/film/{film}', [FilmController::class, 'update']);
    Route::delete(_VERS . '/film/{idFilm}', [FilmController::class, 'destroy']);
    Route::post(_VERS . '/locandina/film/{idFilm}', [FilmController::class, 'UpdateImage']);
    Route::post(_VERS . '/video/film/{idFilm}', [FilmController::class, 'UpdateVideo']);
    //Route per la gestione delle serie
    Route::post(_VERS . '/serie', [serieTvController::class, 'store']);
    Route::put(_VERS . '/serie/{serie}', [serieTvController::class, 'update']);
    Route::delete(_VERS . '/serie/{idSerie}', [serieTvController::class, 'destroy']);
    Route::post(_VERS . '/serie/episodi', [episodiController::class, 'store']);
    Route::put(_VERS . '/serie/episodi/{episodio}', [episodiController::class, 'update']);
    Route::delete(_VERS . '/serie/episodi/{idEpisodio}', [episodiController::class, 'destroy']);
    Route::post(_VERS . '/locandina/serie/{idSerie}', [serieTvController::class, 'UpdateImage']);
    Route::post(_VERS . '/locandina/episodi/{idEpisodio}', [episodiController::class, 'UpdateImage']);
    Route::post(_VERS . '/video/episodi/{idEpisodio}', [episodiController::class, 'UpdateVideo']);




    //---------------------------------------------  USERS & ADMIN  -------------------------------------------------------
    #################################################################################################################################

    // Route accessibili da user e amministratori
    //Route per i profili
    Route::put(_VERS . '/user', [UserController::class, 'update']);
    Route::delete(_VERS . '/user', [UserController::class, 'destroy']);
    Route::get(_VERS . '/user', [UserController::class, 'show']);
    Route::get(_VERS . '/user/check-utente', [UserController::class, 'checkUtente']);

    Route::post( _VERS . '/user/cambia-password/{hash}',[UserController::class, 'cambioPassword']);
    Route::get(_VERS . '/dati-utente', [AnagraficaUtentiController::class, 'index']);
    Route::put(_VERS . '/dati-utente', [AnagraficaUtentiController::class, 'update']);
    Route::get(_VERS . '/indirizzo-user', [IndirizziController::class, 'showIndirizzoUser']);
    Route::get(_VERS . '/recapiti-utente', [ContattiRecapitiController::class, 'show']);
    Route::put(_VERS . '/recapiti', [ContattiRecapitiController::class, 'update']);

    //Api per indirizzi e tipologia indirizzi
    Route::get(_VERS . '/tipo-indirizzo', [TipologiaIndirizziController::class, 'index']);
    Route::get(_VERS . '/tipo-indirizzo/{tipo}', [TipologiaIndirizziController::class, 'show']);
    Route::put(_VERS . '/indirizzo', [IndirizziController::class, 'update']);
    Route::get(_VERS . '/indirizzo', [IndirizziController::class, 'index']);
    Route::post(_VERS . '/indirizzo', [IndirizziController::class, 'store']);
    Route::delete(_VERS . '/indirizzo/{idIndirizzo}', [IndirizziController::class, 'destroy']);

    //Route per la gestione dei generi 
    Route::get(_VERS . '/genere', [GeneriController::class, 'index']);
    Route::get(_VERS . '/genere/{id}', [GeneriController::class, 'show']);
    Route::put(_VERS . 'genere/{idGenere}', [GeneriController::class, 'update']);

    //Routes per la visualizazione dei film
    Route::get(_VERS . '/film', [FilmController::class, 'index']);
    Route::get(_VERS . '/film/search', [FilmController::class, 'ricerca']);
    Route::get(_VERS . '/film/{film}', [FilmController::class, 'show']);
    Route::get(_VERS . '/film/genere/{idGenere}', [FilmController::class, 'indexGenere']);
    Route::post(_VERS . '/add-preferiti/film/{idFilm}', [PreferitiController::class, 'AddFilmPreferiti']);
    Route::delete(_VERS . '/del-preferiti/film/{idFilm}', [PreferitiController::class, 'EliminaFilmDaiPreferiti']);
    Route::get(_VERS . '/preferiti/film', [PreferitiController::class, 'indexFilm']);

    // Routes per la visualizzazione delle serie tv
    Route::get(_VERS . '/serie', [serieTvController::class, 'index']);
    Route::get(_VERS . '/serie/search', [serieTvController::class, 'ricerca']);
    Route::get(_VERS . '/serie/{serie}', [serieTvController::class, 'show']);
    Route::get(_VERS . '/serie/genere/{genere}', [serieTvController::class, 'seriePerGenere']);
    Route::get(_VERS . '/serie/{idSerie}/episodi', [episodiController::class, 'index']);
    Route::get(_VERS . '/serie/{idSerie}/{episodio}', [episodiController::class, 'show']);
    Route::post(_VERS . '/add-preferiti/serie/{idSerie}', [PreferitiController::class, 'AddSeriePreferite']);
    Route::delete(_VERS . '/del-preferiti/serie/{idSerie}', [PreferitiController::class, 'CancellaSerieDaiPreferiti']);
    Route::get(_VERS . '/preferiti/serie', [PreferitiController::class, 'indexSerie']);
});
