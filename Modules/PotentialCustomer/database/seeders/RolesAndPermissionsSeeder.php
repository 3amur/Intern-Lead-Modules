<?php

namespace Modules\PotentialCustomer\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gardName = config('auth.defaults.guard');
        $permissionsByRole = [
            'admin' => [

                'leadSettings.countrySettings',
                'leadSettings.leadSettings',
                'leadSettings.targetSettings',
                'leadSettings.departmentSettings',


                /* Countries */
                'countries.index',
                'countries.show',
                'countries.create',
                'countries.edit',
                'countries.destroy',
                'countries.export',


                /* States */
                'states.index',
                'states.show',
                'states.create',
                'states.edit',
                'states.destroy',
                'states.export',


                /* Cities */
                'cities.index',
                'cities.show',
                'cities.create',
                'cities.edit',
                'cities.destroy',
                'cities.export',


                /* Lead Source */
                'leads',
                'leads.settings',
                'lead_home.index',
                'lead_source.index',
                'lead_source.show',
                'lead_source.create',
                'lead_source.edit',
                'lead_source.destroy',
                'lead_source.export',


                /* Lead Status */
                'lead_status.index',
                'lead_status.show',
                'lead_status.create',
                'lead_status.edit',
                'lead_status.destroy',
                'lead_status.export',


                /* Lead Type */
                'lead_type.index',
                'lead_type.show',
                'lead_type.create',
                'lead_type.edit',
                'lead_type.destroy',
                'lead_type.export',


                /* Lead Value */
                'lead_value.index',
                'lead_value.show',
                'lead_value.create',
                'lead_value.edit',
                'lead_value.destroy',
                'lead_value.export',


                /* Lead Account */
                'lead_account.index',
                'lead_account.show',
                'lead_account.create',
                'lead_account.edit',
                'lead_account.destroy',
                'lead_account.import',
                'lead_account.export',

                /* Potential Account  */
                'lead_account.potentialTransition',
                'potential_account.LeadTransition',
                'potential_account.index',
                'potential_account.show',
                'potential_account.create',
                'potential_account.edit',
                'potential_account.destroy',
                'potential_account.import',
                'potential_account.export',


                /* Potential Account Details */
                'potential_account_details.create',
                'potential_account_details.edit',
                'potential_account_details.destroy',
                /* Links */
                'links.index',
                'links.show',
                'links.create',
                'links.edit',
                'links.destroy',

                /* Collected Customer Data */
                'collected_customer_data.create',
                'collected_customer_data.showCollectedDataDetails',
                'imported_customer_data.export',
                'imported_customer_data.exportImportedData',
                'collected_customer_data.showHeadMemberDetails',
                'imported_customer_data.import',
                'collected_customer_data.chartPage',

                /* Family Members */
                'family_members.index',
                'family_members.show',
                'family_members.create',
                'family_members.edit',
                'family_members.destroy',

                /* Target Types */
                'target_types.index',
                'target_types.show',
                'target_types.create',
                'target_types.edit',
                'target_types.destroy',
                'target_types.export',

                /* Sales Targets */
                'sales_targets.index',
                'sales_targets.show',
                'sales_targets.create',
                'sales_targets.edit',
                'sales_targets.destroy',
                'sales_targets.export',


                /* Sales Agents */
                'sales_agents.index',
                'sales_agents.show',
                'sales_agents.create',
                'sales_agents.edit',
                'sales_agents.destroy',
                'sales_agents.export',


                /* Sales commissions */
                'sales_commissions.index',
                'sales_commissions.show',
                'sales_commissions.create',
                'sales_commissions.edit',
                'sales_commissions.destroy',
                'sales_commissions.export',


                /* Broker Types */
                'broker_types.index',
                'broker_types.show',
                'broker_types.create',
                'broker_types.edit',
                'broker_types.destroy',
                'broker_types.export',


                /* Broker*/
                'brokers.index',
                'brokers.show',
                'brokers.create',
                'brokers.edit',
                'brokers.destroy',
                'brokers.export',


                /* Broker commissions */
                'broker_commissions.index',
                'broker_commissions.show',
                'broker_commissions.create',
                'broker_commissions.edit',
                'broker_commissions.destroy',
                'broker_commissions.export',


                /* Departments */
                'departments.index',
                'departments.show',
                'departments.create',
                'departments.edit',
                'departments.destroy',

                /* Teams*/
                /* 'teams.index',
                'teams.show',
                'teams.create',
                'teams.edit',
                'teams.destroy', */
            ],
        ];


        $insertPermissions = fn($role) => collect($permissionsByRole[$role])
            ->map(fn($name) => DB::table(config('permission.table_names.permissions'))->insertGetId(['name' => $name, 'group' => ucfirst(explode('.', str_replace('_', ' ', $name))[0]), 'guard_name' => $gardName, 'created_at' => now(),]))
            ->toArray();

        $permissionIdsByRole = [
            'admin' => $insertPermissions('admin'),
        ];

        foreach ($permissionIdsByRole as $roleName => $permissionIds) {
            $role = Role::whereName($roleName)->first();
            if (!$role) {
                $role = Role::create([
                    'name' => $roleName,
                    'description' => 'Best for business owners and company administrators',
                    'guard_name' => $gardName,
                    'created_at' => now(),
                ]);
            }
            DB::table(config('permission.table_names.role_has_permissions'))
                ->insert(
                    collect($permissionIds)->map(fn($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id,
                    ])->toArray()
                );
            $users = User::where('id', 1)->get();
            foreach ($users as $user) {
                $user->assignRole($role);
                $user->syncPermissions($role->permissions);
            }
        }
    }
}
