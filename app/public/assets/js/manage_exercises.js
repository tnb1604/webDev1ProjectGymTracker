// Fill the modal with the selected exercise data
const editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
editButtons.forEach(button => {
    button.addEventListener('click', function () {
        const exerciseId = this.getAttribute('data-id');
        const exerciseName = this.getAttribute('data-name');

        // Populate the fields in the modal
        document.getElementById('exerciseId').value = exerciseId;
        document.getElementById('editExerciseName').value = exerciseName;
    });
});

document.querySelector('input[name="search"]').addEventListener('input', function () {
    const searchTerm = this.value.trim();

    fetch(`/api/searchGlobalExercises.php?search=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }

            const exerciseList = document.querySelector('.list-group');
            exerciseList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(exercise => {
                    const listItem = document.createElement('li');
                    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                    listItem.innerHTML = `
                        <span><strong>${exercise.name}</strong></span>
                        <div class="d-flex">
                            <button type="button" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#editExerciseModal" data-id="${exercise.exercise_id}"
                                data-name="${exercise.name}">Edit</button>
                            <form method="POST" action="/deleteGlobalExercise" style="margin: 0;">
                                <input type="hidden" name="id" value="${exercise.exercise_id}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    `;
                    exerciseList.appendChild(listItem);
                });
            } else {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = 'No global exercises available.';
                exerciseList.appendChild(listItem);
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
});