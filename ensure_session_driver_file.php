<?php
$envPath = __DIR__.'/.env';
if (!file_exists($envPath)) {
	echo ".env introuvable\n";
	exit(1);
}
$env = file_get_contents($envPath);
if ($env === false) {
	echo "Lecture .env échouée\n";
	exit(1);
}
if (preg_match('/^SESSION_DRIVER=.*/m', $env)) {
	$env = preg_replace('/^SESSION_DRIVER=.*/m', 'SESSION_DRIVER=file', $env);
	$action = 'modifié';
} else {
	$env .= "\nSESSION_DRIVER=file\n";
	$action = 'ajouté';
}
if (file_put_contents($envPath, $env) === false) {
	echo "Écriture .env échouée\n";
	exit(1);
}
echo "SESSION_DRIVER=file ($action) dans .env\n"; 