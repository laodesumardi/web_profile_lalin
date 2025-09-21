<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illwarewmi\LaravelScheduler\Kernel::class);

$app->instance('request', new Illuminate\Http\Request(
    $_GET,
    $_POST,
    [],
    $_COOKIE,
    $_FILES,
    $_SERVER,
    ''
));

$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

$users = DB::table('users')->get();

echo "<h2>Photo Debug Information</h2>";
echo "<h3>Storage Information:</h3>";
echo "Storage Path: " . storage_path('app/public') . "<br>";
echo "Public Storage: " . public_path('storage') . "<br>";
echo "Storage Link Exists: " . (is_link(public_path('storage')) ? 'Yes' : 'No') . "<br><br>";

echo "<h3>User Photos:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>Photo Path</th><th>File Exists</th><th>Full Path</th><th>Preview</th></tr>";

foreach ($users as $user) {
    $photoPath = $user->photo;
    $fullPath = $photoPath ? storage_path('app/public/' . ltrim($photoPath, '/')) : '';
    $fileExists = $photoPath ? (file_exists($fullPath) ? 'Yes' : 'No') : 'No photo';
    
    echo "<tr>";
    echo "<td>{$user->id}</td>";
    echo "<td>{$user->name}</td>";
    echo "<td>" . ($photoPath ?: 'No photo') . "</td>";
    echo "<td>$fileExists</td>";
    echo "<td>" . ($fullPath ?: 'N/A') . "</td>";
    
    if ($fileExists === 'Yes') {
        $photoUrl = asset('storage/' . ltrim($photoPath, '/'));
        echo "<td><img src='$photoUrl' style='max-width: 100px; max-height: 100px;'></td>";
    } else {
        echo "<td>No preview available</td>";
    }
    
    echo "</tr>";
}

echo "</table>";
