<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Email del usuario
$email = 'mashsport24@gmail.com';

// Obtener la nueva contraseña desde argumentos de línea de comandos o solicitar
$newPassword = $argv[1] ?? null;

if (!$newPassword) {
  echo "Script para cambiar contraseña del usuario: {$email}\n";
  echo "==========================================\n\n";
  echo "Por favor, ingresa la nueva contraseña: ";
  $newPassword = trim(fgets(STDIN));

  if (empty($newPassword)) {
    echo "Error: La contraseña no puede estar vacía.\n";
    exit(1);
  }

  echo "Confirma la contraseña: ";
  $confirmPassword = trim(fgets(STDIN));

  if ($newPassword !== $confirmPassword) {
    echo "Error: Las contraseñas no coinciden.\n";
    exit(1);
  }
}

echo "\nBuscando usuario con email: {$email}\n";
echo "=====================================\n\n";

// Buscar el usuario
$user = User::where('email', $email)->first();

if (!$user) {
  echo "Error: No se encontró ningún usuario con el email: {$email}\n";
  exit(1);
}

echo "Usuario encontrado:\n";
echo "  ID: {$user->id}\n";
echo "  Nombre: {$user->firstName} {$user->lastName}\n";
echo "  Email: {$user->email}\n";
echo "  Teléfono: {$user->phone}\n";
echo "\n";

// Cambiar la contraseña
$user->password = Hash::make($newPassword);
$user->save();

echo "✓ Contraseña actualizada exitosamente.\n";
echo "\nLa nueva contraseña ha sido configurada para el usuario: {$email}\n";
