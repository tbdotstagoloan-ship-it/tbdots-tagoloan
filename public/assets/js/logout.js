
  document.getElementById('logout-btn').addEventListener('click', function (e) {
    Swal.fire({
      title: "Are you sure?",
      text: "You want to log out?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: 'Yes, log me out',
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  });