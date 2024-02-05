<?php  session_start();
    include 'connect.php';
    
    if (!isset($_SESSION['user_id_input'])) {
        $_SESSION['msg'] = "กรุณาล็อกอินก่อน!";
        header('location: login_process.php');
        exit();
    }
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['user_id_input']);
        header('location: login_process.php');
    } 
    if (isset($_GET['subButtonValue'])) {
      $selectedValue = $_GET['subButtonValue'];
      
    } else {
      session_destroy();
      unset($_SESSION['user_id_input']);
      header('location: login_process.php');
    }

  ?>
    


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light"
  rel="stylesheet" type="text/css">
  <title>Switch Management</title>
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #E7E0DD; /* Light grey background */
    }

    .background-container {
      text-align: center;
      background-color: #ffffff; /* White background for the container */
      padding: 50px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }
    h2 {

      justify-content: center;
      text-align: center;
      margin-bottom: 30px; /* Add some spacing below the heading */
      margin-left: 0px;
    }

    .container {
      text-align: center;
      display: flex;
      align-items: center;
    }

    select {
      width: 250px; /* Set a fixed width for the select element */
      max-width: 100%;
      font-family: 'Open Sans', sans-serif;
      height: 60px; /* Set a fixed height for the dropdown */
      margin-bottom: 0px;
      margin-left: 0px;
      padding: 12px; /* Increase padding for a larger dropdown */
      font-size: 18px; /* Customize font size */
      border: 4px solid purple; /* Add border */
      border-radius: 8px; /* Add border radius */
      background-color: #f5f5f5; /* Light grey background color */
      color: black; /* Text color */
      transition: transform 0.3s ease-in-out;
      overflow: hidden;
    }

    select:hover {
      transform: scale(1.05); /* Scale up on hover */
    }

    #details-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 5px;
    }

    #details {
        color: grey;
      font-size: 16px;
      text-align: center; /* Center the text */
    }
    .submit-button {
      text-align: center;
      margin-top: 30px;
      margin-left: 25px;
      width: 200px;
      height: 60px;
      background-color: purple;
      color: white;
      border: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border-radius: 15px;
      cursor: pointer;
      font-size: 18px;
    }

    .submit-button:hover {
      background-color: #E7E0DD;
      color: purple;
      transform: scale(1.1);
    }
  </style>
</head>
<body>
                                                    
    <div class="background-container">
        <h2><?= $selectedValue?></h2>

        <?php
$query = "SELECT dell_name, dell_ip, riujie_name, riujie_ip, zerotrust_name, zerotrust_ip, watchguard_name, watchguard_ip, fortigate_name, fortigate_ip FROM place_ne3 WHERE name_place = :selectedValue";
$stmt = $conn->prepare($query);
$stmt->bindParam(':selectedValue', $selectedValue, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <select id="textDropdown" onchange="showDetails()">
        <option value="" disabled selected>-กรุณาเลือก switch-</option>

        <?php
        foreach ($rows as $row) {
            foreach (['dell', 'riujie', 'watchguard', 'zerotrust', 'fortigate'] as $prefix) {
                $nameKey = $prefix . '_name';
                $ipKey = $prefix . '_ip';

                if ($row[$nameKey] !== null) {
                    echo "<option value=\"{$row[$nameKey]}\" data-details=\"{$row[$ipKey]}\">{$row[$nameKey]}</option>";
                }
            }
        }
        ?>
    </select>
</div>
    
        <div id="details-container">
            <div id="details"></div>
          </div>
    
        <div class="container">
          <button class="submit-button" onclick="redirectToPage()">ตกลง</button>
        </div>
        
      </div>
  
    <script>
      function showDetails() {
      const select = document.getElementById('textDropdown');
      const detailsDiv = document.getElementById('details');
      const selectedOption = select.options[select.selectedIndex];
      const details = selectedOption.getAttribute('data-details');
      detailsDiv.textContent = `IP: ${details}`;
    }
   
    function redirectToPage() {
    const select = document.getElementById('textDropdown');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value === "") {
        alert("กรุณาเลือก Switch");
        return; // Prevent further execution
    }

    const ipAddress = selectedOption.getAttribute('data-details');
    const switchName = selectedOption.value;

    // Check if the switch name starts with "WatchGuard" and modify the IP address accordingly
    if (switchName.startsWith('WatchGuard')) {
        // Add ":8080" to the IP address for WatchGuard
        window.open(`http://${ipAddress}:8080`, '_blank');
    } else {
        // Redirect to the IP address
        window.open(`http://${ipAddress}`, '_blank');
    }
}




    </script>

</body>
</html>
