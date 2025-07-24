<?php
echo "🔍 Site Check - " . date('Y-m-d H:i:s') . "<br><br>";
echo "📍 Current URL: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "<br>";
echo "📂 Current Directory: " . __DIR__ . "<br>";
echo "📄 This file: " . __FILE__ . "<br><br>";

echo "✅ PHP is working!<br>";
echo "🌐 Domain: bngshop.ir<br>";
echo "⚡ Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br><br>";

echo "If you see this, the hosting is working correctly.<br>";
echo "Next step: Upload the correct files from GitHub.";
?>