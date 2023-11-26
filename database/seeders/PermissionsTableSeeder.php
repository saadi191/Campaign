<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $items = [
            [
                'name'        => 'Can View Users',
                'slug'        => 'view.users',
                'description' => 'Can view users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Create Users',
                'slug'        => 'create.users',
                'description' => 'Can create new users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Edit Users',
                'slug'        => 'edit.users',
                'description' => 'Can edit users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can Delete Users',
                'slug'        => 'delete.users',
                'description' => 'Can delete users',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Roles',
                'slug'        => 'view.roles',
                'description' => 'Can View Roles',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can Delete Roles',
                'slug'        => 'delete.roles',
                'description' => 'Can Delete Roles',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can Edit Roles',
                'slug'        => 'edit.roles',
                'description' => 'Can Edit Roles',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can Create Roles',
                'slug'        => 'create.roles',
                'description' => 'Can Create Roles',
                'model'       => 'Permission',
            ],
//            [
//                'name'        => 'Can View Articles',
//                'slug'        => 'view.articles',
//                'description' => 'Can view articles',
//                'model'       => 'Permission',
//            ],
//            [
//                'name'        => 'Can Create Articles',
//                'slug'        => 'create.articles',
//                'description' => 'Can create new articles',
//                'model'       => 'Permission',
//            ],
//            [
//                'name'        => 'Can Edit Articles',
//                'slug'        => 'edit.articles',
//                'description' => 'Can edit articles',
//                'model'       => 'Permission',
//            ],
//            [
//                'name'        => 'Can Delete Articles',
//                'slug'        => 'delete.articles',
//                'description' => 'Can delete articles',
//                'model'       => 'Permission',
//            ],

            [
                'name'        => 'Can View Moderation',
                'slug'        => 'view.moderation',
                'description' => 'Can View Moderation',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Moderation Pending',
                'slug'        => 'view.moderation.pending',
                'description' => 'Can View Moderation Pending',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Moderation Approved',
                'slug'        => 'view.moderation.approved',
                'description' => 'Can View Moderation Approved',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Moderation Rejected',
                'slug'        => 'view.moderation.rejected',
                'description' => 'Can View Moderation Rejected',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Winners',
                'slug'        => 'view.winners',
                'description' => 'Can View Winners',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Winners Claimed',
                'slug'        => 'view.winners.claimed',
                'description' => 'Can View Claimed',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Winners Pending',
                'slug'        => 'view.winners.pending',
                'description' => 'Can View Pending',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View HelpDesk',
                'slug'        => 'view.helpdesk',
                'description' => 'Can View HelpDesk',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Exports',
                'slug'        => 'view.exports',
                'description' => 'Can View Exports',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Inventory',
                'slug'        => 'view.inventory',
                'description' => 'Can View Inventory',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Statistics',
                'slug'        => 'view.statistics',
                'description' => 'Can View Statistics',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Dashboard',
                'slug'        => 'view.dashboard',
                'description' => 'Can View Dashboard',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Can View Participants',
                'slug'        => 'view.participants',
                'description' => 'Can View Participants',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Can View Permissions',
                'slug'        => 'view.permissions',
                'description' => 'Can View Permissions',
                'model'       => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        $uniqueKeyOne = 'slug';
        $model = new Permission();

        foreach ($items as $item) {
            $model::withTrashed()->updateOrCreate([
                $uniqueKeyOne => $item[$uniqueKeyOne],
            ], $item);
        }
    }
}
