
    document.getElementById('pat_date_of_birth').addEventListener('change', function () {
      const dob = new Date(this.value);
      const today = new Date();

      if (isNaN(dob.getTime())) return; // if invalid date, exit

      let years = today.getFullYear() - dob.getFullYear();
      let months = today.getMonth() - dob.getMonth();
      let days = today.getDate() - dob.getDate();

      if (days < 0) {
        months--;
        days += new Date(today.getFullYear(), today.getMonth(), 0).getDate();
      }

      if (months < 0) {
        years--;
        months += 12;
      }

      // Display as "X years Y months"
      document.getElementById('pat_age').value = `${years} years ${months} months`;
    });
