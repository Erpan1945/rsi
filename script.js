document.getElementById('submitReview').addEventListener('click', function() {
    // Ambil nilai dari input feedback
    var feedback = document.getElementById('feedback').value;
    var fullname = document.getElementById('fullname').value;
    var phonenumber = document.getElementById('phonenumber').value;
    var destination = document.getElementById('destination').value;
    var rating = document.querySelector('input[name="star"]:checked'); // Ambil rating yang dipilih

    // Periksa apakah feedback kosong
    if (feedback.trim() === "") {
        showModal(); // Tampilkan modal peringatan
    } else if (!fullname || !phonenumber || !destination || !rating) {
        showModal(); // Tampilkan modal peringatan jika ada input yang kosong
    } else {
        // Siapkan data untuk dikirim
        var data = {
            fullname: fullname,
            phonenumber: phonenumber,
            destination: destination,
            rating: rating.value, // Ambil nilai dari rating yang dipilih
            feedback: feedback
        };

        // Kirim data ke server
        fetch('save_feedback.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessModal(); // Tampilkan modal sukses
            } else {
                alert('Error: ' + data.message); // Tampilkan pesan kesalahan
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data.' + error.message); // Tampilkan pesan error
        });
    }
});

function showModal() {
    document.getElementById('feedbackModal').style.display = "block";
}

function closeModal() {
    document.getElementById('feedbackModal').style.display = "none";
}

function showSuccessModal() {
    document.getElementById('successModal').style.display = "block";
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = "none";
    // Kembali ke halaman transaksi setelah menutup modal
    window.location.href = 'transaction.html'; // Ganti dengan URL halaman transaksi Anda
}   