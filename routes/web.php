<?php

use App\Http\Controllers\AnneeAcademiqueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\NiveauController;
use App\Http\Controllers\PvController;
use App\Http\Controllers\ResultatController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Accueil
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Espace connecté (compte actif obligatoire)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'actif'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Admin + secrétaire : PV et résultats
    |----------------------------------------------------------------------
    | Les routes personnalisées sont déclarées AVANT Route::resource
    | pour ne pas être confondues avec la route show ({pv}).
    */
    Route::middleware('role:admin,secretaire')->group(function () {

        // Actions spécifiques aux PV
        Route::post('pvs/{pv}/calculer', [PvController::class, 'calculer'])->name('pvs.calculer');
        Route::patch('pvs/{pv}/valider', [PvController::class, 'valider'])->name('pvs.valider');
        Route::get('pvs/{pv}/pdf', [PvController::class, 'pdf'])->name('pvs.pdf');

        // Actions spécifiques aux résultats
        Route::post('resultats/import', [ResultatController::class, 'import'])->name('resultats.import');
        Route::get('resultats/export', [ResultatController::class, 'export'])->name('resultats.export');

        Route::resource('pvs', PvController::class)
            ->parameters(['pvs' => 'pv']);

        Route::resource('resultats', ResultatController::class)
            ->parameters(['resultats' => 'resultat']);
    });

    /*
    |----------------------------------------------------------------------
    | Admin uniquement : référentiels, utilisateurs, journal
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        Route::resource('filieres', FiliereController::class)
            ->parameters(['filieres' => 'filiere']);

        Route::resource('annees', AnneeAcademiqueController::class)
            ->parameters(['annees' => 'annee']);

        Route::resource('niveaux', NiveauController::class)
            ->parameters(['niveaux' => 'niveau']);

        Route::resource('semestres', SemestreController::class)
            ->parameters(['semestres' => 'semestre']);

        // Gestion des utilisateurs
        Route::patch('users/{user}/toggle-actif', [UserController::class, 'toggleActif'])
            ->name('users.toggle-actif');
        Route::resource('users', UserController::class)->except(['show']);

        // Journal d'activité (consultation seulement)
        Route::get('journal', [JournalController::class, 'index'])->name('journal.index');
        Route::get('journal/{journal}', [JournalController::class, 'show'])->name('journal.show');
    });
});