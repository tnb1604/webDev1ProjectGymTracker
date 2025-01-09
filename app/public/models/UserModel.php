<?php

require_once(__DIR__ . "/BaseModel.php");

class UserModel extends BaseModel
{
    // Get all users from the database.
    public function getAll()
    {
        $sql = "SELECT user_id, email, username FROM user";  // Updated table name to `user`
        $stmt = self::$pdo->prepare($sql); // Use self::$pdo
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single user by ID.
    public function get($id)
    {
        // Debug: Print the user ID we are trying to fetch
        echo "Fetching user with ID: " . $id . "<br>";

        // Prepare the SQL query
        $sql = "SELECT user_id, email, username, type FROM user WHERE user_id = :id"; // Include 'type'
        echo "SQL Query: " . $sql . "<br>";  // Debug: Show the SQL query

        // Prepare the statement
        $stmt = self::$pdo->prepare($sql);

        // Bind the ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Check if user is found or not
        if ($user) {
            echo "User found: <pre>";
            print_r($user);  // Debug: Print the user data
            echo "</pre>";
        } else {
            echo "No user found with ID: " . $id . "<br>";  // Debug: Show message if no user is found
        }

        return $user;  // Return the user data or false
    }



    // Find a user by their username.
    public function findByUsername($username)
    {
        $sql = "SELECT user_id, email, username, password, type FROM user WHERE username = :username";  // Correctly select `type`
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns the correct result with `type`
    }



    public function findByEmail($email)
    {
        $sql = "SELECT user_id, email, username, password FROM user WHERE email = :email";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if no record is found
    }

    public function createUser($username, $email, $password)
    {
        // Assuming user_id is auto-increment and should not be inserted manually
        $sql = "INSERT INTO user (username, email, type, password) VALUES (:username, :email, :type, :password)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $type = 'User'; // Set type explicitly
        $stmt->bindParam(':type', $type, PDO::PARAM_STR); // Bind the type parameter
        return $stmt->execute(); // Returns true on success, false on failure
    }


}
