<?php

namespace Database\Seeders;

use App\Enums\Ask;
use App\Models\Address;
use App\Enums\Role as EnumRole;
use Dipokhalder\EnvEditor\EnvEditor;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\Status;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envService = new EnvEditor();
        $isDemo     = (bool)($envService->getValue('DEMO') ?: env('DEMO'));

        // 1. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'مدحت (المدير)',
                'phone'             => '0123456789',
                'username'          => 'admin',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 0,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $admin->syncRoles([EnumRole::ADMIN]);

        // 2. Default Walking Customer
        $customer = User::firstOrCreate(
            ['email' => 'walkingcustomer@example.com'],
            [
                'name'              => 'Walking Customer',
                'phone'             => '01000000000',
                'username'          => 'default-customer',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 0,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $customer->syncRoles([EnumRole::CUSTOMER]);

        // 3. Demo Customer (العميل)
        $customerOne = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'              => 'عميل تجريبي',
                'phone'             => '01000000001',
                'username'          => 'customer',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 0,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $customerOne->syncRoles([EnumRole::CUSTOMER]);

        // 4. Demo Branch Manager (مدير الفرع)
        $branchManager = User::firstOrCreate(
            ['email' => 'branchmanager@example.com'],
            [
                'name'              => 'مدير الفرع',
                'phone'             => '01000000002',
                'username'          => 'branchmanager',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 1,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $branchManager->syncRoles([EnumRole::BRANCH_MANAGER]);

        // 5. Demo POS Operator (مشغل نقطة البيع)
        $posOperator = User::firstOrCreate(
            ['email' => 'posoperator@example.com'],
            [
                'name'              => 'مشغل نقطة البيع (POS)',
                'phone'             => '01000000003',
                'username'          => 'posoperator',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 1,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $posOperator->syncRoles([EnumRole::POS_OPERATOR]);

        // 6. Demo Chef (الشيف / المطبخ)
        $chef = User::firstOrCreate(
            ['email' => 'chef@example.com'],
            [
                'name'              => 'شيف المطبخ',
                'phone'             => '01000000004',
                'username'          => 'chef',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 1,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $chef->syncRoles([EnumRole::CHEF]);

        // 7. Delivery Boy
        $deliveryBoy = User::firstOrCreate(
            ['email' => 'deliveryboy@example.com'],
            [
                'name'              => 'طيار التوصيل',
                'phone'             => '01000000005',
                'username'          => 'deliveryboy',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 1,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $deliveryBoy->syncRoles([EnumRole::DELIVERY_BOY]);

        // 8. Waiter
        $waiter = User::firstOrCreate(
            ['email' => 'waiter@example.com'],
            [
                'name'              => 'ويتر الصالة',
                'phone'             => '01000000006',
                'username'          => 'waiter',
                'email_verified_at' => now(),
                'password'          => bcrypt('123456'),
                'branch_id'         => 1,
                'status'            => Status::ACTIVE,
                'country_code'      => '+20',
                'is_guest'          => Ask::NO
            ]
        );
        $waiter->syncRoles([EnumRole::WAITER]);

        if ($isDemo) {
            Address::firstOrCreate([
                'user_id' => $customerOne->id,
                'label'   => 'المنزل',
            ], [
                'address'   => 'الإسكندرية - سموحة',
                'apartment' => 'شقة 12، عمارة 5',
                'latitude'  => '31.2001',
                'longitude' => '29.9187',
            ]);

            Address::firstOrCreate([
                'user_id' => $customerOne->id,
                'label'   => 'العمل',
            ], [
                'address'   => 'الإسكندرية - محطة الرمل',
                'apartment' => 'مكتب 402',
                'latitude'  => '31.1985',
                'longitude' => '29.9015',
            ]);
        }
    }
}