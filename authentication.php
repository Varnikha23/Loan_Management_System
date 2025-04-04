<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eye Blink Authentication</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        #video {
            width: 640px;
            height: 480px;
            border: 1px solid black;
            margin-bottom: 20px;
        }

        #message {
            font-size: 24px;
            margin-top: 10px;
        }

        #message.success {
            color: green;
        }

        #message.error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Eye Blink Authentication</h1>
    <video id="video" autoplay></video>
    <button id="start-auth">Start Authentication</button>
    <div id="message"></div>

    <script>
        const videoElement = document.getElementById('video');
        const messageElement = document.getElementById('message');
        const authCode = "..-."; // Authentication code: 3 short blinks
        let morseSequence = "";
        let detecting = false;

        // Access the webcam
        async function requestWebcamAccess() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                videoElement.srcObject = stream;
                videoElement.play();
            } catch (error) {
                console.error("Error accessing the webcam: ", error);
                alert("Unable to access the webcam. Please allow access and refresh the page.");
            }
        }

        // Simulated Blink Detection
        function simulateBlinkDetection() {
            // Simulates eye blinks for demonstration purposes
            setInterval(() => {
                if (detecting) {
                    const blinkType = Math.random() < 0.8 ? "." : "-"; // 80% chance of short blink
                    morseSequence += blinkType;
                    console.log(`Detected Blink: ${blinkType}`);
                    updateMessage(`Detected Blink: ${morseSequence}`);
                    checkAuthentication();
                }
            }, 1000); // Check every 1 second
        }

        // Update message display
        function updateMessage(text, isSuccess = false) {
            messageElement.textContent = text;
            messageElement.className = isSuccess ? "success" : "error";
        }

        // Check authentication by comparing morseSequence with authCode
        function checkAuthentication() {
            if (morseSequence === authCode) {
                updateMessage("Authentication Successful!", true);
                detecting = false;
                setTimeout(() => {
                    window.location.href = 'home.php';
                }, 2000);
            } else if (morseSequence.length >= authCode.length) {
                updateMessage("Authentication Failed. Try Again.");
                morseSequence = ""; // Reset sequence on failure
            }
        }

        // Start authentication process
        document.getElementById('start-auth').addEventListener('click', async () => {
            morseSequence = ""; // Reset morse sequence
            updateMessage(""); // Clear previous messages
            detecting = true; // Enable detection
            await requestWebcamAccess();
            simulateBlinkDetection();
        });
        function checkAuthentication() {
    if (morseSequence === authCode) {
        messageElement.textContent = "Authentication Successful!";
        messageElement.className = "success";
        detecting = false;
        setTimeout(() => {
            window.location.href = 'index.php?page=dashboard'; // Redirects to the dashboard
        }, 2000); // Delay to show the success message
    } else if (morseSequence.length >= authCode.length) {
        messageElement.textContent = "Authentication Failed. Try Again.";
        messageElement.className = "error";
        morseSequence = ""; // Reset sequence on failure
    }
}

    </script>
    
</body>

</html>


