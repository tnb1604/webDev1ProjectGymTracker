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
        return $stmt->execute([$name, $userId]);
    }

    public function createExercise($name, $userId)
    {
        $query = "INSERT INTO exercise (name, user_id) VALUES (?, ?)";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$name, $userId]);
    }

    public function deleteExercise($exerciseId)
    {
        if (!$exerciseId) {
            return false;
        }
        $query = "DELETE FROM exercise WHERE exercise_id = ?";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$exerciseId]);
    }
    public function deleteGlobalExercise($exerciseId)
    {

    }
}
