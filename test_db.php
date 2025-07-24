<?php
// Test Database Connection
echo "🔍 Testing Database Connection...<br><br>";

echo "📋 Configuration:<br>";
echo "Host: localhost<br>";
echo "Database: bngshopi_bng_shop<br>";
echo "User: bngshopi_masiha1380<br>";
echo "Password: " . (strlen('masihabadboy') > 0 ? "✅ Set (" . strlen('masihabadboy') . " chars)" : "❌ Empty") . "<br><br>";

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=bngshopi_bng_shop;charset=utf8mb4",
        'bngshopi_masiha1380',
        'masihabadboy',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    
    echo "✅ Database connection successful!<br>";
    
    // Test query
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();
    
    echo "<br>📊 Tables in database:<br>";
    if (empty($tables)) {
        echo "❌ No tables found. Please run the SQL schema first.<br>";
    } else {
        foreach ($tables as $table) {
            echo "✅ " . $table[array_keys($table)[0]] . "<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "<br>";
    echo "<br>🔧 Possible solutions:<br>";
    echo "1. Check database name: bngshopi_bng_shop<br>";
    echo "2. Check username: bngshopi_masiha1380<br>";
    echo "3. Check password in cPanel<br>";
    echo "4. Make sure user has privileges on the database<br>";
}
?>