<?php
namespace App\Table;

use App\Table\Exception\NotFoundException;
use PDO;

 abstract class Table {

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct( PDO $pdo )
    {
        if( $this->table === null )
        {

            throw new \Exception("SB: following class " . get_class($this) ." does not have any prop \$table");
        }
        if($this->class === null)
        {
            throw new \Exception("SB: following class " . get_class($this) ."  does not have any prop \$class");
        }
        $this->pdo = $pdo;   
    }

    public function find( int $id )
   
    { 
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id= :id');
        $query->execute(['id' => $id ]);
        $query->setFetchMode( PDO::FETCH_CLASS, $this->class );
        $result = $query->fetch();

        if($result === false)
        {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Check if value exists in table
     * @param string $field Champ à rechercher
     * @param mixed $value Valeur associée au champ
     */
    public function exists(string $field, $value, $except = null): bool
    {
        $sql = "SELECT COUNT('id') FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if($except !== null)
        {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    public function delete(int $id )
    {
        $query  = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if($ok === false)
        {
            throw new \Exception("SB: impossible to delete post $id in following table {$this->post}");
        }
    }

    public function create(array $data): int
    {
        $sqlFields = [];
        //$key = field name, $value = associated value
        foreach($data as $key => $value)
        {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields));
        $ok = $query->execute($data);

        if($ok === false)
        {
            throw new \Exception("SB: impossible to delete $id in following table {$this->post}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data, int $id)
    {
        $sqlFields = [];

        foreach($data as $key => $value)
        {
            /**
             * eg: name = :name;
             */
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id = :id");

        // on fait comme pour create mais on merge une entrée id
        $ok = $query->execute( array_merge( $data, ['id' => $id] ));

        if($ok === false)
        {
            throw new \Exception("Impossible to edit cat  $id in following table {$this->post}");
        }
    }

    public function queryAndFetchAll(string $sql): array
    {
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }
 }