<?php

namespace App\Providers;

use App\Models\User;
use Coba\ApiPostman\ApiPostman;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Illuminate\Support\Facades\Hash;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::createUserUsing(function ($command) {
            return [
                $command->ask('NIP'),
                $command->ask('email'),
                $command->ask('nama'),
                $command->ask('kode_divisi'),
                $command->ask('kode_bagian'),
                $command->ask('kode_jabatan'),
                $command->ask('kode_grup'),
                $command->secret('Password'),
                // My Custom prompts:
            ];
        }, function ($nip, $email, $nama, $kode_divisi, $kode_bagian, $kode_jabatan, $kode_grup, $password) {
            (new User)->forceFill([
                'nip' => $nip,
                'email' => $email,
                'nama' => $nama,
                'kode_divisi' => $kode_divisi,
                'kode_bagian' => $kode_bagian,
                'kode_jabatan' => $kode_jabatan,
                'kode_grup' => $kode_grup,
                'password' => Hash::make($password),
                // My custom fields
                'is_admin' => true,
            ])->save();
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new ApiPostman
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
