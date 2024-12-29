<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/active', [ProjectController::class, 'active'])->name('projects.active');
    Route::get('/projects/archived', [ProjectController::class, 'archived'])->name('projects.archived');

    // Task-uri
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');
    Route::get('/tasks/in-progress', [TaskController::class, 'inProgress'])->name('tasks.in-progress');
    Route::get('/tasks/review', [TaskController::class, 'review'])->name('tasks.review');
    Route::get('/tasks/completed', [TaskController::class, 'completed'])->name('tasks.completed');

    // Sprint-uri
    Route::resource('sprints', SprintController::class);
    Route::get('/sprints/active', [SprintController::class, 'active'])->name('sprints.active');
    Route::get('/sprints/planning', [SprintController::class, 'planning'])->name('sprints.planning');
    Route::get('/sprints/history', [SprintController::class, 'history'])->name('sprints.history');

    // Documentație
    Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation.index');
    Route::get('/documentation/view', [DocumentationController::class, 'view'])->name('documentation.view');
    Route::get('/documentation/generate', [DocumentationController::class, 'generate'])->name('documentation.generate');
    Route::get('/documentation/history', [DocumentationController::class, 'history'])->name('documentation.history');

    // Echipă
    Route::resource('team', TeamController::class)->only(['index', 'show']);

    // Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // Setări
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

    // Notificări
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
});

require __DIR__.'/auth.php';
