<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\Role;

class AdminRoles extends Migration
{

    public function up()
    {
        Schema::dropIfExists('role');
        Schema::create('role', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 50);
            $table->enum('status', ['active', 'inactive', 'deleted'])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });

        // Seed table

        $roles = [
            ['User'],
            ['Premium'],
            ['Admin'],
            ['Super'],
            ['Monitor']
        ];

        DB::table('role')->delete();
        foreach ($roles as $role)
        {
            Role::create([
                'title' => $role[0]
            ]);
        }

        // Update user table

        Schema::table('users', function(Blueprint $table)
        {
            $table->integer('role_id')->unsigned()->default(1)->after('id');
            $table->foreign('role_id')->references('id')->on('role');
        });

        // Seed admin user

        if(is_null(User::find(1)))
        {
            $adminUser = new User();
            $adminUser->role_id = 4;
            $adminUser->email = 'super@' . config('admin.domain');
            $adminUser->name = 'Super admin';
            $adminUser->password = \Hash::make('tejuino');
            $adminUser->save();
        }
    }

    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropForeign('users_role_id_foreign');
            $table->dropColumn(['role_id']);
        });

        Schema::dropIfExists('role');
    }

}
