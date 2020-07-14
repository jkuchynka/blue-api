<?php

namespace App\Auth\Listeners;

use App\Auth\Models\Permission;
use App\Auth\Models\Role;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuthEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * Handle syncing roles and permissions from modules
     *
     * @param object $event
     * @return void
     */
    public function handleSyncRolesPermissions($event)
    {
        // Sync roles from modules
        $roles = [];
        $modulesService = app('modules');
        foreach ($modulesService->getModules() as $module) {
            foreach ($module->get('roles', []) as $roleConfig) {
                $role = Role::where('name', $roleConfig['name'])->first();
                if (! $role) {
                    $role = Role::create([
                        'name' => $roleConfig['name'],
                        'display_name' => $roleConfig['display_name'],
                        'description' => $roleConfig['description']
                    ]);
                } else {
                    $role->display_name = $roleConfig['display_name'];
                    $role->description = $roleConfig['description'];
                    $role->save();
                }
                $roles[$role->name] = $role;
            }
        }

        // Sync permissions from modules
        $permissions = [];
        $rolePermissions = [];
        foreach ($modulesService->getModules() as $module) {
            foreach ($module->get('permissions', []) as $permConfig) {
                $perm = Permission::where('name', $permConfig['name'])->first();
                if (! $perm) {
                    $perm = Permission::create([
                        'name' => $permConfig['name'],
                        'display_name' => $permConfig['display_name'],
                        'description' => $permConfig['description']
                    ]);
                } else {
                    $perm->display_name = $permConfig['display_name'];
                    $perm->description = $permConfig['description'];
                    $perm->save();
                }
                if (! isset($permissions[$perm->name])) {
                    $permissions[$perm->name] = $perm;
                }
                if (! empty($permConfig['roles'])) {
                    foreach ($permConfig['roles'] as $roleName) {
                        if (! isset($rolePermissions[$roleName])) {
                            $rolePermissions[$roleName] = [];
                        }
                        $rolePermissions[$roleName][] = $perm;
                    }
                }
            }
        }

        foreach ($rolePermissions as $roleName => $permissions) {
            $roles[$roleName]->syncPermissions($permissions);
        }
    }

    /**
     * Subscribe to events
     *
     * @param array $events
     * @return void
     */
    public function subscribe($events)
    {
        // $events->listen(
        //     'Illuminate\Database\Events\MigrationsEnded',
        //     'App\Auth\Listeners\AuthEventSubscriber@handleMigrationsEnded'
        // );

        $events->listen(
            [
                'Illuminate\Database\Events\NoPendingMigrations',
                'Illuminate\Database\Events\MigrationsEnded'
            ],
            get_class($this).'@handleSyncRolesPermissions'
        );
    }
}
