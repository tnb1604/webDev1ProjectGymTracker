<?php

require_once(__DIR__ . "/BaseModel.php");

class WorkoutModel extends BaseModel
{
    public function getAllByUser($userId)
    {
        $sql = "SELECT * FROM workout WHERE user_id = :user_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByDate($userId, $date)
    {
        // Fetch workouts for the current month (or any date range)
        $sql = "SELECT * FROM workout WHERE user_id = :user_id AND date BETWEEN :start_date AND :end_date";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $name, $date)
    {
        $sql = "INSERT INTO workout (user_id, name, date) VALUES (:user_id, :name, :date)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($workoutId)
    {
        $sql = "DELETE FROM workout WHERE workout_id = :workout_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function update($workoutId, $name, $date)
    {
        $sql = "UPDATE workout SET name = :name, date = :date WHERE workout_id = :workout_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function get($workoutId)
    {
        $sql = "SELECT * FROM workout WHERE workout_id = :workout_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
