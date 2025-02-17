<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FamilyHeaderController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\IremboController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchFamilyController;
use App\Http\Controllers\SectorSettingsController;
use App\Http\Controllers\UserController;
use App\Http\Resources\SearchResource;
use App\Models\HospitalCard;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return to_route('login');
})->name('home');
Route::get('/dashboard', function () {
    $numbers = [
        'users' => User::count(),
        'cards' => HospitalCard::withTrashed()->count(),
        'admissions' => 12,
    ];
    $cards = HospitalCard::withTrashed()->orderByDesc('id')->limit(10)->get();
    return Inertia::render('Dashboard', ['cards' => SearchResource::collection($cards), 'numbers' => $numbers]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('sector')->name('sector.')->group(function () {
    Route::resource('families', FamilyHeaderController::class);
    Route::get('families/getSectors/{district}', [FamilyHeaderController::class, 'getSectors'])->name('families.getSectors');
    Route::get('families/getCells/{sector}', [FamilyHeaderController::class, 'getCells'])->name('families.getCells');
    Route::get('families/getVillages/{cell}', [FamilyHeaderController::class, 'getVillages'])->name('families.getVillages');

    Route::resource('family-members', FamilyMemberController::class);
    Route::controller(SectorSettingsController::class)->prefix('mutual-categories')->name('mutual-categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});
Route::prefix('irembo')->name('irembo.')->group(function () {
    Route::get('mutuelle', [IremboController::class, 'mutuelle'])->name('mutuelle');
    Route::post('mutuelle', [IremboController::class, 'mutuelleSearch'])->name('mutuelleSearch');
    Route::get('mutuelle/{family}', [IremboController::class, 'mutuelleShow'])->name('mutuelleShow');
    Route::get('mutuelle-pay/success', [IremboController::class, 'mutuellePaySuccess'])->name('mutuellePaySuccess');
    Route::post('mutuelleChechout', [IremboController::class, 'mutuelleChechout'])->name('mutuelleChechout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::controller(SearchFamilyController::class)->group(function () {
        Route::get('/manual-search', 'manualSearch')->name('manualSearch');
        Route::get('/smart-search', 'smartSearch')->name('smartSearch');
        Route::get('/family/{family}', 'showFamily')->name('showFamily');
        Route::post('/save-cardnumber', 'saveCardNumber')->name('saveCardNumber');
        Route::get('/search-person/{cardnumber}', 'searchPerson')->name('searchPerson');
    });

    Route::controller(AdmissionController::class)->name('admission.')->group(function () {
        Route::post('/store-vital-signs', 'store_vital_signs')->name('store_vital_signs');
        Route::put('/add_patient_data', 'add_patient_data')->name('add_patient_data');
        Route::get('/receptionist-admissions', 'receptionist_admissions')->name('receptionist_admissions');
        Route::get('/nurse-admissions', 'nurse_admissions')->name('nurse_admissions');
        Route::put('/add_price', 'add_price')->name('add_price');
        Route::get('/cashier-admissions', 'cashier_admissions')->name('cashier_admissions');


    });

    Route::controller(CardController::class)->prefix('cards')->name('cards.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});
require __DIR__ . '/auth.php';
