<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Setting;

// Créer les paramètres de contact s'ils n'existent pas
$contactSettings = [
    'contact_address' => '123 Rue Principale, Lomé, Togo',
    'contact_email' => 'contact@theelemtours.com',
    'contact_phone' => '+228 90 12 34 56',
    'contact_hours' => 'Lun-Ven: 9h-18h | Sam: 9h-13h'
];

foreach ($contactSettings as $key => $value) {
    try {
        Setting::setValue($key, $value, 'contact', 'string');
        echo "Paramètre '$key' créé ou mis à jour avec succès.\n";
    } catch (\Exception $e) {
        echo "Erreur lors de la création du paramètre '$key': " . $e->getMessage() . "\n";
    }
}

echo "\nTerminé!\n";