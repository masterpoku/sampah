<?php

namespace App\Actions\Fortify;

use App\Models\Devices;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'id_device' => ['unique:users'],
        ])->validate();


         $data1 = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => 2,
            'id_device' => Str::random(8),
            'is_active' => 0,
            'profile_photo_path' => '/user/default_image.png',
        ];
        $user = User::create($data1);
        $id = DB::getPdo()->lastInsertId();
           $data2 = [
                'id_user'   => $id,
                'nama_devices' => 'Device_'.$input['name'],
                'mode'  => 0,
                'keterangan' => 'Device Utama',
                'publish' => 0,
           ];
        $devices = DB::table('devices')->insert($data2);
        return $user;

    }
}
