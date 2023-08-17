<?php

namespace App\Providers;

use App\Services\ListPointsService;
use App\QueryBuilders\QueryBuilder;
use Illuminate\Pagination\Paginator;
use App\Services\GetUserListsService;
use App\QueryBuilders\TagQueryBuilder;
use App\QueryBuilders\ListQueryBuilder;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Support\ServiceProvider;
use App\QueryBuilders\PointQueryBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueryBuilder::class, UserQueryBuilder::class);
        $this->app->bind(QueryBuilder::class, ListQueryBuilder::class);
        $this->app->bind(QueryBuilder::class, TagQueryBuilder::class);
        $this->app->bind(QueryBuilder::class, PointQueryBuilder::class);


        //Services

        $this->app->bind(GetUserListsService::class);
        $this->app->bind(ListPointsService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
    }
}
