<?php
class News
{
    private $db;
    private $title;
    private $content;
    private $author;
    private $date;
    public function __construct()
    {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_error) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }
    public function getNews(): array
    {
        $sql = "SELECT * FROM news ORDER BY id;";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getNewsById(int $id): array
    {
        $id = intval($id);
        $sql = "SELECT * FROM news WHERE id = $id;";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function create(string $title, string $content, string $author, string $date): bool
    {
        if (!$this->setTitle($title)) {
            return false;
        }
        if (!$this->setContent($content)) {
            return false;
        }
        if (!$this->setAuthor($author)) {
            return false;
        }
        $this->date = $date;
        $stmt = $this->db->prepare("INSERT INTO news (title, content, author, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->title, $this->content, $this->author, $this->date);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }
    public function deleteNews(int $id): bool
    {
        $id = intval($id);
        $sql = "DELETE FROM news WHERE id=$id;";
        $result = $this->db->query($sql);
        return $result;
    }
    public function updateNews($id, $data): bool
    {
        $id = intval($id);
        $title = $data->title;
        $content = $data->content;
        $author = $data->author;
        $date = $data->date;
        $sql = "UPDATE news SET title= '$title', content= '$content', author= '$author', date= '$date' WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
    public function setTitle($title)
    {
        if (filter_var($title)) {
            $title = strip_tags(html_entity_decode($title), '<p><a><br><i><b><strong><em>');
            $this->title = $this->db->real_escape_string($title);
            return true;
        } else {
            return false;
        }
    } 
    public function setContent($content)
    {
        if (filter_var($content)) {
            $content = strip_tags(html_entity_decode($content), '<p><a><br><i><b><strong><em>');
            $this->content = $this->db->real_escape_string($content);
            return true;
        } else {
            return false;
        }
    }
    public function setAuthor($author)
    {
        if (filter_var($author)) {
            $author = strip_tags(html_entity_decode($author), '<p><a><br><i><b><strong><em>');
            $this->author = $this->db->real_escape_string($author);
            return true;
        } else {
            return false;
        }
    }
}