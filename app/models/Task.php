<?php
class Task extends DB
{

    public function getAllTasks()
    {
        $tasks = [];
        $sql = "SELECT * FROM tasks";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 'pending') {
                    $row['className'] = "fc-bg-deepskyblue";
                }
                if ($row['status'] == 'in_progress') {
                    $row['className'] = "fc-bg-pinkred";
                }
                $tasks[] = $row;
            }
        }
        return $tasks;
    }

    public function insert($table = '', $data = [])
    {
        $keys = '';
        $values = '';
        foreach ($data as $key => $value) {
            $keys .= ',' . $key;
            $values .= ',"' . mysqli_real_escape_string($this->conn, $value) . '"';
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($keys, ',') . ') VALUES (' . trim($values, ',') . ')';
        return mysqli_query($this->conn, $sql);
    }

    public function delete($table = '', $id = null)
    {
        $sql = 'DELETE FROM ' . $table . ' WHERE id = ' . $id;
        return mysqli_query($this->conn, $sql);
    }

    public function update($table = '', $data = [], $id = null)
    {
        $content = '';
        foreach ($data as $key => $value) {
            $content .= ',' . $key . '="' . mysqli_real_escape_string($this->conn, $value) . '"';
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($content, ',') . ' WHERE id = ' . $id;
        return mysqli_query($this->conn, $sql);
    }

}
?>