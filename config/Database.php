<?php

/*
*   https://www.php.net/manual/pt_BR/pdo.construct.php
*   https://www.php.net/manual/en/pdo.constants.php
*/ 
class Database
{
    private static ?PDO $pdo = null;
  
    public static function connect(): PDO
    {
        if (is_null(self::$pdo)) {
            self::createPDO();
        }

        return self::$pdo;
    }
  
    private static function createPDO(): void
    {
        try{
            self::$pdo = new PDO(
                dsn: self::dsn(),
                username: self::env('DB_USER'),
                password: self::env('DB_PASSWORD'),
                options: [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException("Connection failed: " . $e->getMessage());
        } 
    }

    private static function dsn(): string
    {
        return sprintf(
            "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
            self::env('DB_HOST'),
            self::env('DB_PORT'),
            self::env('DB_DATABASE')
        );
    }

    private static function env(string $key): string
    {
        $value = getenv($key);

        if ($value === false || $value === '') {
            throw new RuntimeException("Missing env var: $key");
        }

        return $value;
    }
}