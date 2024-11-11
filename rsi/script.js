document.querySelector('.btn').addEventListener('click', function() {
    const checkIn = document.getElementById('check-in').value;
    const checkOut = document.getElementById('check-out').value;
    const destination = document.getElementById('destination').value;

    alert(`Searching for ${destination} from ${checkIn} to ${checkOut}`);
});