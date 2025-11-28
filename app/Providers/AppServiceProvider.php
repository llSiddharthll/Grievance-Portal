<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('*', function ($view) {

            $menu = [];

            if (Auth::check()) {

                if (auth()->user()->hasRole('admin')) {
                    $menu = [
                        ['label' => __('Admin Dashboard'), 'url' => route('admin.dashboard')],
                        ['label' => __('Manage Users'), 'url' => route('admin.users.index')],
                        ['label' => __('Manage Complaints'), 'url' => route('admin.complaints.index')],
                        ['label' => __('Manage Feedbacks'), 'url' => route('feedback.index')],
                        ['label' => __('Manage Departments'), 'url' => route('admin.departments.index')],
                    ];
                } elseif (auth()->user()->hasRole('officer')) {
                    $menu = [
                        ['label' => __('Officer Dashboard'), 'url' => route('officer.dashboard')],
                        ['label' => __('Assigned Complaints'), 'url' => route('officer.complaints.index')],
                        ['label' => __('Feedbacks'), 'url' => route('feedback.index')],
                    ];
                } elseif (auth()->user()->hasRole('citizen')) {
                    $menu = [
                        ['label' => __('My Dashboard'), 'url' => route('dashboard'), 'icon' => '<i class="fa-regular fa-house"></i>'],
                        ['label' => __('Show Complaints'), 'icon' => '<i class="fa-regular fa-message"></i>', 'url' => route('complaints.index')],
                        ['label' => __('Register Complaint'), 'icon' => '<i class="fa-solid fa-plus"></i>', 'url' => route('complaints.create')],
                        ['label' => __('My Feedbacks'), 'icon' => '<i class="fa-regular fa-comment-dots"></i>', 'url' => route('feedback.index')],
                    ];
                }
            }

            $view->with('sidebarMenuItems', $menu);
        });
    }
}
