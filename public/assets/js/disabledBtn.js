
document.addEventListener("DOMContentLoaded", function () {
    const submitBtn = document.getElementById("submitBtn");
    if (!submitBtn) return;

    // Get the form that contains the submit button (not the logout form)
    const form = submitBtn.closest("form");
    if (!form) return;

    // All relevant fields EXCLUDING hidden inputs
    const fields = form.querySelectorAll("input:not([type='hidden']), select, textarea");

    function checkInputs() {
        let hasValue = Array.from(fields).some(el => {
            if (el.tagName === "SELECT") {
                // True if a real option is selected
                return el.value && el.value.trim() !== "";
            }
            if (el.type === "checkbox" || el.type === "radio") {
                return el.checked;
            }
            return el.value && el.value.trim() !== "";
        });

        submitBtn.disabled = !hasValue;
    }

    // Listen to input/change on all fields
    fields.forEach(el => {
        el.addEventListener("input", checkInputs);
        el.addEventListener("change", checkInputs);
    });

    // Initial check (on page load)
    checkInputs();
});