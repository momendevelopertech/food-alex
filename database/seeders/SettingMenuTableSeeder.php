<?php

namespace Database\Seeders;


use App\Models\SettingMenu;
use App\Enums\Status;
use Illuminate\Database\Seeder;

class SettingMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        SettingMenu::truncate();
        $menus = [
            [
                'name'       => 'Company',
                'language'   => 'company',
                'url'        => 'company',
                'icon'       => 'lab lab-company',
                'priority'   => 1000,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Site',
                'language'   => 'site',
                'url'        => 'site',
                'icon'       => 'lab lab-site',
                'priority'   => 995,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Branches',
                'language'   => 'branches',
                'url'        => 'branches',
                'icon'       => 'lab lab-branches',
                'priority'   => 990,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Kiosk Machines',
                'language'   => 'kiosk_machines',
                'url'        => 'kiosk-machines',
                'icon'       => 'lab lab-kiosk',
                'priority'   => 985,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Mail',
                'language'   => 'mail',
                'url'        => 'mail',
                'icon'       => 'lab lab-mail',
                'priority'   => 980,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Order Setup',
                'language'   => 'order_setup',
                'url'        => 'order-setup',
                'icon'       => 'lab lab-order-setup',
                'priority'   => 975,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'OTP',
                'language'   => 'otp',
                'url'        => 'otp',
                'icon'       => 'lab lab-otp',
                'priority'   => 970,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Notification',
                'language'   => 'notification',
                'url'        => 'notification',
                'icon'       => 'lab lab-notification',
                'priority'   => 965,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Notification Alert',
                'language'   => 'notification_alert',
                'url'        => 'notification-alert',
                'icon'       => 'lab lab-license',
                'priority'   => 960,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Social Media',
                'language'   => 'social_media',
                'url'        => 'social-media',
                'icon'       => 'lab lab-social-media',
                'priority'   => 955,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Cookies',
                'language'   => 'cookies',
                'url'        => 'cookies',
                'icon'       => 'lab lab-cookies',
                'priority'   => 950,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Analytics',
                'language'   => 'analytics',
                'url'        => 'analytics',
                'icon'       => 'lab lab-analytics',
                'priority'   => 945,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Theme',
                'language'   => 'theme',
                'url'        => 'theme',
                'icon'       => 'lab lab-theme',
                'priority'   => 940,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Time Slots',
                'language'   => 'time_slots',
                'url'        => 'time-slots',
                'icon'       => 'lab lab-time-slots',
                'priority'   => 935,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Sliders',
                'language'   => 'sliders',
                'url'        => 'sliders',
                'icon'       => 'lab lab-sliders',
                'priority'   => 930,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Currencies',
                'language'   => 'currencies',
                'url'        => 'currencies',
                'icon'       => 'lab lab-currencies',
                'priority'   => 925,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Item Categories',
                'language'   => 'item_categories',
                'url'        => 'item-categories',
                'icon'       => 'lab lab-item-categories',
                'priority'   => 920,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Item Attributes',
                'language'   => 'item_attributes',
                'url'        => 'item-attributes',
                'icon'       => 'lab lab-item-attributes',
                'priority'   => 915,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Taxes',
                'language'   => 'taxes',
                'url'        => 'taxes',
                'icon'       => 'lab lab-taxes',
                'priority'   => 910,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Pages',
                'language'   => 'pages',
                'url'        => 'pages',
                'icon'       => 'lab lab-pages',
                'priority'   => 905,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Role Permissions',
                'language'   => 'role_permissions',
                'url'        => 'role',
                'icon'       => 'lab lab-role-permissions',
                'priority'   => 900,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Languages',
                'language'   => 'languages',
                'url'        => 'languages',
                'icon'       => 'lab lab-languages',
                'priority'   => 895,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'AI Agent',
                'language'   => 'ai_agent',
                'url'        => 'ai-agent',
                'icon'       => 'lab lab-line-ai-agent',
                'priority'   => 890,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'SMS Gateway',
                'language'   => 'sms_gateway',
                'url'        => 'sms-gateway',
                'icon'       => 'lab lab-sms',
                'priority'   => 885,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Payment Gateway',
                'language'   => 'payment_gateway',
                'url'        => 'payment-gateway',
                'icon'       => 'lab lab-payment-gateway',
                'priority'   => 880,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'Social Login',
                'language'   => 'social_login',
                'url'        => 'social-login',
                'icon'       => 'lab lab-social-media',
                'priority'   => 875,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'       => 'License',
                'language'   => 'license',
                'url'        => 'license',
                'icon'       => 'lab lab-license',
                'priority'   => 870,
                'status'     => Status::ACTIVE,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        SettingMenu::insert($menus);
    }
}
