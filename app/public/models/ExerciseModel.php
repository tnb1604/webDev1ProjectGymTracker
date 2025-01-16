<?php

require_once 'BaseModel.php';

class ExerciseModel extends BaseModel
{
    public function getGlobalExercises()
    {
        $query = "SELECT * FROM exercise WHERE user_id IS NULL";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserExercises($userId)
    {
        $query = "SELECT * FROM exercise WHERE user_id = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createGlobalExercise($name, $userId = null)
    {
        $query = "INSERT INTO exercise (name, user_id) VALUES (?, ?)";
        $stmt = self::$pdo->prepare($query);

        if (!$stmt->execute([$name, $userId])) {
            // Log the error or print out the error message
            $errorInfo = $stmt->errorInfo();
            echo "Error: " . $errorInfo[2];  // This will print the PDO error message
            return false;
        }

        return true;
    }


    public function createUserExercise($name, $userId)
    {
        $query = "INSERT INTO exercise (name, user_id) VALUES (?, ?)";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$name, $userId]);
    }

    public function deleteExercise($exerciseId)
    {
        try {
            // Use self::$pdo to refer to the static PDO instance
            $stmt = self::$pdo->prepare("DELETE FROM exercise WHERE exercise_id = :exercise_id");
            $stmt->bindParam(':exercise_id', $exerciseId, PDO::PARAM_INT);
            $stmt->execute();

        } catch (PDOException $e) {
            // Handle foreign key violations or other errors
            if ($e->getCode() == 23000) {
                return "You cannot delete this exercise because it is used in one or more workouts.";
            } else {
                return "An error occurred while trying to delete the exercise: " . $e->getMessage();
            }
        }
    }

    public function updateExercise($exerciseId, $newName)
    {
        $query = "UPDATE exercise SET name = ? WHERE exercise_id = ?";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$newName, $exerciseId]);
    }

}
