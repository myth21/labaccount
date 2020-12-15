<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Group;
use App\Models\Lab;
use App\Models\LabStudent;
use App\Models\LabStudentExe;
use App\Models\Student;
use App\Policies\BasePolicy;
use App\Policies\CoursePolicy;
use App\Policies\GroupPolicy;
use App\Policies\LabPolicy;
use App\Policies\LabStudentExePolicy;
use App\Policies\LabStudentPolicy;
use App\Policies\StudentPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        BasePolicy::class => BasePolicy::class,
        Course::class => CoursePolicy::class,
        Group::class => GroupPolicy::class,
        Lab::class => LabPolicy::class,
        LabStudent::class => LabStudentPolicy::class,
        LabStudentExe::class => LabStudentExePolicy::class,
        Student::class => StudentPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    // On initial loading of the app this method are called.
    // public function register(){}
}
