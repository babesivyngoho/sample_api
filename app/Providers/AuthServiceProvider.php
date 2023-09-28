<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */

    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // Gate::policy(Project::class, ProjectPolicy::class);
        Gate::policy(Concept::class, ConceptPolicy::class);

        $this->app['auth']->viaRequest('api', function ($request) {

            if ($request->header('Authorization')) {

                $key = explode(' ', $request->header('Authorization'));
                $user = User::where('api_key', $key[1])->first();

                if (!empty($user)) {
                    $request->request->add(['userid' => $user->id]);
                }

                return $user;
            }

            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        // Gate::define('update-project', function ($user, $projects) {
        //     foreach($projects as $project){
        //         echo $project;
        //         if ($project->role_id === 5 || $project->role_id === 4){
        //             return true;
        //         }
        //     }
        //     return false;
        // });
            
        // 
    }
}
