// Medication Adherence Calendar Implementation

let currentDate = new Date();
let confirmedDates = [];
let missedDates = [];
const treatmentStartDate = new Date(2025, 8, 3); // September 3, 2025
const totalTreatmentDays = 180;

// Initialize calendar when tab is shown
function initAdherenceCalendar() {
  loadMedicationData();
  renderCalendar();
  updateStats();
}

// Fetch medication data from Laravel backend
async function loadMedicationData() {
  try {
    const username = getCurrentUsername(); // Get logged-in username
    
    // Option 1: Using combined endpoint (recommended)
    const response = await fetch(`/api/combined-logs?username=${username}`);
    const data = await response.json();
    
    if (response.ok) {
      confirmedDates = data.confirmed.map(log => new Date(log.date));
      missedDates = data.missed.map(log => new Date(log.date));
    } else {
      console.error('Error fetching logs:', data.message);
    }
    
    /* Option 2: Separate endpoints
    const confirmedResponse = await fetch(`/api/medication-logs?username=${username}`);
    const confirmedData = await confirmedResponse.json();
    confirmedDates = confirmedData.map(log => new Date(log.date));
    
    const missedResponse = await fetch(`/api/missed-logs?username=${username}`);
    const missedData = await missedResponse.json();
    missedDates = missedData.map(log => new Date(log.date));
    */
    
    renderCalendar();
    updateStats();
  } catch (error) {
    console.error('Error loading medication data:', error);
  }
}

// Check if a date is confirmed
function isConfirmed(date) {
  return confirmedDates.some(d => 
    d.getDate() === date.getDate() &&
    d.getMonth() === date.getMonth() &&
    d.getFullYear() === date.getFullYear()
  );
}

// Check if a date is missed
function isMissed(date) {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const checkDate = new Date(date);
  checkDate.setHours(0, 0, 0, 0);
  
  // Don't mark dates before treatment start
  if (checkDate < treatmentStartDate) {
    return false;
  }
  
  // If date is before today and not confirmed, it's missed
  if (checkDate < today && !isConfirmed(date)) {
    return true;
  }
  
  return false;
}

// Render the calendar
function renderCalendar() {
  const calendar = document.getElementById('calendar');
  const monthYear = document.getElementById('monthYear');
  
  const year = currentDate.getFullYear();
  const month = currentDate.getMonth();
  
  // Set month/year header
  const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'];
  monthYear.textContent = `${monthNames[month]} ${year}`;
  
  // Clear calendar
  calendar.innerHTML = '';
  
  // Add day headers
  const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  dayHeaders.forEach(day => {
    const header = document.createElement('div');
    header.className = 'adherence-calendar-day-header';
    header.textContent = day;
    calendar.appendChild(header);
  });
  
  // Get first day of month and number of days
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  
  // Add empty cells for days before month starts
  for (let i = 0; i < firstDay; i++) {
    const emptyCell = document.createElement('div');
    emptyCell.className = 'adherence-calendar-day';
    calendar.appendChild(emptyCell);
  }
  
  // Add days of month
  const today = new Date();
  for (let day = 1; day <= daysInMonth; day++) {
    const date = new Date(year, month, day);
    const dayCell = document.createElement('div');
    dayCell.className = 'adherence-calendar-day';
    
    // Check if it's today
    if (date.toDateString() === today.toDateString()) {
      dayCell.classList.add('adherence-today');
    }
    
    const dayNumber = document.createElement('div');
    dayNumber.className = 'adherence-day-number';
    dayNumber.textContent = day;
    dayCell.appendChild(dayNumber);
    
    // Add indicator for confirmed or missed
    if (isConfirmed(date)) {
      const indicator = document.createElement('div');
      indicator.className = 'adherence-indicator adherence-taken';
      indicator.innerHTML = '<i class="fa fa-check"></i>';
      dayCell.appendChild(indicator);
    } else if (isMissed(date)) {
      const indicator = document.createElement('div');
      indicator.className = 'adherence-indicator adherence-missed';
      indicator.innerHTML = '<i class="fa fa-times"></i>';
      dayCell.appendChild(indicator);
    }
    
    calendar.appendChild(dayCell);
  }
}

// Update statistics
function updateStats() {
  const daysTaken = confirmedDates.length;
  const daysMissed = missedDates.length;
  const adherenceRate = totalTreatmentDays > 0 
    ? Math.round((daysTaken / totalTreatmentDays) * 100) 
    : 0;
  
  document.getElementById('adherenceRate').textContent = `${adherenceRate}%`;
  document.getElementById('daysTaken').textContent = daysTaken;
  document.getElementById('daysMissed').textContent = daysMissed;
}

// Navigation buttons
document.getElementById('prevMonth').addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() - 1);
  renderCalendar();
});

document.getElementById('nextMonth').addEventListener('click', () => {
  currentDate.setMonth(currentDate.getMonth() + 1);
  renderCalendar();
});

// Helper function to get current username (implement based on your auth system)
function getCurrentUsername() {
  // Replace with your actual method to get logged-in username
  return sessionStorage.getItem('username') || localStorage.getItem('username');
}

// Initialize when adherence tab is clicked
document.querySelector('[data-tab="adherence-tab"]')?.addEventListener('click', () => {
  initAdherenceCalendar();
});