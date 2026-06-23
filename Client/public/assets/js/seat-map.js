/**
 * KOP-V Seat Map Logic
 * Gestion de la sélection des sièges avec verrouillage AJAX
 */

class KopVSeatMap {
    constructor(options = {}) {
        this.maxSeats = options.maxSeats || 1;
        this.selectedSeats = [];
        this.tripId = options.tripId || null;
        this.lockUrl = options.lockUrl || '/Voyage/lock-seat';
        this.unlockUrl = options.unlockUrl || '/Voyage/unlock-seat';
        this.onSelectionChange = options.onSelectionChange || null;
        this.onTimerEnd = options.onTimerEnd || null;
        
        this.timerDuration = 600; // 10 minutes en secondes
        this.timeRemaining = this.timerDuration;
        this.timerInterval = null;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.startTimer();
    }

    bindEvents() {
        // Bind click events on seats (support both old and new classes)
        document.querySelectorAll('.kopv-seat:not(.occupied), .kopv-seat-3d:not(.occupied)').forEach(seat => {
            seat.addEventListener('click', (e) => this.handleSeatClick(e));
        });
    }

    handleSeatClick(event) {
        const seat = event.currentTarget;
        const seatId = seat.getAttribute('data-seat-id');
        const seatNumber = seat.getAttribute('data-seat-number');

        if (seat.classList.contains('occupied')) {
            return; // Ne rien faire pour les sièges occupés
        }

        if (seat.classList.contains('selected')) {
            this.deselectSeat(seat, seatId);
        } else {
            this.selectSeat(seat, seatId);
        }

        this.updateUI();
        this.notifySelectionChange();
    }

    selectSeat(seat, seatId) {
        if (this.selectedSeats.length >= this.maxSeats) {
            this.showNotification(`Vous avez déjà sélectionné vos ${this.maxSeats} place(s).`, 'warning');
            return false;
        }

        seat.classList.remove('available');
        seat.classList.add('selected');
        this.selectedSeats.push(seatId);

        // Lock seat via AJAX
        this.lockSeat(seatId);

        return true;
    }

    deselectSeat(seat, seatId) {
        seat.classList.remove('selected');
        seat.classList.add('available');
        this.selectedSeats = this.selectedSeats.filter(id => id !== seatId);

        // Unlock seat via AJAX
        this.unlockSeat(seatId);

        return true;
    }

    async lockSeat(seatId) {
        if (!this.tripId) return;

        try {
            const formData = new FormData();
            formData.append('trip_id', this.tripId);
            formData.append('seat_id', seatId);

            const response = await fetch(this.lockUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            if (!data.success) {
                console.error('Erreur lors du verrouillage:', data.message);
                this.showNotification('Erreur lors du verrouillage du siège', 'error');
            }
        } catch (error) {
            console.error('Erreur AJAX:', error);
        }
    }

    async unlockSeat(seatId) {
        if (!this.tripId) return;

        try {
            const formData = new FormData();
            formData.append('trip_id', this.tripId);
            formData.append('seat_id', seatId);

            const response = await fetch(this.unlockUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            if (!data.success) {
                console.error('Erreur lors du déverrouillage:', data.message);
            }
        } catch (error) {
            console.error('Erreur AJAX:', error);
        }
    }

    updateUI() {
        // Update selected seats list
        const selectedList = document.getElementById('selectedSeatsList');
        if (selectedList) {
            selectedList.textContent = this.selectedSeats.length > 0 
                ? this.selectedSeats.join(', ') 
                : '-';
        }

        // Update hidden input
        const inputChosenSeats = document.getElementById('inputChosenSeats');
        if (inputChosenSeats) {
            inputChosenSeats.value = this.selectedSeats.join(',');
        }

        // Update submit button
        const btnSubmit = document.getElementById('btnSubmitSeats');
        if (btnSubmit) {
            btnSubmit.disabled = this.selectedSeats.length !== this.maxSeats;
        }
    }

    notifySelectionChange() {
        if (this.onSelectionChange) {
            this.onSelectionChange(this.selectedSeats);
        }
    }

    startTimer() {
        const timerElement = document.getElementById('countdownTimer');
        if (!timerElement) return;

        this.timerInterval = setInterval(() => {
            this.timeRemaining--;

            if (this.timeRemaining <= 0) {
                this.stopTimer();
                this.showNotification('Le temps de réservation est écoulé ! Les sièges ont été libérés.', 'error');
                
                if (this.onTimerEnd) {
                    this.onTimerEnd();
                } else {
                    setTimeout(() => window.location.reload(), 3000);
                }
                return;
            }

            const minutes = Math.floor(this.timeRemaining / 60);
            const seconds = this.timeRemaining % 60;
            timerElement.textContent = `Temps restant : ${minutes}:${seconds.toString().padStart(2, '0')}`;
        }, 1000);
    }

    stopTimer() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `kopv-alert kopv-alert-${type}`;
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '80px';
        notification.style.right = '24px';
        notification.style.zIndex = '9999';
        notification.style.minWidth = '300px';
        notification.style.animation = 'slideIn 0.3s ease';

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    getSelectedSeats() {
        return this.selectedSeats;
    }

    reset() {
        // Deselect all seats (support both old and new classes)
        document.querySelectorAll('.kopv-seat.selected, .kopv-seat-3d.selected').forEach(seat => {
            const seatId = seat.getAttribute('data-seat-id');
            this.deselectSeat(seat, seatId);
        });

        // Reset timer
        this.stopTimer();
        this.timeRemaining = this.timerDuration;
        this.startTimer();
    }

    destroy() {
        this.stopTimer();
        // Remove event listeners (support both old and new classes)
        document.querySelectorAll('.kopv-seat, .kopv-seat-3d').forEach(seat => {
            seat.removeEventListener('click', this.handleSeatClick);
        });
    }
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Auto-initialize if data attributes are present
document.addEventListener('DOMContentLoaded', () => {
    const seatMapContainer = document.querySelector('.kopv-seat-map-container');
    const vehicleContainer = document.querySelector('.kopv-vehicle-3d');
    
    if (seatMapContainer || vehicleContainer) {
        const container = seatMapContainer || vehicleContainer;
        const maxSeats = parseInt(container.getAttribute('data-max-seats')) || 1;
        const tripId = container.getAttribute('data-trip-id') || null;
        
        window.kopvSeatMap = new KopVSeatMap({
            maxSeats: maxSeats,
            tripId: tripId
        });
    }
});
