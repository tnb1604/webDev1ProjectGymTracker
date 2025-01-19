document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const exerciseId = this.getAttribute('data-id');
            const exerciseName = this.getAttribute('data-name');
            document.getElementById('exerciseId').value = exerciseId;
            document.getElementById('exerciseName').value = exerciseName;
        });
    });

    const createExerciseForm = document.getElementById('createExerciseForm');
    createExerciseForm.addEventListener('submit', function (event) {
        const nameInput = document.getElementById('name');
        const nameError = document.getElementById('nameError');
        if (nameInput.value.trim() === '') {
            event.preventDefault();
            nameInput.classList.add('is-invalid');
            nameError.style.display = 'block';
        } else {
            nameInput.classList.remove('is-invalid');
            nameError.style.display = 'none';
        }
    });
});
