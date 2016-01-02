<?php

namespace App\Providers;

use App\Policies\EntryPolicy;
use App\DataAccess\Eloquent\Entry;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * 認可ロジックとしてApp\Policies\EntryPolicyクラスのupdateメソッドを加えます
     *
     * @see App\Policies\EntryPolicy::update
     * @var array
     */
    protected $policies = [
        Entry::class => EntryPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
    }
}
