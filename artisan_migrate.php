<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Exécuter la commande migrate
echo "Exécution de la migration...\n";
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArrayInput(['command' => 'migrate', '--force' => true]),
    new Symfony\Component\Console\Output\BufferedOutput
);

echo "Statut de la migration: " . ($status === 0 ? "Réussi" : "Échec") . "\n";

$kernel->terminate($input, $status);