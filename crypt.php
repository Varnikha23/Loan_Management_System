<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vigenère Cipher</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-image: url('crypt.jpg'); /* Add your image here */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            color: white; /* Change text color for better visibility */
        }

        .container {
            max-width: 600px;
            margin: 50px auto; /* Center the container */
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background for readability */
            border-radius: 10px; /* Rounded corners */
        }

        h1 {
            text-align: center;
        }

        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #7bff00;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #15b300;
        }

        .instructions {
            margin: 20px 0;
            padding: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        .instructions h2 {
            text-align: center;
        }

        .instructions ul {
            list-style: none;
            padding: 0;
        }

        .instructions ul li {
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cryptographic Communication</h1>
        <div class="instructions">
            <h2>How to Use</h2>
            <ul>
            Step 1: Make sure it is in encryption mode.<br>
            Step 2: Enter any text in the text box below the encryption mode button.<br>
            Step 3: Press the process button.<br>
            Step 4: Enter a key of your choice.<br>
            Step 5: Encrypted text will be displayed to you below the process button.<br>
            Step 6: Copy the encrypted text.<br>
            Step 7: Change the mode to decryption mode.<br>
            Step 8: Paste the encrypted text in the text box.<br>
            Step 9: Press the process button.<br>
            Step 10: Enter the key entered before.<br>
            Step 11: The original text is displayed.<br>
            </ul>
        </div>
        <select id="mode">
            <option value="0">Encoding Mode</option>
            <option value="1">Decoding Mode</option>
        </select>
        <textarea id="inputText" placeholder="Enter your text here..."></textarea>
        <button id="processBtn">Process</button>
        <h2>Result:</h2>
        <div id="result"></div>
    </div>

    <script>
        document.getElementById('processBtn').addEventListener('click', () => {
            const mode = parseInt(document.getElementById('mode').value);
            const inputText = document.getElementById('inputText').value;

            let result;
            const key = prompt("Enter the keyword:");

            if (mode === 1) {
                const decryptionKey = prompt("Enter the same keyword for decryption:");
                if (key !== decryptionKey) {
                    alert("Error: The keys do not match. Please enter the same key for encryption and decryption.");
                    return;
                }
            }

            const generatedKey = generateKey(inputText, key);

            if (mode === 0) {
                result = cipherText(inputText, generatedKey);
            } else {
                result = originalText(inputText, generatedKey);
            }

            document.getElementById('result').innerText = matchCase(inputText, result);
        });

        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        function generateKey(string, key) {
            key = key.toUpperCase();
            let keyArray = [];
            let keyIndex = 0;

            for (let i = 0; i < string.length; i++) {
                if (alphabet.includes(string[i].toUpperCase())) {
                    keyArray.push(key[keyIndex % key.length]);
                    keyIndex++;
                } else {
                    keyArray.push(string[i]);
                }
            }
            return keyArray.join('');
        }

        function cipherText(string, key) {
            let cipherText = '';
            for (let i = 0; i < string.length; i++) {
                if (alphabet.includes(string[i].toUpperCase())) {
                    let x = (alphabet.indexOf(string[i].toUpperCase()) + alphabet.indexOf(key[i])) % 26;
                    cipherText += alphabet[x];
                } else {
                    cipherText += string[i];
                }
            }
            return cipherText;
        }

        function originalText(cipherText, key) {
            let originalText = '';
            for (let i = 0; i < cipherText.length; i++) {
                if (alphabet.includes(cipherText[i].toUpperCase())) {
                    let x = (alphabet.indexOf(cipherText[i].toUpperCase()) - alphabet.indexOf(key[i]) + 26) % 26;
                    originalText += alphabet[x];
                } else {
                    originalText += cipherText[i];
                }
            }
            return originalText;
        }

        function matchCase(original, transformed) {
            let result = '';
            for (let i = 0; i < original.length; i++) {
                if (original[i] === original[i].toUpperCase()) {
                    result += transformed[i].toUpperCase();
                } else if (original[i] === original[i].toLowerCase()) {
                    result += transformed[i].toLowerCase();
                } else {
                    result += transformed[i];
                }
            }
            return result;
        }
    </script>
</body>
</html>
