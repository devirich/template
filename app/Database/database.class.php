<?php

namespace App\Database;

use PDO;
use PDOException;

class DB
{
    private $host = "localhost";
    private $dbname = "test";
    private $user = "root";
    private $password = "";

    private $where = null ?? [];
    private $toSql = null;
    private $bind = [];
    private $leftJoin = null ?? [];
    private $innerJoin = null ?? [];
    private $orderBy = null ?? "";
    private $groupBy = null ?? "";
    private $limit = null;
    private $error = null;
    private $result = null;
    private $countResult = null;

    public function __construct()
    {
        $this->connect();
    }

    protected function connect()
    {
        $dsn = "mysql:host = $this->host; dbname = $this->dbname; charset = utf8";
        try {
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->exec("SET NAMES utf8");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            date_default_timezone_set('Asia/Bangkok');
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function setTable()
    {
        return $this->dbname . '.';
    }

    public function limit($number)
    {
        $this->limit = " LIMIT $number";
        return $this;
    }

    public function where($field, $operator = "=", $value = "")
    {
        if ($value == "") {
            $value = $operator;
            $operator = "=";
        }
        $this->where[] = [
            $field,
            $operator,
            $value
        ];
        return $this;
    }

    private function setWhere()
    {
        $res_where = "";

        foreach ($this->where as $key => $value) {
            $bind_item = [];
            $bind_key = (strpos($value[0], '.') !== false) ? ":" . explode('.', $value[0])[1] : ":" . $value[0];
            if ($value[2] == "") {
                $bind_key = "\"\"";
            } else {
                $bind_item[str_replace(":", "", $bind_key)] = $value[2];
            }
            if ($key == 0) {
                $res_where .= " WHERE ";
                $res_where .= $value[0] . " " . $value[1] .  $bind_key;
            } else {
                $res_where .= " AND ";
                $res_where .= $value[0] . " " . $value[1] . $bind_key;
            }

            $this->bind = array_merge($this->bind, $bind_item);
        }

        return $res_where;
    }

    public function leftJoin($table, $onLeft, $operator, $onRight)
    {
        $this->leftJoin[] = [
            $this->setTable() . $table,
            $onLeft,
            $operator,
            $onRight
        ];
        return $this;
    }

    private function setLeftJoin()
    {
        $res_leftJoin = "";
        if ($this->leftJoin != null) {
            $res_leftJoin .= " LEFT JOIN ";
            foreach ($this->leftJoin as $key => $value) {
                if ($key == 0) {
                    $res_leftJoin .= "{$value[0]} ON ({$value[1]} {$value[2]} {$value[3]})";
                } else {
                    $res_leftJoin .= " LEFT JOIN {$value[0]} ON ({$value[1]} {$value[2]} {$value[3]})";
                }
            }
        }
        return $res_leftJoin;
    }

    public function innerJoin($table, $onLeft, $operator, $onRight)
    {
        $this->innerJoin[] = [
            $this->setTable() . $table,
            $onLeft,
            $operator,
            $onRight
        ];
        return $this;
    }

    private function setInnerJoin()
    {
        $res_innerJoin = "";
        if ($this->leftJoin != null) {
            $res_innerJoin .= " INNER JOIN ";
            foreach ($this->leftJoin as $key => $value) {
                if ($key == 0) {
                    $res_innerJoin .= "{$value[0]} ON ({$value[1]} {$value[2]} {$value[3]})";
                } else {
                    $res_innerJoin .= " INNER JOIN {$value[0]} ON ({$value[1]} {$value[2]} {$value[3]})";
                }
            }
        }
        return $res_innerJoin;
    }

    private function setOrderBy()
    {
        $res_orderBy = "";
        if ($this->orderBy != null) {
            $res_orderBy = " {$this->orderBy}";
        }
        return $res_orderBy;
    }

    public function orderBy($field, $order = "ASC")
    {
        $this->orderBy = "ORDER BY $field $order";
        return $this;
    }

    private function setGroupBy()
    {
        $res_groupBy = "";
        if ($this->groupBy != null) {
            $res_groupBy = " {$this->groupBy}";
        }
        return $res_groupBy;
    }

    public function groupBy($field)
    {
        $this->groupBy = "GROUP BY $field";
        return $this;
    }

    public function getSQL($fields = "*", $tablename = "")
    {
        $this->toSql =  "SELECT $fields FROM " . $this->setTable() . $tablename . $this->setLeftJoin() . $this->setInnerJoin() . $this->setWhere() . $this->setGroupBy()  . $this->setOrderBy() . $this->limit;
        try {
            $stmt = $this->connect()->prepare($this->toSql);
            $stmt->execute($this->bind);
            $this->countResult = $stmt->rowCount();
            if ($this->countResult > 0) {
                $this->result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $this->result = null;
            }
            $this->error = null;
            return $this->result;
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function readSQL($fields = "*", $tablename = "")
    {
        $this->toSql =  "SELECT $fields FROM " . $this->setTable() . $tablename . $this->setLeftJoin() . $this->setInnerJoin() . $this->setWhere();
        try {
            $stmt = $this->connect()->prepare($this->toSql);
            $stmt->execute($this->bind);
            $this->countResult = $stmt->rowCount();
            if ($this->countResult > 0) {
                $this->result = $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                $this->result = null;
            }
            $this->error = null;
            return $this->result;
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function get($fields = "*", $tablename = "", $where = "")
    {
        try {

            $sql = "SELECT $fields FROM " . $this->setTable() . "$tablename $where";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function read($fields = "*", $tablename = "", $where = "")
    {
        try {
            $sql = "SELECT $fields FROM " . $this->setTable() . "$tablename $where";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $this->result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertSQL($tablename = "", $values = array())
    {
        try {
            foreach ($values as $k => $v) {
                $ins[] = ':' . $k;
            }
            $val = implode(', ', $ins);
            $value = implode(', ', array_keys($values));
            $sql = "INSERT INTO " . $this->setTable() . "$tablename($value) VALUES($val)";
            $stmt = $this->connect()->prepare($sql);
            foreach ($values as $k => $v) {
                $stmt->bindParam(":$k", $v);
            }
            $stmt->execute($values);
            return $stmt;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function updateSQL($tablename = "", $values = array())
    {
        try {
            foreach ($values as $k => $v) {
                $param[] = $k . ' = :' . $k;
            }
            $val = implode(', ', $param);
            $sql = "UPDATE " . $this->setTable() . "$tablename SET $val " . $this->setWhere();
            $stmt = $this->connect()->prepare($sql);
            foreach ($values as $k => $v) {
                $stmt->bindParam(":$k", $v);
            }
            $paraam = array_merge($this->bind, $values);
            if ($stmt->execute($paraam)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
            return false;
        }
    }

    public function update($tablename = "", $values = array(), $where = "")
    {
        try {
            foreach ($values as $k => $v) {
                $param[] = $k . ' = :' . $k;
            }
            $val = implode(', ', $param);
            $sql = "UPDATE " . $this->setTable() . "$tablename SET $val " . $where;
            $stmt = $this->connect()->prepare($sql);
            foreach ($values as $k => $v) {
                $stmt->bindParam(":$k", $v);
            }
            $paraam = array_merge($this->bind, $values);
            if ($stmt->execute($paraam)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        } catch (PDOException $e) {
            echo $this->error = $e->getMessage();
            return false;
        }
    }

    public function deleteSQL($tablename = "")
    {
        try {
            $sql = "DELETE FROM " . $this->setTable() . "$tablename " . $this->setWhere();
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($this->bind);
            return $stmt;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
}
