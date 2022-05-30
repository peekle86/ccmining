<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'currency_create',
            ],
            [
                'id'    => 18,
                'title' => 'currency_edit',
            ],
            [
                'id'    => 19,
                'title' => 'currency_show',
            ],
            [
                'id'    => 20,
                'title' => 'currency_delete',
            ],
            [
                'id'    => 21,
                'title' => 'currency_access',
            ],
            [
                'id'    => 22,
                'title' => 'balance_create',
            ],
            [
                'id'    => 23,
                'title' => 'balance_edit',
            ],
            [
                'id'    => 24,
                'title' => 'balance_show',
            ],
            [
                'id'    => 25,
                'title' => 'balance_delete',
            ],
            [
                'id'    => 26,
                'title' => 'balance_access',
            ],
            [
                'id'    => 27,
                'title' => 'hardware_type_create',
            ],
            [
                'id'    => 28,
                'title' => 'hardware_type_edit',
            ],
            [
                'id'    => 29,
                'title' => 'hardware_type_show',
            ],
            [
                'id'    => 30,
                'title' => 'hardware_type_delete',
            ],
            [
                'id'    => 31,
                'title' => 'hardware_type_access',
            ],
            [
                'id'    => 32,
                'title' => 'hardware_access',
            ],
            [
                'id'    => 33,
                'title' => 'hardware_item_create',
            ],
            [
                'id'    => 34,
                'title' => 'hardware_item_edit',
            ],
            [
                'id'    => 35,
                'title' => 'hardware_item_show',
            ],
            [
                'id'    => 36,
                'title' => 'hardware_item_delete',
            ],
            [
                'id'    => 37,
                'title' => 'hardware_item_access',
            ],
            [
                'id'    => 38,
                'title' => 'contract_create',
            ],
            [
                'id'    => 39,
                'title' => 'contract_edit',
            ],
            [
                'id'    => 40,
                'title' => 'contract_show',
            ],
            [
                'id'    => 41,
                'title' => 'contract_delete',
            ],
            [
                'id'    => 42,
                'title' => 'contract_access',
            ],
            [
                'id'    => 43,
                'title' => 'transaction_create',
            ],
            [
                'id'    => 44,
                'title' => 'transaction_edit',
            ],
            [
                'id'    => 45,
                'title' => 'transaction_show',
            ],
            [
                'id'    => 46,
                'title' => 'transaction_delete',
            ],
            [
                'id'    => 47,
                'title' => 'transaction_access',
            ],
            [
                'id'    => 48,
                'title' => 'contract_management_access',
            ],
            [
                'id'    => 49,
                'title' => 'contract_period_create',
            ],
            [
                'id'    => 50,
                'title' => 'contract_period_edit',
            ],
            [
                'id'    => 51,
                'title' => 'contract_period_show',
            ],
            [
                'id'    => 52,
                'title' => 'contract_period_delete',
            ],
            [
                'id'    => 53,
                'title' => 'contract_period_access',
            ],
            [
                'id'    => 54,
                'title' => 'user_statistic_create',
            ],
            [
                'id'    => 55,
                'title' => 'user_statistic_edit',
            ],
            [
                'id'    => 56,
                'title' => 'user_statistic_show',
            ],
            [
                'id'    => 57,
                'title' => 'user_statistic_delete',
            ],
            [
                'id'    => 58,
                'title' => 'user_statistic_access',
            ],
            [
                'id'    => 59,
                'title' => 'message_create',
            ],
            [
                'id'    => 60,
                'title' => 'message_edit',
            ],
            [
                'id'    => 61,
                'title' => 'message_show',
            ],
            [
                'id'    => 62,
                'title' => 'message_delete',
            ],
            [
                'id'    => 63,
                'title' => 'message_access',
            ],
            [
                'id'    => 64,
                'title' => 'faq_create',
            ],
            [
                'id'    => 65,
                'title' => 'faq_edit',
            ],
            [
                'id'    => 66,
                'title' => 'faq_show',
            ],
            [
                'id'    => 67,
                'title' => 'faq_delete',
            ],
            [
                'id'    => 68,
                'title' => 'faq_access',
            ],
            [
                'id'    => 69,
                'title' => 'setting_create',
            ],
            [
                'id'    => 70,
                'title' => 'setting_edit',
            ],
            [
                'id'    => 71,
                'title' => 'setting_show',
            ],
            [
                'id'    => 72,
                'title' => 'setting_delete',
            ],
            [
                'id'    => 73,
                'title' => 'setting_access',
            ],
            [
                'id'    => 74,
                'title' => 'contact_create',
            ],
            [
                'id'    => 75,
                'title' => 'contact_edit',
            ],
            [
                'id'    => 76,
                'title' => 'contact_show',
            ],
            [
                'id'    => 77,
                'title' => 'contact_delete',
            ],
            [
                'id'    => 78,
                'title' => 'contact_access',
            ],
            [
                'id'    => 79,
                'title' => 'support_access',
            ],
            [
                'id'    => 80,
                'title' => 'chat_create',
            ],
            [
                'id'    => 81,
                'title' => 'chat_edit',
            ],
            [
                'id'    => 82,
                'title' => 'chat_show',
            ],
            [
                'id'    => 83,
                'title' => 'chat_delete',
            ],
            [
                'id'    => 84,
                'title' => 'chat_access',
            ],
            [
                'id'    => 85,
                'title' => 'withdrawl_create',
            ],
            [
                'id'    => 86,
                'title' => 'withdrawl_edit',
            ],
            [
                'id'    => 87,
                'title' => 'withdrawl_show',
            ],
            [
                'id'    => 88,
                'title' => 'withdrawl_delete',
            ],
            [
                'id'    => 89,
                'title' => 'withdrawl_access',
            ],
            [
                'id'    => 90,
                'title' => 'transaction_management_access',
            ],
            [
                'id'    => 91,
                'title' => 'landing_page_create',
            ],
            [
                'id'    => 92,
                'title' => 'landing_page_edit',
            ],
            [
                'id'    => 93,
                'title' => 'landing_page_show',
            ],
            [
                'id'    => 94,
                'title' => 'landing_page_delete',
            ],
            [
                'id'    => 95,
                'title' => 'landing_page_access',
            ],
            [
                'id'    => 96,
                'title' => 'wallet_create',
            ],
            [
                'id'    => 97,
                'title' => 'wallet_edit',
            ],
            [
                'id'    => 98,
                'title' => 'wallet_show',
            ],
            [
                'id'    => 99,
                'title' => 'wallet_delete',
            ],
            [
                'id'    => 100,
                'title' => 'wallet_access',
            ],
            [
                'id'    => 101,
                'title' => 'cart_create',
            ],
            [
                'id'    => 102,
                'title' => 'cart_edit',
            ],
            [
                'id'    => 103,
                'title' => 'cart_show',
            ],
            [
                'id'    => 104,
                'title' => 'cart_delete',
            ],
            [
                'id'    => 105,
                'title' => 'cart_access',
            ],
            [
                'id'    => 106,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
