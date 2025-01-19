<div class="card mt-4" style="margin: 0 240px;">
    <div class="card-header bg-secondary text-white d-flex justify-content-between">
        <a href="?date=<?= date('Y-m-d', strtotime("$currentYear-$currentMonth -1 month")) ?>"
            class="btn btn-light btn-sm">&lt; Previous</a>
        <h5 class="text-center mb-0"><?= date('F Y', strtotime($currentDate)); ?></h5>
        <a href="?date=<?= date('Y-m-d', strtotime("$currentYear-$currentMonth +1 month")) ?>"
            class="btn btn-light btn-sm">Next &gt;</a>
    </div>
    <div class="card-body">
        <div class="calendar">
            <?php
            // Days of the week labels
            $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($weekDays as $day) {
                echo "<div class='calendar-day font-weight-bold bg-light'>$day</div>";
            }

            // Empty slots before 1st day
            $startDay = date('w', strtotime($firstDayOfMonth));
            for ($i = 0; $i < $startDay; $i++) {
                echo '<div class="calendar-day"></div>';
            }

            // Days of the current month
            $daysInMonth = date('t', strtotime($currentDate));
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDay = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                $isToday = $currentDay === date('Y-m-d') ? 'today' : '';
                $hasWorkout = isset($loggedWorkouts[$currentDay]) ? 'logged' : '';
                echo "<div class='calendar-day $isToday $hasWorkout' data-date='$currentDay'>
                                    <span>$day</span>
                                  </div>";
            }
            ?>
        </div>
    </div>
</div>
</div>