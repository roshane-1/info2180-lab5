<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if the 'country' GET parameter is set
if (isset($_GET['country'])) {
    $country = $_GET['country'];
    
    // Prepare the SQL statement using LIKE for partial matching
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    
    // Adding wildcards for the LIKE clause
    $likeCountry = '%' . $country . '%';
    $stmt->bindParam(':country', $likeCountry);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no country is specified, fetch all countries
    $stmt = $conn->query("SELECT * FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

Start of the HTML table
<table border="1">
    <thead>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($results) > 0): ?>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['continent']) ?></td>
                    <td><?= htmlspecialchars($row['independence_year']) ?></td>
                    <td><?= htmlspecialchars($row['head_of_state']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No country found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>