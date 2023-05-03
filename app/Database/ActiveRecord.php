<?php

declare(strict_types=1);

namespace App\Database;

class ActiveRecord
{
    protected static string $table;
    protected static string $primaryKey = 'id';
    protected array $attributes = [];
    private array $fields = [];

    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    public function __get(string $name): mixed
    {
        return isset($this->fields[$name]) ? $this->fields[$name] : null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->fields[$name] = $value;
    }

    public function fill(array $data): void
    {
        foreach ($this->attributes as $key => $attribute) {
            if (isset($data[$attribute])) {
                $this->$attribute = $data[$attribute];
            }
            unset($this->fields[$key]);
        }
    }

    public static function find(string|int $id)
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        $values = (new QueryBuilder($table))->where($primaryKey, $id)->get()[0];

        return new static($values);
    }

    public static function all(): array
    {
        $table = static::$table;

        $result = (new QueryBuilder($table))->select()->get();

        $items = array_map(function ($item) {
            return new static($item);
        }, $result);

        return $items;
    }

    public function insert(array $data = []): string|false
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        $fields = !empty($data) ? $data : $this->fields;
        
        unset($fields[$primaryKey]);

        $insertId = (new QueryBuilder($table))->insert($fields);

        $this->fields[$primaryKey] = $insertId;

        return $insertId;
    }

    public function update(array $data = [], ?int $id = null): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;
        
        $fields = !empty($data) ? $data : $this->fields;
        $id = !is_null($id) ? $id : $fields[$primaryKey];

        unset($fields[$primaryKey]);

        return (new QueryBuilder($table))->where($primaryKey, $id)->update($fields);
    }

    public function delete(?int $id = null): bool
    {
        $table = static::$table;
        $primaryKey = static::$primaryKey;

        $id = !is_null($id) ? $id : $this->fields[$primaryKey];

        return (new QueryBuilder($table))->where($primaryKey, $id)->delete();
    }
}
