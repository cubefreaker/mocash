<?php
class DB {
    protected $connection;
    protected $select;
    protected $from;
    protected $join;
    protected $where;
    protected $groupBy;
    protected $orderBy;
    protected $limit;

	public function __construct($dbHost = 'localhost', $dbUser = 'root', $dbPass = '', $dbName = 'db_mocash') {
		$this->connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        
        if(!$this->connection) {
            die("Koneksi ke database gagal: " . mysqli_connect_error());
        }
	}

    public function __destruct() {
        $this->connection->close();
    }

    public function reset() {
        $this->select = '';
        $this->from = '';
        $this->join = '';
        $this->where = '';
        $this->groupBy = '';
        $this->orderBy = '';
        $this->limit = '';
    }

    public function select($select) {
        $this->select = $select;
        return $this;
    }

    public function from($from) {
        $this->from = $from;
        return $this;
    }

    public function join($join) {
        $this->join .= " $join";
        return $this;
    }

    public function where($where) {
        if($this->where) {
            $this->where .= " AND $where";
        } else {
            $this->where = "WHERE $where";
        }
        return $this;
    }

    public function whereIn($field, $values) {
        if($this->where) {
            $this->where .= " AND $field IN ($values)";
        } else {
            $this->where = "WHERE $field IN ($values)";
        }
        return $this;
    }

    public function groupBy($groupBy) {
        $this->groupBy = "GROUP BY $groupBy";
        return $this;
    }

    public function orderBy($orderBy) {
        $this->orderBy = "ORDER BY $orderBy";
        return $this;
    }

    public function limit($limit) {
        $this->limit = "LIMIT $limit";
        return $this;
    }

    public function get() {
        $this->select = $this->select ? $this->select : '*';
        $query = "SELECT $this->select FROM $this->from $this->join $this->where $this->groupBy $this->orderBy $this->limit";
        $result = $this->connection->query($query);
        $this->reset();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOne() {
        $this->select = $this->select ? $this->select : '*';
        $query = "SELECT $this->select FROM $this->from $this->join $this->where $this->groupBy $this->orderBy $this->limit";
        $result = $this->connection->query($query);
        $this->reset();
        return $result->fetch_assoc();
    }

    public function count() {
        $query = "SELECT COUNT(*) AS count FROM $this->from $this->join $this->where $this->groupBy $this->orderBy $this->limit";
        $result = $this->connection->query($query);
        $this->reset();
        return $result->fetch_assoc()['count'];
    }

    public function insert($table, $data) {
        $fields = implode(", ", array_keys($data));
        $values = implode("', '", array_values($data));
        $query = "INSERT INTO $table ($fields) VALUES ('$values')";
        $result = $this->connection->query($query);
        $this->reset();
        return $this->connection->insert_id;
    }

    public function update($table, $data) {
        $set = '';
        foreach($data as $key => $value) {
            $set .= "$key = '$value', ";
        }
        $set = rtrim($set, ', ');
        $query = "UPDATE $table SET $set $this->where";
        $result = $this->connection->query($query);
        $this->reset();
        return $result;
    }

    public function delete($table) {
        $query = "DELETE FROM $table $this->where";
        $result = $this->connection->query($query);
        $this->reset();
        return $result;
    }
}
?>