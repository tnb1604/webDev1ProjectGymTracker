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

    public function getByDate($userId, $startDate, $endDate)
    {
        // Fetch workouts for the current month (or any date range)
        $sql = "SELECT date FROM workout WHERE user_id = :user_id AND date BETWEEN :start_date AND :end_date";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $name, $date)
    {
        try {
            if (strlen($name) > 30) {
                throw new Exception('Workout name is too long.');
            }
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
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    public function addExerciseToWorkout($workoutId, $exerciseId, $setNumber, $reps, $weight)
    {
        // Validate reps and weight length
        if (strlen($reps) > 10 || strlen($weight) > 10) {
            throw new Exception('Reps or weight value is too long.');
        }

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

    public function deleteExercisesByWorkoutId($workoutId)
    {
        $sql = "DELETE FROM workout_exercise WHERE workout_id = :workout_id";
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
        try {
            if (strlen($name) > 30) {
                throw new Exception('Workout name is too long.');
            }
            $sql = "UPDATE workout SET name = :name, date = :date WHERE workout_id = :workout_id";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
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

            // Query to fetch exercises associated with the workout from workout_exercise and exercise
            $exerciseQuery = "
            SELECT we.set_number, we.reps, we.weight, e.exercise_id, e.name AS exercise_name
            FROM workout_exercise we
            JOIN exercise e ON we.exercise_id = e.exercise_id
            WHERE we.workout_id = :workout_id";

            $stmt = self::$pdo->prepare($exerciseQuery);
            $stmt->bindParam(':workout_id', $workoutId, PDO::PARAM_INT);
            $stmt->execute();
            $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($exercises)) {
                $_SESSION['error'] = "No exercises found. Please add some exercises first.";
                return [
                    'success' => false,
                    'message' => $_SESSION['error'],
                    'workout' => $workout,
                    'exercises' => [],
                    'allExercises' => []
                ];
            }


            // Group sets by exercise
            $groupedExercises = [];
            foreach ($exercises as $exercise) {
                $exerciseName = $exercise['exercise_name'];
                if (!isset($groupedExercises[$exerciseName])) {
                    $groupedExercises[$exerciseName] = [
                        'exercise_name' => $exerciseName,
                        'sets' => []
                    ];
                }
                $groupedExercises[$exerciseName]['sets'][] = [
                    'set_number' => $exercise['set_number'],
                    'reps' => $exercise['reps'],
                    'weight' => $exercise['weight']
                ];
            }

            // Fetch all available exercises
            $allExercisesQuery = "SELECT name FROM exercise";
            $stmt = self::$pdo->prepare($allExercisesQuery);
            $stmt->execute();
            $allExercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'workout' => $workout,
                'exercises' => array_values($groupedExercises),
                'allExercises' => $allExercises
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Workout not found.',
            ];
        }
    }

}
