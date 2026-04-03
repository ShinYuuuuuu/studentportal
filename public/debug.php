<?php
// Debug page for Student Portal
echo "<h1>Student Portal Debug</h1>";
echo "<h2>Environment Check</h2>";

// Check PHP version
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";

// Check database environment variable
$jawsdbUrl = getenv('JAWSDB_URL');
if ($jawsdbUrl) {
    echo "<p style='color: green;'><strong>✅ JawsDB URL found</strong></p>";

    // Parse URL to check components
    $urlParts = parse_url($jawsdbUrl);
    echo "<p><strong>Host:</strong> " . ($urlParts['host'] ?? 'N/A') . "</p>";
    echo "<p><strong>Database:</strong> " . (substr($urlParts['path'] ?? '', 1) ?: 'N/A') . "</p>";
    echo "<p><strong>Username:</strong> " . ($urlParts['user'] ?? 'N/A') . "</p>";
    echo "<p><strong>Password:</strong> " . (isset($urlParts['pass']) ? '***' : 'N/A') . "</p>";

    // Test database connection
    echo "<h3>Database Connection Test</h3>";
    try {
        $pdo = new PDO(
            "mysql:host=" . $urlParts['host'] . ";dbname=" . substr($urlParts['path'], 1) . ";charset=utf8",
            $urlParts['user'],
            $urlParts['pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<p style='color: green;'>✅ Database connection successful!</p>";

        // Test if tables exist
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo "<p><strong>Tables found:</strong> " . count($tables) . "</p>";
        if (count($tables) > 0) {
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color: orange;'>⚠️ No tables found. Run <a href='/setup_db.php'>setup_db.php</a> to initialize the database.</p>";
        }

    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    }

} else {
    echo "<p style='color: red;'>❌ JawsDB URL not found! Make sure JawsDB MySQL add-on is installed.</p>";
}

echo "<hr>";
echo "<p><a href='/'>← Back to Student Portal</a></p>";
echo "<p><a href='/setup_db.php'>Run Database Setup</a></p>";
?>