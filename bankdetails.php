<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Details</title>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
  <style>
    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: black;
      text-align: center;
      font-size: 16px;
      margin: 0;
      padding: 0;
      background-image: url('assets/images/top-view-office-desk-with-growth-chart-coins.jpg'); /* Add your background image path */
      background-size: cover;
      background-position: center;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the background */
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.5s ease-in-out; /* Add fadeIn animation */
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
      color: #156dab; /* Change heading color */
      animation: slideDown 0.5s ease-in-out; /* Add slideDown animation */
    }

    @keyframes slideDown {
      from {
        transform: translateY(-50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    p {
      font-size: 1.1em;
      margin-bottom: 10px;
      color: #333; /* Change paragraph color */
    }

    .bank-details {
      text-align: left;
      margin-bottom: 20px;
    }

    .bank-details p {
      margin: 5px 0;
    }

    .confirm-button {
      background-color: #156dab;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 20px;
      font-size: 0.9em; /* Increase button font size */
      font-weight: 600;
      border-radius: 8px;
      text-transform: uppercase;
      letter-spacing: 2px; /* Reduce letter spacing */
      display: inline-block;
      cursor: pointer;
      border: none; /* Remove button border */
      transition: background-color 0.3s ease; /* Add transition effect */
      margin-top: 20px; /* Add some top margin */
      animation: slideUp 0.5s ease-in-out; /* Add slideUp animation */
    }

    .confirm-button:hover {
      background-color: #1b8ad8;
    }

    @keyframes slideUp {
      from {
        transform: translateY(50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .additional-details {
      margin-top: 20px;
      animation: fadeIn 0.5s ease-in-out; /* Add fadeIn animation */
    }

    .additional-details p {
      margin: 5px 0;
    }

    input[type="radio"] {
      -webkit-appearance: none; /* Remove default appearance */
      -moz-appearance: none; /* Remove default appearance */
      appearance: none; /* Remove default appearance */
      width: 20px; /* Set width of the radio button */
      height: 20px; /* Set height of the radio button */
      border: 2px solid #156dab; /* Add border */
      border-radius: 50%; /* Make it round */
      outline: none; /* Remove outline */
      cursor: pointer; /* Add cursor pointer */
      margin-right: 5px; /* Add some space between radio button and label */
      animation: fadeIn 0.5s ease-in-out; /* Add fadeIn animation */
    }

    /* Custom styles for radio button when checked */
    input[type="radio"]:checked {
      background-color: #156dab; /* Change background color when checked */
    }

    /* Custom styles for radio button label */
    label {
      display: inline-block; /* Make labels inline */
      margin-bottom: 10px; /* Add margin bottom */
      cursor: pointer; /* Add cursor pointer */
      animation: slideRight 0.5s ease-in-out; /* Add slideRight animation */
    }

    @keyframes slideRight {
      from {
        transform: translateX(-50px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* Custom styles for radio button label text */
    label span {
      vertical-align: middle; /* Align text vertically */
    }

    .payment-method-text {
      color: black; /* Set text color to black */
      font-weight: bold; /* Set font weight to bold */
      animation: slideLeft 0.5s ease-in-out; /* Add slideLeft animation */
    }

    @keyframes slideLeft {
      from {
        transform: translateX(50px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Payment Details</h1>
    <div class="bank-details">
      <p><strong>Bank Name:</strong>State Bank of India</p>
      <p><strong>Account Number:</strong>XXXX7643</p>
      <p><strong>IFSC Code:</strong> XXXX1234</p>
      <p><strong>Branch:</strong>SBI Manek Chowk</p>
      <p><strong>Branch Address:</strong>Manek Chowk,Porbandar,Gujrat</p>
      <p><strong>UPI:</strong>kagdasakshi09@oksbi</p>
      <!-- Add more details as needed -->
    </div>
    <form id="paymentForm" method="post" action="send_email.php" onsubmit="return submitForm()">
      <div class="payment-method-text">Please select a payment method:</div>
      <label><input type="radio" name="paymentMethod" value="bankTransfer" checked> Bank Account Transfer</label><br>
      <label><input type="radio" name="paymentMethod" value="upiPayment"> UPI ID Payment</label><br>
      <button class="confirm-button" type="submit">Confirm Payment</button>
      <input type="hidden" name="confirm_payment">
    </form>
    <div class="additional-details">
      <p>For any queries, contact support@example.com
      </p>
    </div>
  </div>
  <script>
    function submitForm() {
      // Simulate email sent successfully
      var emailSent = true; // You need to implement this logic based on your email sending process
      
      if (emailSent) {
        alert("Email sent successfully!");
        setTimeout(function() {
          window.location.href = "thank_you.php";
        }, 1000); // Delay redirection by 100 milliseconds
        return true; // Proceed with form submission
      } else {
        alert("Failed to send email. Please try again.");
        return false; // Prevent form submission
      }
    }
  </script>
</body>
</html>
