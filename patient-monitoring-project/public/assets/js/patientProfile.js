
const DEFAULT_TAB = "personal"; 
// Gumamit ng per-patient key para hiwalay bawat profile
const STORAGE_KEY = `activeTab:patient:{{ $patient->id ?? 'unknown' }}`;

function applyTab(tabName) {
  // clear all tabs
  document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(c => {
    c.classList.remove('active');
    c.style.display = 'none';
  });

  // activate yung piniling tab
  const btn = document.querySelector(`.nav-tab[onclick*="${tabName}"]`);
  const pane = document.getElementById(tabName + '-tab');
  if (btn) btn.classList.add('active');
  if (pane) {
    pane.classList.add('active');
    pane.style.display = 'block';
  }
}

function switchTab(tabElement, tabName) {
  applyTab(tabName);
  // save lang habang bukas pa session
  sessionStorage.setItem(STORAGE_KEY, tabName);
}

// Restore kapag nag-load page
document.addEventListener("DOMContentLoaded", function () {
  let navType = "navigate";
  try {
    const nav = performance.getEntriesByType("navigation")[0];
    if (nav && nav.type) navType = nav.type; 
  } catch (e) {}

  if (navType === "reload" || navType === "back_forward") {
    // Reload or back/forward → ibalik yung last tab
    const saved = sessionStorage.getItem(STORAGE_KEY);
    applyTab(saved || DEFAULT_TAB);
  } else {
    // Fresh navigation (hal. galing sa Patient List o bagong open) → reset sa default
    sessionStorage.removeItem(STORAGE_KEY);
    applyTab(DEFAULT_TAB);
  }
});