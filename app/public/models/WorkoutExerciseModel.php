<?php

require_once 'BaseModel.php';

class WorkoutExerciseModel extends BaseModel
{
    public function getWorkoutExercises($workoutId)
    {
        $query = "SELECT we.id, e.name, we.set_number, we.reps, we.weight 
                  FROM workout_exercise we
                  JOIN exercise e ON we.exercise_id = e.exercise_id
                  WHERE we.workout_id = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$workoutId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addWorkoutExercise($workoutId, $exerciseId, $setNumber, $reps, $weight)
    {
        $query = "INSERT INTO workout_exercise (exercise_id, workout_id, set_number, reps, weight)
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$exerciseId, $workoutId, $setNumber, $reps, $weight]);
    }

    public function updateWorkoutExercise($id, $setNumber, $reps, $weight)
    {
        $query = "UPDATE workout_exercise 
                  SET set_number = ?, reps = ?, weight = ?
                  WHERE id = ?";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$setNumber, $reps, $weight, $id]);
    }

    public function deleteWorkoutExercise($id)
    {
        $query = "DELETE FROM workout_exercise WHERE id = ?";
        $stmt = self::$pdo->prepare($query);
        return $stmt->execute([$id]);
    }
}
