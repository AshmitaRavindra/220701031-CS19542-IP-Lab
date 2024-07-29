document.getElementById('submit').addEventListener('click', function(event) {
    event.preventDefault();

    // Clear previous error messages
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => element.textContent = '');

    let isValid = true;

    // Step 1 Validation
    const name = document.getElementById('name').value.trim();
    const dob = document.getElementById('dob').value;
    const gender = document.querySelector('input[name="gender"]:checked');
    const mob = document.getElementById('mob').value.trim();

    if (name === '') {
        document.getElementById('name-error').textContent = 'Name is required';
        isValid = false;
    }

    if (dob === '') {
        document.getElementById('dob-error').textContent = 'Date of Birth is required';
        isValid = false;
    }

    if (!gender) {
        document.getElementById('gender-error').textContent = 'Gender is required';
        isValid = false;
    }

    if (mob === '' || !/^\d{10}$/.test(mob)) {
        document.getElementById('mob-error').textContent = 'Valid 10-digit Mobile No is required';
        isValid = false;
    }

    // Step 2 Validation
    const course = document.getElementById('course').value.trim();
    const cgpa = document.getElementById('cgpa').value.trim();
    const skills = document.getElementById('skills').value.trim();

    if (course === '') {
        document.getElementById('course-error').textContent = 'Course Name is required';
        isValid = false;
    }

    if (cgpa === '') {
        document.getElementById('cgpa-error').textContent = 'CGPA is required';
        isValid = false;
    }

    if (skills === '') {
        document.getElementById('skills-error').textContent = 'Skills and Qualifications are required';
        isValid = false;
    }

    // Step 3 Validation
    const job = document.getElementById('job').value;
    const experience = document.getElementById('experience').value;
    const resume = document.getElementById('resume').value;

    if (job === '') {
        document.getElementById('job-error').textContent = 'Job is required';
        isValid = false;
    }

    if (experience === '') {
        document.getElementById('experience-error').textContent = 'Experience is required';
        isValid = false;
    }

    if (resume === '') {
        document.getElementById('resume-error').textContent = 'Resume is required';
        isValid = false;
    }

    if (isValid) {
        alert('Form submitted successfully!');
        // Here you can add code to submit the form data to the server
    }
});

