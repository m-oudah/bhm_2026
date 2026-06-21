<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Role', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'web']);

        Permission::create(['name' => 'LicenseForms', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-LicenseForms', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-LicenseForm', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-LicenseForm', 'guard_name' => 'web']);
        Permission::create(['name' => 'Show-LicenseForm', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-LicenseForm', 'guard_name' => 'web']);
        Permission::create(['name' => 'FinalConfirmation', 'guard_name' => 'web']);
        Permission::create(['name' => 'LicensePrint', 'guard_name' => 'web']);

        Permission::create(['name' => 'Units', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Units', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Unit', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Unit', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Unit', 'guard_name' => 'web']);

        Permission::create(['name' => 'Floors', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Floors', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Floor', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Floor', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Floor', 'guard_name' => 'web']);

        Permission::create(['name' => 'Owners', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Owners', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Owner', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Owner', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Owner', 'guard_name' => 'web']);
        Permission::create(['name' => 'TransferProperty', 'guard_name' => 'web']);

        Permission::create(['name' => 'Buildings', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Buildings', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Building', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Building', 'guard_name' => 'web']);
        Permission::create(['name' => 'Show-Building', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Building', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Financial', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Organizational', 'guard_name' => 'web']);

        Permission::create(['name' => 'Crafts', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Crafts', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Craft', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Craft', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Craft', 'guard_name' => 'web']);

        Permission::create(['name' => 'Streets', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Streets', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Street', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Street', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Street', 'guard_name' => 'web']);

        Permission::create(['name' => 'Zones', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Zones', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Zone', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Zone', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Zone', 'guard_name' => 'web']);

        Permission::create(['name' => 'Sub-Zones', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Sub-Zones', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Sub-Zone', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Sub-Zone', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Sub-Zone', 'guard_name' => 'web']);

        Permission::create(['name' => 'Users', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-User', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-User', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-User', 'guard_name' => 'web']);

        Permission::create(['name' => 'Subscriptions', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Subscriptions', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Subscription', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Subscription', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Subscription', 'guard_name' => 'web']);

        Permission::create(['name' => 'Clients', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-Clients', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-Client', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-Client', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-Client', 'guard_name' => 'web']);

        Permission::create(['name' => 'BuildingTypes', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-BuildingTypes', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-BuildingType', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-BuildingType', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-BuildingType', 'guard_name' => 'web']);

        Permission::create(['name' => 'Opinions', 'guard_name' => 'web']);
        Permission::create(['name' => 'Legal-Opinions', 'guard_name' => 'web']);
        Permission::create(['name' => 'SurveyDepartment-Opinion', 'guard_name' => 'web']);
        Permission::create(['name' => 'UrbanPlanning-Opinion', 'guard_name' => 'web']);
        Permission::create(['name' => 'WaterDepartment-Opinion', 'guard_name' => 'web']);
        Permission::create(['name' => 'SewerDepartment-Opinion', 'guard_name' => 'web']);
        Permission::create(['name' => 'CollectionDepartment-Opinion', 'guard_name' => 'web']);

        Permission::create(['name' => 'ProofOfCase', 'name_ar' => 'إثبات حالة', 'guard_name' => 'web']);
        Permission::create(['name' => 'Read-ProofOfCase', 'guard_name' => 'web']);
        Permission::create(['name' => 'Create-ProofOfCase', 'guard_name' => 'web']);
        Permission::create(['name' => 'Update-ProofOfCase', 'guard_name' => 'web']);
        Permission::create(['name' => 'Delete-ProofOfCase', 'guard_name' => 'web']);


        Permission::create(['name' => 'Update-RegulatoryDisclosureReport', 'guard_name' => 'web']);
        Permission::create(['name' => 'DepartmentNotes', 'guard_name' => 'web']);
    }
}
