// Search Form JavaScript

// Swap departure and arrival
document.getElementById('btnSwap').addEventListener('click', function() {
  const dep = document.getElementById('departure');
  const arr = document.getElementById('arrival');
  const tmp = dep.value;
  dep.value = arr.value;
  arr.value = tmp;
  this.classList.toggle('swapped');
});

// Passenger counter
const passInput = document.getElementById('passengers');
document.getElementById('incBtn').addEventListener('click', () => {
  const v = parseInt(passInput.value);
  if (v < 10) { 
    passInput.value = v + 1; 
    updateRecap(); 
  }
});
document.getElementById('decBtn').addEventListener('click', () => {
  const v = parseInt(passInput.value);
  if (v > 1) { 
    passInput.value = v - 1; 
    updateRecap(); 
  }
});

// Live recap update
function updateRecap() {
  const dep = document.getElementById('departure').value;
  const arr = document.getElementById('arrival').value;
  const date = document.getElementById('travel_date').value;
  const pass = document.getElementById('passengers').value;

  // Route
  const routeEl = document.getElementById('recap-route');
  if (dep && arr) {
    routeEl.textContent = dep + ' → ' + arr;
  }

  // Date
  const dateEl = document.getElementById('recap-date');
  if (date) {
    const d = new Date(date + 'T00:00:00');
    const opts = { weekday: 'short', day: 'numeric', month: 'long' };
    dateEl.textContent = d.toLocaleDateString('fr-FR', opts);
  }

  // Passengers
  const passEl = document.getElementById('recap-pass');
  passEl.textContent = pass + ' personne' + (parseInt(pass) > 1 ? 's' : '');
}

// Add event listeners for live updates
['departure','arrival','travel_date'].forEach(id => {
  document.getElementById(id).addEventListener('change', updateRecap);
});

// Initialize recap on page load
updateRecap();
