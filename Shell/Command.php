<?php

namespace App\Cms\Shell;

class Command
{
    public function __construct()
    {
        $this->createCategoryTable();
        $this->createUsersTable();
        $this->createPostTable();
        $this->createCommentsTable();
        $this->createLikeTable();
        $this->createCommentsReplyTable();
    }

    public function createPostTable()
    {
        if ($this->isTableExists('posts')) {
            print("Table posts allready exists \n");
            return;
        }

        $table = "posts";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                post_title VARCHAR( 50 ) NOT NULL, 
                post_author VARCHAR( 250 ),
                post_date DATETIME, 
                post_image VARCHAR( 150 ) NOT NULL, 
                post_content VARCHAR( 150 ) NOT NULL, 
                post_tags VARCHAR( 100 ) NOT NULL,
                post_comment_count INT( 50 ),
                post_status VARCHAR( 50 ) NOT NULL,
                post_views INT( 11 ),
                slug VARCHAR( 50 ),
                post_category_id INT ( 11 ),
                post_user_id INT ( 11 ),
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL, 
                FOREIGN KEY (post_category_id) REFERENCES category(id),
                FOREIGN KEY (post_user_id) REFERENCES users(id)
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createCategoryTable()
    {
        if ($this->isTableExists('category')) {
            print("Table category allready exists \n");
            return;
        }

        $table = "category";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                cat_title VARCHAR( 50 ) NOT NULL, 
                slug VARCHAR( 250 ),
                color VARCHAR( 250 ) NOT NULL,
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createUsersTable()
    {
        if ($this->isTableExists('users')) {
            print("Table users allready exists \n");
            return;
        }

        $table = "users";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                user_name VARCHAR( 50 ) NOT NULL, 
                user_password VARCHAR( 250 ) NOT NULL,
                user_image VARCHAR( 250 ) NOT NULL,
                user_email VARCHAR( 250 ) NOT NULL,
                user_firstname VARCHAR( 250 ) NULL,
                user_lastname VARCHAR( 250 ) NULL,
                session_id VARCHAR( 250 ) NOT NULL,
                user_role VARCHAR( 250 ) NOT NULL,
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createLikeTable()
    {
        if ($this->isTableExists('likes')) {
            print("Table likes allready exists \n");
            return;
        }

        $table = "likes";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                user_id INT ( 10 ) NOT NULL, 
                post_id INT ( 10 ) NOT NULL,
                count INT ( 10 ), 
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL, 
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (post_id) REFERENCES posts(id)
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createCommentsTable()
    {
        if ($this->isTableExists('comments')) {
            print("Table comments allready exists \n");
            return;
        }

        $table = "comments";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                comment_author VARCHAR( 50 ) NOT NULL, 
                comment_email VARCHAR( 250 ) NOT NULL,
                comment_content VARCHAR( 150 ) NOT NULL, 
                comment_status VARCHAR( 150 ) NOT NULL, 
                comment_date DATETIME NOT NULL,
                reply_author VARCHAR( 50 ),
                comment_post_id INT ( 11 ) NOT NULL,
                comment_user_id INT ( 11 ) NOT NULL,
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL, 
                FOREIGN KEY (comment_post_id) REFERENCES posts(id),
                FOREIGN KEY (comment_user_id) REFERENCES users(id)
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createCommentsReplyTable()
    {
        if ($this->isTableExists('reply_comment')) {
            print("Table comments reply allready exists \n");
            return;
        }

        $table = "reply_comment";
        try {
            $db = $this->getConnection();
            $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            $sql = "CREATE table $table(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                comment_post_id INT( 10 ) NOT NULL, 
                comment_user_id INT( 10 ) NOT NULL,
                comment_reply_id INT( 10 ) NOT NULL, 
                comment_content VARCHAR( 150 ) NOT NULL, 
                updated_at DATETIME NOT NULL, 
                created_at DATETIME NOT NULL, 
                FOREIGN KEY (comment_post_id) REFERENCES posts(id),
                FOREIGN KEY (comment_user_id) REFERENCES users(id)
                );";
            $db->exec($sql);
            print("Created $table Table.\n");

        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function isTableExists(string $tableName)
    {
        $connection = $this->getConnection();
        $query = "SELECT * FROM $tableName";
        $stmt = $connection->query($query);

        if ($stmt === false) {
            return false;
        }

        return true;
    }


    private function getConnection()
    {
        return  new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASS);
    }
}


$command = new Command();