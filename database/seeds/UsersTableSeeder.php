<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(1000)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'wangjian';
        $user->email = 'wangjian@qq.com';
        $user->save();

        $user = User::find(2);
        $user->name = 'wangj';
        $user->email = 'wangj@qq.com';
        $user->save();
    }
}
