document.getElementById('reservationForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form from refreshing

    const data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        date: document.getElementById('date').value,
        guests: document.getElementById('guests').value
    };

    fetch('https://lacasadelcangrejo.com/proxy.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => response.text()) // Expect plain text response
        .then(result => {
            // Show a clean success message
            alert(result); // Pop-up displays "Reservación realizada con éxito"
            document.getElementById('reservationForm').reset();
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors
            alert('Error al guardar la reserva. Intenta nuevamente.');
        });
});
