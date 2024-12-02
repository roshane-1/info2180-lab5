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
<ul>
<?php if (count($results) > 0): ?>
    <?php foreach ($results as $row): ?>
        <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
    <?php endforeach; ?>
<?php else: ?>
    <li>No country found.</li>
<?php endif; ?>
</ul>