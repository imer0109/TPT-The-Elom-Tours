<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

echo "Bootstrapped.\n";

$email = 'admin@elomtours.com';
$password = 'password';

$user = User::where('email', $email)->first();
if (!$user) {
	$user = new User();
	$user->name = 'Admin';
	$user->email = $email;
	$user->password = Hash::make($password);
	$user->save();
	echo "User created: {$user->email}\n";
} else {
	$user->password = Hash::make($password);
	$user->save();
	echo "User updated (password reset): {$user->email}\n";
}

$role = Role::where('name', 'Super Administrateur')->first();
if ($role) {
	$user->roles()->syncWithoutDetaching([$role->id]);
	echo "Role attached: {$role->name}\n";
} else {
	echo "Role 'Super Administrateur' not found.\n";
}

echo "Done.\n"; 