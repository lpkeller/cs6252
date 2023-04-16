<?php

class Database {

    private $db;
    private $error_message;

    /**
     * connect to the database
     */
    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=task_manager';
        $username = 'mgs_user';
        $password = 'pa55word';
        $this->error_message = '';
        $this->reg_error_message = '';
        try {
            $this->db = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
        }
    }

    /**
     * check the connection to the database
     *
     * @return boolean - true if a connection to the database has been established
     */
    public function isConnected() {
        return ($this->db != Null);
    }

    public function getErrorMessage() {
        return $this->error_message;
    }
    
    public function getRegErrorMessage() {
        return $this->reg_error_message;
    }

    public function isValidUserLogin($username, $password) {
        $query = 'SELECT password FROM users
              WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if (!$row) {
            return false;
        }
        $hash = $row['password'];
        return password_verify($password, $hash);
    }
    
    private function checkPassword($password) {
        if (strlen($password)<8) {
            $this->reg_error_message = "Password must be at least 8 characters.";
            return false;
        }
        if (!preg_match('/[[:digit:]]/', $password)){
            $this->reg_error_message = "Password must contain at least 1 number.";
            return false;
        }
        if (!preg_match('/[[:lower:]]/', $password)){
            $this->reg_error_message = "Password must contain at least 1 lowercase letter.";
            return false;
        }
        if (!preg_match('/[[:upper:]]/', $password)){
            $this->reg_error_message = "Password must contain at least 1 uppercase letter.";
            return false;
        }
        return true;
    }
    
    private function addToUsers($username, $password) {;
        $query = 'INSERT INTO users (username, password)
                    VALUES (:username, :password)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $statement->closeCursor();
    }


    public function registerNewUser($username, $password) {
        $this->reg_error_message = '';

        $query = 'SELECT password FROM users
              WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row) {
            $this->reg_error_message = "User Name is taken.";
            return false;
        }
        if (strlen($username)>20 || strlen($username)<1) {
            $this->reg_error_message = "User Name must be between 1 & 20 characters.";
            return false;
        }
        if (!$this->checkPassword($password)){
            return false;
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $this->addToUsers($username, $hash);
        return true;
    }

    public function getTasksForUser($username) {
        $query = 'SELECT * FROM tasks
                  WHERE tasks.username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $tasks = $statement->fetchAll();
        $statement->closeCursor();
        return $tasks;
    }

    public function addTask($username, $task) {
        $query = 'INSERT INTO tasks (username, task)
                  VALUES (:username, :task)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':task', $task);
        $statement->execute();
        $statement->closeCursor();
    }

    public function deleteTask($task_id) {
        $query = 'DELETE FROM tasks
                  WHERE taskID = :task_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $statement->closeCursor();
    }

}

?>