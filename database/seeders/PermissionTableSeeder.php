<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'Invoices',
            'Iinvoices list',
            'Paid invoices',
            'partilly paid invoices',
            'Unpaid invoices',
            'Artiched invoices',
            'Deleted invoices',
            'Report',
            'Invoices report',
            'Customer report',
            'Users',
            'Users list',
            'Roles users',
            'Sittings',
            'Branchs',
            'Sections',


            'Add invoice',
            'Delete invoice',
            'Export EXCEL',
            'Change paid status',
            'Modify invoice',
            'Archive invoice',
            'Print invoice',
            'Add Attachment',
            'Delete Attachment',

            'Add user',
            'Modify user',
            'Delete user',

            'Show roles',
            'Add roles',
            'Modify roles',
            'Delete roles',

            'Add Branch',
            'Modify branch',
            'Delete Branch',

            'Add Section',
            'Modify Section',
            'Delete Section',
            'Notification',

    ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
