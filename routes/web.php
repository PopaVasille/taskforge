<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TimeTrackingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Proiecte
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::get('/show/{project}', [ProjectController::class, 'show'])->name('show');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        Route::post('/settings', [ProjectController::class, 'settings'])->name('settings');
        Route::get('/active', [ProjectController::class, 'active'])->name('active');
        Route::get('/archived', [ProjectController::class, 'archived'])->name('archived');
        Route::post('/generate-key', [ProjectController::class, 'generateProjectKey'])->name('generate-key');
        Route::get('/edit/{project}', [ProjectController::class, 'edit'])->name('edit');
        Route::put('/update/{project}', [ProjectController::class, 'update'])->name('update');
        Route::post('archive/{project}', [ProjectController::class, 'archive'])->name('archive');
        Route::post('unarchive/{project}', [ProjectController::class, 'unarchive'])->name('unarchive');
        // Sprinturi
        Route::get('/sprints', [SprintController::class, 'index'])->name('sprints');
        Route::get('/sprints/active', [SprintController::class, 'active'])->name('sprints.active');
        Route::get('/sprints/planning', [SprintController::class, 'planning'])->name('sprints.planning');
        Route::get('/sprints/history', [SprintController::class, 'history'])->name('sprints.history');

        // Echipe
        Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    });

    // Task-uri
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');
    Route::get('/tasks/in-progress', [TaskController::class, 'inProgress'])->name('tasks.in-progress');
    Route::get('/tasks/review', [TaskController::class, 'review'])->name('tasks.review');
    Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');

    // Documentație
    Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation.index');
    Route::get('/documentation/view', [DocumentationController::class, 'view'])->name('documentation.view');
    Route::get('/documentation/generate', [DocumentationController::class, 'generate'])->name('documentation.generate');
    Route::get('/documentation/history', [DocumentationController::class, 'history'])->name('documentation.history');

    // Echipă
    Route::resource('team', TeamController::class)->only(['index', 'show']);

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/preferences', [SettingsController::class, 'preferences'])->name('preferences');
        Route::get('/notifications', [SettingsController::class, 'notifications'])->name('notifications');
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        Route::get('/integrations', [SettingsController::class, 'integrations'])->name('integrations');

        // Routes pentru actualizări
        Route::post('/preferences', [SettingsController::class, 'updatePreferences'])->name('preferences.update');
        Route::post('/notifications', [SettingsController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/security', [SettingsController::class, 'updateSecurity'])->name('security.update');
        Route::post('/integrations', [SettingsController::class, 'updateIntegrations'])->name('integrations.update');
    });

    // Notificări
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    // User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');

    // Time Tracking routes
    Route::prefix('timetracking')->name('timetracking.')->group(function () {
        Route::get('/', [TimeTrackingController::class, 'index'])->name('index');
        Route::get('/entries', [TimeTrackingController::class, 'entries'])->name('entries');
        Route::get('/new', [TimeTrackingController::class, 'create'])->name('new');
        Route::post('/entries', [TimeTrackingController::class, 'store'])->name('store');
        Route::get('/reports', [TimeTrackingController::class, 'reports'])->name('reports');
        Route::get('/dashboard', [TimeTrackingController::class, 'dashboard'])->name('dashboard');
        Route::get('/history', [TimeTrackingController::class, 'history'])->name('history');
    });
});

require __DIR__.'/auth.php';
