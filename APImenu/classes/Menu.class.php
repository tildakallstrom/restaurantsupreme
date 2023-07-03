<?php
class Menu
{
    private $db;
    private $name;
    private $description;
    private $type;
    public function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_error) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }
    public function getMenu(): array
    {
        $sql = "SELECT * FROM menu ORDER BY id;";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getMenuById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM menu WHERE id = $id;";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function create(string $name, string $description, string $type): bool
    {
        if (!$this->setName($name)) {
            return false;
        }
        if (!$this->setDescription($description)) {
            return false;
        }
        if (!$this->setType($type)) {
            return false;
        }
        $stmt = $this->db->prepare("INSERT INTO menu (name, description, type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $this->name, $this->description, $this->type);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    public function deleteMenu(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM menu WHERE id=$id;";
        $result = $this->db->query($sql);
        return $result;
    }
    public function updateMenu($id, $data): bool
    {
        $id = intval($id);
        $name = $data->name;
        $description = $data->description;
        $type = $data->type;
        $sql = "UPDATE menu SET name= '$name', description= '$description', type= '$type' WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
    public function setName($name)
    {
        if (filter_var($name)) {
            $name = strip_tags(html_entity_decode($name), '<p><a><br><i><b><strong><em>');
            $this->name = $this->db->real_escape_string($name);
            return true;
        } else {
            return false;
        }
    } 
    public function setDescription($description)
    {
        if (filter_var($description)) {
            $description = strip_tags(html_entity_decode($description), '<p><a><br><i><b><strong><em>');
            $this->description = $this->db->real_escape_string($description);
            return true;
        } else {
            return false;
        }
    }
    public function setType($type)
    {
        if (filter_var($type)) {
            $type = strip_tags(html_entity_decode($type), '<p><a><br><i><b><strong><em>');
            $this->type = $this->db->real_escape_string($type);
            return true;
        } else {
            return false;
        }
    }
}