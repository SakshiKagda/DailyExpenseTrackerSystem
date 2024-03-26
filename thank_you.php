<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You for Subscription</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap');

    body {
      font-family: 'Source Sans Pro', Arial, sans-serif;
      color: #333;
      text-align: center;
      font-size: 16px;
      margin: 0;
      padding: 0;
      background-image:  url('assets/images/top-view-office-desk-with-growth-chart-coins.jpg');
      background-size: cover;
      background-attachment: fixed;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 40px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(5px);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      font-size: 2.5em;
      margin-bottom: 20px;
      color: #007bff;
      font-weight: 700;
    }

    p {
      font-size: 1.1em;
      margin-bottom: 20px;
      color: #555;
      line-height: 1.5;
    }
    .btn-go-use {
  background-color: #007bff; /* Darker shade of sky blue */
  color: #fff;
  text-decoration: none;
  padding: 10px 20px;
  font-size: 0.9em;
  font-weight: 600;
  border: none;
  border-radius: 5px;
  text-transform: uppercase;
  letter-spacing: 1px;
  display: inline-block;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.btn-go-use:hover {
  background-color: #5eacb8; /* Darker shade of sky blue on hover */
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}


.features-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 20px;
  width: 100%;
  margin-top: 30px;
}

.feature {
  flex: 0 1 calc(30% - 10px);
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  text-align: left;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
  margin-bottom: 20px;
}

.feature:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.feature:last-child {
  margin-right: 0;
}

.feature h2 {
  color: #007bff;
  font-size: 1.4em;
  margin-bottom: 10px;
  font-weight: 600;
}

.feature p {
  color: #555;
  font-size: 1em;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>Thank You for Subscribing!</h1>
    <p>Welcome to our premium subscription service. You are now a valued member, and we are thrilled to have you on board.</p>
    <div class="features-container">
      <div class="feature">
        <h2>Report PDF Generator</h2>
        <p>Generate detailed PDF reports with ease to keep track of your activities and progress.</p>
      </div>
      <div class="feature">
        <h2>Notification</h2>
        <p>Stay updated with real-time notifications about important events and announcements.</p>
      </div>
      <div class="feature">
        <h2>Add Bill Image</h2>
        <p>Attach bill images to your transactions for better record-keeping and organization.</p>
      </div>
    </div>
    <a href="demo.php" class="btn-go-use">Get Instant Access Now!</a>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
