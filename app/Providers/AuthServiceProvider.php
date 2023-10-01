<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //role admin, user
        $this->defineUserRoleGate(name: 'isAdmin', role: UserRole::ADMIN);
        $this->defineUserRoleGate(name: 'isUser', role: UserRole::USER);
        
    }

    private function defineUserRoleGate(string $name, string $role): void
    {
        Gate::define($name,function (User $user) use ($role)
        {
            return $user->role == $role;
        });
    }
}
