<?php
// Database Setup Script for Heroku Student Portal
// Access this file via browser to initialize the database
// Delete this file after successful setup for security

echo "<h1>Student Portal Database Setup</h1>";

// Get database URL from Heroku environment
$databaseUrl = getenv('JAWSDB_URL');

if (!$databaseUrl) {
    echo "<p style='color: red;'>❌ ERROR: JAWSDB_URL environment variable not found!</p>";
    echo "<p>Make sure you've added the JawsDB MySQL add-on to your Heroku app.</p>";
    exit;
}

echo "<p>🔍 Found database configuration...</p>";

// Parse the database URL
$urlParts = parse_url($databaseUrl);

$host = $urlParts['host'];
$port = $urlParts['port'] ?? 3306;
$dbname = substr($urlParts['path'], 1);
$username = $urlParts['user'];
$password = $urlParts['pass'];

echo "<p>📡 Connecting to database...</p>";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p style='color: green;'>✅ Database connection successful!</p>";

    // Read the schema file
    $schemaFile = 'database/schema.sql';

    if (!file_exists($schemaFile)) {
        echo "<p style='color: red;'>❌ ERROR: schema.sql file not found!</p>";
        exit;
    }

    echo "<p>📄 Reading schema file...</p>";

    $schema = file_get_contents($schemaFile);

    // Split into individual statements (by semicolon)
    $statements = explode(';', $schema);

    $successCount = 0;
    $errorCount = 0;

    echo "<p>⚙️ Executing database setup...</p>";
    echo "<div style='background: #f5f5f5; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 12px; max-height: 300px; overflow-y: auto;'>";

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement) && !preg_match('/^--/', $statement)) { // Skip comments
            try {
                $pdo->exec($statement);
                echo "<span style='color: green;'>✓</span> " . substr(str_replace("\n", " ", $statement), 0, 80) . "...<br>";
                $successCount++;
            } catch (PDOException $e) {
                echo "<span style='color: red;'>✗</span> " . substr(str_replace("\n", " ", $statement), 0, 80) . "...<br>";
                echo "<span style='color: red; margin-left: 20px;'>Error: " . $e->getMessage() . "</span><br>";
                $errorCount++;
            }
        }
    }

    echo "</div>";

    if ($errorCount == 0) {
        echo "<p style='color: green; font-weight: bold;'>🎉 Database setup completed successfully!</p>";
        echo "<p>✅ $successCount SQL statements executed</p>";
        echo "<p>🚀 Your Student Portal is now ready!</p>";
        echo "<p><a href='/' style='background: #10b981; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Student Portal</a></p>";
        echo "<p style='color: orange; font-weight: bold;'>⚠️ SECURITY NOTICE: Delete this setup_db.php file immediately after setup!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Setup completed with $errorCount errors. Some tables might already exist.</p>";
        echo "<p>Try accessing the portal to see if it works: <a href='/'>Student Portal</a></p>";
    }

} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Check your JawsDB MySQL add-on configuration in Heroku.</p>";
}
?>