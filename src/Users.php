<?php

namespace Src;

use \PDO;

class Users extends Conexion
{

    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $perfil;

    public function __construct()
    {
        parent::__construct();
    }


    //---------------------------------------- CRUD ---------------------------------------------------------------------------
    public function create()
    {
        $q = "insert into users(nombre, apellidos, email, perfil) values(:n, :a, :e, :p)";
        $stmt = self::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->perfil
            ]);
        } catch (\PDOException $ex) {
            die("Error en insert: " . $ex->getMessage());
        }
        self::$conexion = null;
    }
    public function read()
    {
        $q = "select * from users order by id desc";
        $stmt = self::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (\PDOException $ex) {
            die("Error en READ: " . $ex->getMessage());
        }
        self::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update(int $id)
    {
    }
    public function delete(int $id)
    {
        $q = "delete from users where id=:id";
        $stmt = self::$conexion->prepare($q);
        try {
            $stmt->execute([':id' => $id]);
        } catch (\PDOException $ex) {
            die("Error en delete: " . $ex->getMessage());
        }

        parent::$conexion = null;
    }
    //----------------------------------------EXIST ID _____________________________________________________
    public function existeId($id): bool
    {
        $q = "select id from users where id=:id";
        $stmt = self::$conexion->prepare($q);
        try {
            $stmt->execute([':id' => $id]);
        } catch (\PDOException $ex) {
            die("Error en existeId: " . $ex->getMessage());
        }
        return $stmt->rowCount();
        parent::$conexion = null;
    }
    //----------------------------------Crear registros _____________________________________________________
    public function crearUsuarios(int $cant): void
    {
        if ($this->hayUsuarios()) return;
        $faker = \Faker\Factory::create('es_ES');
        for ($i = 0; $i < $cant; $i++) {
            $apellidos = $faker->lastName() . " " . $faker->lastName();
            (new Users)->setNombre($faker->firstName())
                ->setApellidos($apellidos)
                ->setEmail($faker->unique()->email())
                ->setPerfil($faker->randomElement(['Admin', 'Normal']))
                ->create();
        }
    }
    private function hayUsuarios(): bool
    {
        $q = "select id from users";
        $stmt = self::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (\PDOException $ex) {
            die("Error en hayUsuers: " . $ex->getMessage());
        }
        return $stmt->rowCount();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of perfil
     */
    public function getPerfil()
    {
        return $this->perfil;
    }

    /**
     * Set the value of perfil
     *
     * @return  self
     */
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }
}
