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

        // Execute the query
        if ($stmt->execute()) {
            // Return the last inserted ID
            return self::$pdo->lastInsertId();
        } else {
            // Handle the error if needed (optional)
            return false;
        }
    }


    public function addExerciseToWorkout($workoutId, $exerciseId, $setNumber, $reps, $weight)
    {
        $stmt = self::$pdo->prepare("
        INSERT INTO workout_exercise (workout_id, exercise_id, set_number, reps, weight)
        VALUES (:workout_id, :exercise_id, :set_number, :reps, :weight)
    ");
        $stmt->bindParam(':workout_id', $workoutId);
        $stmt->bindParam(':exercise_id', $exerciseId);
        $stmt->bindParam(':set_number', $setNumber);
        $stmt->bindParam(':reps', $reps);
        $stmt->bindParam(':weight', $weight);
        return $stmt->execute();
    }


    public function delete($workoutId)
    {
        $sql = "DELETE FROM workout WHERE workout_id = :workout_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getExerciseIdByName($exerciseName)
    {
        $query = "SELECT exercise_id FROM exercise WHERE name = :name LIMIT 1";
        $statement = self::$pdo->prepare($query);
        $statement->bindParam(':name', $exerciseName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['exercise_id'] : null;
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

    public function getWorkoutDetails($workoutId)
    {
        // Query to fetch workout details
        $workoutQuery = "SELECT * FROM workout WHERE workout_id = :workout_id";
        $stmt = self::$pdo->prepare($workoutQuery);
        $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
        $stmt->execute();

        // Check if workout exists
        if ($stmt->rowCount() > 0) {
            $workout = $stmt->fetch(PDO::FETCH_ASSOC);

            // Query to fetch exercises associated with the workout from workout_exercise
            $exerciseQuery = "
            SELECT set_number, reps, weight
            FROM workout_exercise
            WHERE workout_id = :workout_id";

            $stmt = self::$pdo->prepare($exerciseQuery);
            $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
            $stmt->execute();
            $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'workout' => $workout,
                'exercises' => $exercises,
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Workout not found.',
            ];
        }
    }

}
