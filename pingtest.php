<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ping Status</title>
</head>
<body>
    <h1>Ping Status</h1>
    <div id="result"></div>

    <script>
        // Function to perform the ping
        function pingIP(ip) {
            // Make an AJAX request to the server-side script
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'ping.php?ip=' + ip, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Display the result on the webpage
                    document.getElementById('result').innerText = xhr.responseText;
                }
            };

            xhr.send();
        }

        // Example usage
        var ipAddress = 'google.com'; // Replace with the IP address you want to ping
        pingIP(ipAddress);
    </script>
</body>
</html>
<?php
// PHP script (ping.php)
$ip = $_GET['ip']; // Get the IP address from the request parameters
exec("ping -c 4 $ip", $output, $result);

// Check the result of the ping
if ($result === 0) {
    echo "Success";
} else {
    echo "Failure";
}
?>
