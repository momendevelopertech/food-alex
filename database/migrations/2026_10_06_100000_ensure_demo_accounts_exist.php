<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Enums\Ask;
use App\Enums\Status;
use App\Enums\Role as EnumRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $accounts = [
            [
                'email'        => 'admin@example.com',
                'name'         => 'مدحت (المدير)',
                'phone'        => '0123456789',
                'username'     => 'admin',
                'branch_id'    => 0,
                'role'         => EnumRole::ADMIN,
            ],
            [
                'email'        => 'customer@example.com',
                'name'         => 'عميل تجريبي',
                'phone'        => '01000000001',
                'username'     => 'customer',
                'branch_id'    => 0,
                'role'         => EnumRole::CUSTOMER,
            ],
            [
                'email'        => 'branchmanager@example.com',
                'name'         => 'مدير الفرع',
                'phone'        => '01000000002',
                'username'     => 'branchmanager',
                'branch_id'    => 1,
                'role'         => EnumRole::BRANCH_MANAGER,
            ],
            [
                'email'        => 'posoperator@example.com',
                'name'         => 'مشغل نقطة البيع (POS)',
                'phone'        => '01000000003',
                'username'     => 'posoperator',
                'branch_id'    => 1,
                'role'         => EnumRole::POS_OPERATOR,
            ],
            [
                'email'        => 'chef@example.com',
                'name'         => 'شيف المطبخ',
                'phone'        => '01000000004',
                'username'     => 'chef',
                'branch_id'    => 1,
                'role'         => EnumRole::CHEF,
            ],
            [
                'email'        => 'deliveryboy@example.com',
                'name'         => 'طيار التوصيل',
                'phone'        => '01000000005',
                'username'     => 'deliveryboy',
                'branch_id'    => 1,
                'role'         => EnumRole::DELIVERY_BOY,
            ],
            [
                'email'        => 'waiter@example.com',
                'name'         => 'ويتر الصالة',
                'phone'        => '01000000006',
                'username'     => 'waiter',
                'branch_id'    => 1,
                'role'         => EnumRole::WAITER,
            ],
        ];

        foreach ($accounts as $acc) {
            $user = User::firstOrCreate(
                ['email' => $acc['email']],
                [
                    'name'              => $acc['name'],
                    'phone'             => $acc['phone'],
                    'username'          => $acc['username'],
                    'email_verified_at' => now(),
                    'password'          => bcrypt('123456'),
                    'branch_id'         => $acc['branch_id'],
                    'status'            => Status::ACTIVE,
                    'country_code'      => '+20',
                    'is_guest'          => Ask::NO,
                ]
            );

            // Make sure active & password is set
            $user->status = Status::ACTIVE;
            $user->save();

            if (method_exists($user, 'syncRoles')) {
                $user->syncRoles([$acc['role']]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to delete demo users on rollback
    }
};
