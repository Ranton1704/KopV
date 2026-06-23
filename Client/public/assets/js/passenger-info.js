// Passenger Info JavaScript

// Simulation JavaScript pour l'option "Remplir automatiquement avec mon profil"
document.getElementById('autoFillProfile')?.addEventListener('change', function() {
    const firstCard = document.querySelector('.kopv-passenger-card');
    const nameInput = firstCard.querySelector('.passenger-name');
    const phoneInput = firstCard.querySelector('.passenger-phone');
    const cinInput = firstCard.querySelector('.passenger-cin');

    if (this.checked) {
        // Données d'exemple (Normalement lues depuis les variables de session utilisateur)
        nameInput.value = "Rakoto ANDRIANANTENAINA";
        phoneInput.value = "345678901";
        cinInput.value = "105201098765";
    } else {
        // Réinitialiser les champs si décoché
        nameInput.value = "";
        phoneInput.value = "";
        cinInput.value = "";
    }
});

// Validation JavaScript stricte côté client avant envoi
document.getElementById('passengersForm').addEventListener('submit', function(e) {
    const cinInputs = document.querySelectorAll('.passenger-cin');
    let valid = true;

    cinInputs.forEach(input => {
        // Vérification simple de la longueur réglementaire à Madagascar (12 chiffres)
        if (input.value.trim().length !== 12 || isNaN(input.value.trim())) {
            alert(`Erreur : Le numéro de CIN "${input.value}" doit comporter exactement 12 chiffres.`);
            input.style.borderColor = 'var(--danger)';
            valid = false;
        } else {
            input.style.borderColor = 'var(--glass-border)';
        }
    });

    if (!valid) {
        e.preventDefault(); // Empêche la soumission du formulaire
    }
});
