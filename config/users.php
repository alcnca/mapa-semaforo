<?php
// config/users.php

// Genera hashes una vez con: php -r "echo password_hash('TuPass', PASSWORD_DEFAULT).PHP_EOL;"
return [
  // Coordinador (tú)
  'ALCNCA' => [
    'role' => 'COORD',
    'sucursal' => null,
    'hash' => '$2y$10$REEMPLAZA_CON_TU_HASH'
  ],

  // Usuarios por sucursal (ejemplos)
  'VALLADOLID' => [
    'role' => 'BRANCH',
    'sucursal' => 'VALLADOLID',
    'hash' => '$2y$10$REEMPLAZA_CON_TU_HASH'
  ],
  'IZAMAL' => [
    'role' => 'BRANCH',
    'sucursal' => 'IZAMAL',
    'hash' => '$2y$10$REEMPLAZA_CON_TU_HASH'
  ],
  // Agrega las demás sucursales de tu coordinación...
];
