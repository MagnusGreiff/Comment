<?php

namespace Anax\Database;

use \Anax\Database\DatabaseQueryBuilder;
use \Anax\Database\Exception\ActiveRecordException;

/**
 * An implementation of the Active Record pattern to be used as
 * base class for database driven models.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ActiveRecordModel
{
    /**
     * @var DatabaseQueryBuilder $db the object for persistent
     *                               storage.
     */
    protected $db = null;

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = null;



    /**
     * Set the database object to use for accessing storage.
     *
     * @param DatabaseQueryBuilder $db as database access object.
     *
     * @return void
     */
    public function setDb(DatabaseQueryBuilder $db)
    {
        $this->db = $db;
    }



    /**
     * Check if database is injected or throw an exception.
     *
     * @throws ActiveRecordException when database is not set.
     *
     * @return void
     */
    protected function checkDb()
    {
        if (!$this->db) {
            throw new ActiveRecordException("Missing \$db, did you forget to inject/set is?");
        }
    }



    /**
     * Get essential object properties.
     *
     * @return array with object properties.
     */
    protected function getProperties()
    {
        $properties = get_object_vars($this);
        unset($properties['tableName']);
        unset($properties['db']);
        unset($properties['di']);
        return $properties;
    }



    /**
     * Find and return first object found by search criteria and use
     * its data to populate this instance.
     *
     * @param string $column to use in where statement.
     * @param mixed  $value  to use in where statement.
     *
     * @return this
     */
    public function find($column, $value)
    {
        return $this->findWhere("$column = ?", $value);
    }



    /**
     * Find and return first object by its tableIdColumn and use
     * its data to populate this instance.
     *
     * @param integer $id to find or use $this->{$this->tableIdColumn}
     *                    as default.
     *
     * @return this
     */
    public function findById($id = null)
    {
        $id = $id ?: $this->{$this->tableIdColumn};
        return $this->findWhere("{$this->tableIdColumn} = ?", $id);
    }



    /**
     * Find and return first object found by search criteria and use
     * its data to populate this instance.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id1 = ? and id2 = ?`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return this
     */
    public function findWhere($where, $value)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where($where)
                        ->execute($params)
                        ->fetchInto($this);
    }



    /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAll()
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }



    public function findAllLimitOrderBy($order, $number)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->orderBy($order)
                        ->limit($number)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }

    public function findAllLimit($number)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->limit($number)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }




    /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function findAllWhere($where, $value)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where($where)
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


    /**
     * Execute rawsql
     *
     * @return array
     */
    public function findAllSql($sql, $params = [])
    {
        $this->checkDb();
        return $this->db->connect()
                        ->execute($sql, $params)
                        ->fetchAllClass(get_class($this));
    }


    public function next()
    {
        return $this->db->next();
    }


    /**
     * Execute rawsql
     *
     * @return array
     */
    public function findAllSqlTest($sql, $params)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->executeFetchAll($sql, $params);
    }



    /**
     * Save current object/row, insert if id is missing and do an
     * update if the id exists.
     *
     * @return void
     */
    public function save($idName = null, $id = null)
    {
        if (isset($this->id)) {
            return $this->update();
        } elseif ($idName !== null) {
            return $this->update($idName, $id);
        }

        return $this->create();
    }



    /**
     * Create new row.
     *
     * @return void
     */
    protected function create()
    {
        $this->checkDb();
        $properties = $this->getProperties();
        unset($properties['id']);
        $columns = array_keys($properties);
        $values  = array_values($properties);

        $this->db->connect()
                 ->insert($this->tableName, $columns)
                 ->execute($values);

        $this->id = $this->db->lastInsertId();
    }



    /**
     * Update row.
     *
     * @return void
     */
    protected function update($idName = null, $id = null)
    {
        $this->checkDb();
        $properties = $this->getProperties();
        unset($properties['id']);
        $columns = array_keys($properties);
        $values  = array_values($properties);
        $values[] = isset($this->id) ? $this->id : $id ;
        $setId = $idName !== null ? $idName : "id";

        $this->db->connect()
                 ->update($this->tableName, $columns)
                 ->where("$setId = ?")
                 ->execute($values);
    }



    /**
     * Delete row.
     *
     * @param integer $id to delete or use $this->id as default.
     *
     * @return void
     */
    public function delete($idName = null, $id = null)
    {
        $this->checkDb();
        $id = $id ?: $this->id;
        $setId = $idName !== null ? $idName : "id";

        $this->db->connect()
                 ->deleteFrom($this->tableName)
                 ->where("$setId = ?")
                 ->execute([$id]);

        $this->id = null;
    }


    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
