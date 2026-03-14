const birthDate = document.getElementById('birthDate');
const ageInput = document.getElementById('age');

function calculateAge(dateStr) {
  const birth = new Date(dateStr);
  const today = new Date();
  let age = today.getFullYear() - birth.getFullYear();
  const monthDiff = today.getMonth() - birth.getMonth();
  if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
    age--;
  }
  return age;
}

if (birthDate && ageInput) {
  birthDate.addEventListener('change', () => {
    if (birthDate.value) {
      ageInput.value = calculateAge(birthDate.value);
    }
  });
}

const patientForm = document.getElementById('patientForm');
if (patientForm) {
  patientForm.addEventListener('submit', (event) => {
    const required = patientForm.querySelectorAll('[required]');
    let valid = true;

    required.forEach((field) => {
      if (!field.value.trim()) {
        field.style.borderColor = '#dc2626';
        valid = false;
      } else {
        field.style.borderColor = '#d1d5db';
      }
    });

    if (!valid) {
      event.preventDefault();
      alert('Por favor complete todos los campos obligatorios.');
    }
  });
}
