<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GeneralTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->truncate();
        $getSuperAdminId = DB::table('role')->insertGetId([
            'name' => 'Super Admin'
        ]);

        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role_id' => $getSuperAdminId,
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('account_number')->truncate();
        $list_account_numbers = [
            0 => ['name' => 'Kas', 'code' => '1000'],
            1 => ['name' => 'Bank', 'code' => '1010'],
            2 => ['name' => 'Hutang Dagang', 'code' => '2000'],
            3 => ['name' => 'Piutang Dagang', 'code' => '3000'],
            4 => ['name' => 'Penjualan', 'code' => '4000'],
            5 => ['name' => 'Pembelian', 'code' => '5000'],
            6 => ['name' => 'Biaya Operasional', 'code' => '6000']
        ];
        $get_account_numbers = [];
        foreach ($list_account_numbers as $index => $list) {
            $getId = DB::table('account_number')->insertGetId([
                'name' => $list['name'],
                'code' => $list['code'],
                'orders' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $get_account_numbers[$index] = $getId;
        }

        DB::table('sale_type')->truncate();
        foreach ([
            ['d' => 0, 'c' => 4, 'name' => 'Sale Cash'],
            ['d' => 1, 'c' => 4, 'name' => 'Sale Bank'],
            ['d' => 3, 'c' => 4, 'name' => 'Sale Debt']
                 ] as $index => $list) {
            DB::table('sale_type')->insert([
                'account_number_debit' => isset($get_account_numbers[$list['d']]) ? $get_account_numbers[$list['d']] : 0,
                'account_number_credit' => isset($get_account_numbers[$list['c']]) ? $get_account_numbers[$list['c']] : 0,
                'name' => isset($list['name']) ? $list['name'] : '',
                'orders' => $index + 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('purchase_type')->truncate();
        foreach ([
            ['d' => 0, 'c' => 5, 'name' => 'Purchase Cash'],
            ['d' => 1, 'c' => 5, 'name' => 'Purchase Bank'],
            ['d' => 2, 'c' => 5, 'name' => 'Purchase Debt']
                 ] as $index => $list) {
            DB::table('purchase_type')->insert([
                'account_number_debit' => isset($get_account_numbers[$list['d']]) ? $get_account_numbers[$list['d']] : 0,
                'account_number_credit' => isset($get_account_numbers[$list['c']]) ? $get_account_numbers[$list['c']] : 0,
                'name' => isset($list['name']) ? $list['name'] : '',
                'orders' => $index + 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('settings')->truncate();
        foreach ([
                     ['key'=>'enable_sale','name'=>'Enable Sale','type'=>'select','value'=>1],
                     ['key'=>'enable_purchase','name'=>'Enable Purchase','type'=>'select','value'=>1],
                     ['key'=>'enable_journal','name'=>'Enable Journal','type'=>'select','value'=>1],
                 ] as $index => $list) {
            DB::table('settings')->insert([
                'key' => $list['key'],
                'name' => $list['name'],
                'type' => $list['type'],
                'value' => $list['value'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
