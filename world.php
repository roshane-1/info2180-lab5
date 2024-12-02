<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if the 'lookup' parameter is set
if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
    // If the lookup is for cities
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = $_GET['country'];
        
        // SQL query to get cities for the specified country
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population 
            FROM cities 
            JOIN countries ON cities.country_code = countries.code 
            WHERE countries.name LIKE :country
        ");
        
        $likeCountry = '%' . $country . '%';
        $stmt->bindParam(':country', $likeCountry);
        $stmt->execute();
    } else {
        // If no country is specified, fetch all cities
        $stmt = $conn->query("
            SELECT cities.name AS city_name, cities.district, cities.population 
            FROM cities
        ");
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results in an HTML table for cities
    echo '<table border="1">
            <thead>
                <tr>
                    <th>City Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>';
    
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['city_name']) . '</td>
                    <td>' . htmlspecialchars($row['district']) . '</td>
                    <td>' . htmlspecialchars($row['population']) . '</td>
                </tr>';
        }
    } else {
        echo '<tr>
                <td colspan="3">No cities found.</td>
            </tr>';
    }
    
    echo '</tbody>
        </table>';
} else {
    // If the lookup is for countries
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $country = $_GET['country'];
        
        // Prepare the SQL statement using LIKE for partial matching for countries
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        
        $likeCountry = '%' . $country . '%';
        $stmt->bindParam(':country', $likeCountry);
        $stmt->execute();
    } else {
        // If no country is specified, fetch all countries
        $stmt = $conn->query("SELECT * FROM countries");
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results in an HTML table for countries
    echo '<table border="1">
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>';
    
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['continent']) . '</td>
                    <td>' . htmlspecialchars($row['independence_year']) . '</td>
                    <td>' . htmlspecialchars($row['head_of_state']) . '</td>
                </tr>';
        }
    } else {
        echo '<tr>
                <td colspan="4">No countries found.</td>
            </tr>';
    }
    
    echo '</tbody>
        </table>';
}
?>
