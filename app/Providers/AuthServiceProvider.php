<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\TopicPolicy;
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
        Category::class => CategoryPolicy::class,
        Topic::class => TopicPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('like', fn(User $user) => true);

        Gate::before(function (User $user, string $ability) {
            // admin 跳过所有检查
            if ($user->is_admin) {
                return true;
            }

            return null;
        });
    }
}
