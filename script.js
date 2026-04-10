document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = {
        customer_name: document.getElementById('customer_name').value,
        customer_email: document.getElementById('customer_email').value,
        customer_phone: document.getElementById('customer_phone').value,
        booking_date: document.getElementById('booking_date').value,
        booking_time: document.getElementById('booking_time').value,
        number_of_people: document.getElementById('number_of_people').value,
        special_requests: document.getElementById('special_requests').value
    };

    // Send data to PHP using Fetch API
    fetch('process_booking.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        const messageDiv = document.getElementById('message');
        
        if (data.success) {
            messageDiv.innerHTML = `
                <div class="success">
                    ✅ Booking successful! Confirmation sent to ${formData.customer_email}<br>
                    Reference #: ${data.booking_id}
                </div>
            `;
            document.getElementById('bookingForm').reset();
        } else {
            messageDiv.innerHTML = `
                <div class="error">
                    ❌ ${data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        document.getElementById('message').innerHTML = `
            <div class="error">
                ❌ Connection error. Please try again.
            </div>
        `;
    });
});

// Set minimum date to today
document.getElementById('booking_date').min = new Date().toISOString().split('T')[0];