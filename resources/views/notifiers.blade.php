<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notification Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <style>
        /* Style for the notification container */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            display: none; /* Initially hide the notification */
        }
    </style>

</head>
<body>
    <div>
        <button id="notify-button">Notify Patient</button>
        <!-- Use a container for the notification message -->
        <div class="notification" id="notification-message"></div>
    </div>

    <script>
    $(document).ready(function() {
        $('#notify-button').click(function() {
            const patientId = 25; // Replace with the actual patient's ID

            // Make an AJAX POST request to trigger the notification
            $.ajax({
                url: '/api/notification/' + patientId,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // Handle the response if needed
                    console.log('Notification sent successfully');
                },
                error: function(error) {
                    // Handle errors if any
                    console.error('Error sending notification:', error);
                }
            });
        });

        // Initialize Pusher with your credentials
        const pusher = new Pusher('4deffb032112eb65cded', {
            cluster: 'ap2',
            encrypted: true
        });

        // Subscribe to the 'patient-notification' channel
        const channel = pusher.subscribe('patient-notification');

        // Listen for the 'next-patient' event
        channel.bind('next-patient25', function(data) {
            // Display the notification message
            const notification = $('#notification-message');
            notification.html(data.message).show();

            // Automatically hide the notification after a few seconds (e.g., 5 seconds)
            setTimeout(function() {
                notification.hide();
            }, 5000); // 5000 milliseconds (5 seconds)
        });

    });
    </script>
</body>
</html>
