<?php
// Simple test page for Heroku deployment
echo "<h1>Student Portal - Basic Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
echo "<h2>Database Test</h2>";
$jawsdbUrl = getenv('JAWSDB_URL');
if ($jawsdbUrl) {
    echo "<p style='color: green;'>✅ JawsDB URL found</p>";
    try {
        $urlParts = parse_url($jawsdbUrl);
        $pdo = new PDO(
            "mysql:host=" . $urlParts['host'] . ";dbname=" . substr($urlParts['path'], 1) . ";charset=utf8",
            $urlParts['user'],
            $urlParts['pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p style='color: green;'>✅ Database connection successful!</p>";

        // Check tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Tables found: " . count($tables) . "</p>";
        if (count($tables) > 0) {
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
        }

    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ JawsDB URL not found</p>";
}

echo "<hr>";
echo "<p><a href='/debug.php'>Go to Debug Page</a></p>";
echo "<p><a href='/setup_db.php'>Run Database Setup</a></p>";
?>