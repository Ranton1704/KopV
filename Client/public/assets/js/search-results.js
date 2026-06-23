// Search Results Modal JavaScript

document.querySelectorAll('.btn-view-details').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('modalCooperativeName').textContent = this.getAttribute('data-cooperative');
        document.getElementById('modalVehicule').textContent = this.getAttribute('data-vehicule');
        document.getElementById('modalEscales').textContent = this.getAttribute('data-escales');
        document.getElementById('modalBagages').textContent = this.getAttribute('data-bagages');
        document.getElementById('modalAnnulation').textContent = this.getAttribute('data-annulation');
        
        document.getElementById('tripDetailsModal').classList.add('active');
    });
});

function closeModal() {
    document.getElementById('tripDetailsModal').classList.remove('active');
}

document.getElementById('tripDetailsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
