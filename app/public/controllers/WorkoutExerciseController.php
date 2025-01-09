<?php

require_once 'models/WorkoutExerciseModel.php';

class WorkoutExerciseController
{
    private $workoutExerciseModel;

    public function __construct()
    {
        $this->workoutExerciseModel = new WorkoutExerciseModel();
    }

    public function listWorkoutExercises($workoutId)
    {
        return $this->workoutExerciseModel->getWorkoutExercises($workoutId);
    }

    public function addWorkoutExercise($workoutId, $exerciseId, $setNumber, $reps, $weight)
    {
        $this->workoutExerciseModel->addWorkoutExercise($workoutId, $exerciseId, $setNumber, $reps, $weight);
    }

    public function updateWorkoutExercise($id, $setNumber, $reps, $weight)
    {
        $this->workoutExerciseModel->updateWorkoutExercise($id, $setNumber, $reps, $weight);
    }

    public function removeWorkoutExercise($id)
    {
        $this->workoutExerciseModel->deleteWorkoutExercise($id);
    }
}
