<?php
// MySQL connection info
$host = 'group4moviessqlserver.mysql.database.azure.com';
$username = 'g4admin';
$password = 'MovieCloud@2025'; // replace with your real password
$dbname = 'movie_db';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search logic
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM movies WHERE title LIKE '%$search%' OR director LIKE '%$search%' ORDER BY release_year DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f2f2f2; }
        h1 { color: #333; }
        input[type="text"] { padding: 0.5rem; width: 300px; }
        .movie { background: white; padding: 1rem; margin-bottom: 1rem; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.1); display: flex; gap: 1rem; }
        img { width: 100px; height: 150px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🎬 Movie Viewer</h1>
    <form method="GET">
        <input type="text" name="search" placeholder="Search by title or director..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="movie">
                <img src="<?= $row['image_url'] ?>" alt="Poster">
                <div>
                    <h2><?= htmlspecialchars($row['title']) ?> (<?= $row['release_year'] ?>)</h2>
                    <p><strong>Director:</strong> <?= htmlspecialchars($row['director']) ?></p>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($row['genre']) ?></p>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No movies found.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
