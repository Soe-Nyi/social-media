<?php
// Execute the Python script and capture the output
$command = 'python3 main.py 2>&1';
$output = exec($command);

$recommended_post_ids = explode(',', $output);

// Fetch the recommended posts from the MySQL database
$pdo = new PDO('mysql:host=localhost:3306;dbname=social-media', 'root', '');
$in = str_repeat('?,', count($recommended_post_ids) - 1) . '?';
$stmt = $pdo->prepare("SELECT id, content FROM posts WHERE id IN ($in)");
$stmt->execute($recommended_post_ids);
$recommended_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the recommended posts
foreach ($recommended_posts as $post) {
    echo "Post ID: {$post['id']}<br>";
    echo "Content: {$post['content']}<br><br>";
}

// Close the database connection
$pdo = null;
?>