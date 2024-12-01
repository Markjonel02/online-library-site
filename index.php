<?php
// Connect to the database
include('includes/config.php');

// Fetch books data
try {
  $sql = "SELECT BookName, ISBNNumber, BookPrice FROM tblbooks";
  $query = $dbh->prepare($sql);
  $query->execute();
  $books = $query->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $e) {
  echo "<script>alert('Failed to fetch books: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books List</title>
  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f9f9f9;

    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 20px;

    }

    .card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 300px;
      transition: transform 0.3s ease-in-out;
    }

    .card:hover {
      transform: translateY(-10px);
    }

    .card-header {
      background: #007bff;
      color: #fff;
      padding: 15px;
      font-size: 1.2em;
      text-align: center;
    }

    .card-body {
      padding: 15px;
    }

    .card-body p {
      margin: 5px 0;
      font-size: 0.95em;
      color: #555;
    }

    .card-footer {
      text-align: center;
      padding: 10px;
      background: #f1f1f1;
    }

    .card-footer a {
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }

    .card-footer a:hover {
      text-decoration: underline;
    }

    .footer-section {
      padding: 25px 50px 25px 50px;
      color: #fff;
      font-size: 1em;
      background-color: #427dfcff;
      text-align: right;


    }

    .footer-section a,
    .footer-section a:hover {
      color: #000;
    }

    header {
      display: flex;
      justify-content: space-around;
      align-items: center;
      border-bottom: 1px solid gray;
      padding: 10px 20px;
    }

    .header-title {
      font-size: 1.5em;
      font-weight: bold;
    }


    .header-links a {
      color: #fff;
      text-decoration: none;
      font-size: 15px;
      margin-left: 15px;
    }

    .header-links a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <header>
    <div class="header-title"> <img src="assets/img/ACLClogo.png" class="headerlogo" width="100px" style="margin-left: px;" />
      <strong> ACLC Online Library</stro>
    </div>
    <div class="header-links">
      <a href="login.php">Login</a>
    </div>
  </header>
  <div class="container">
    <?php if (!empty($books)): ?>
      <?php foreach ($books as $book): ?>
        <div class="card">
          <div class="card-header">
            <?php echo htmlspecialchars($book->BookName); ?>
          </div>
          <div class="card-body">
            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book->ISBNNumber); ?></p>
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($book->BookPrice); ?></p>
          </div>
          <div class="card-footer">
            <a href="#">View Details</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No books available.</p>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>

  <!-- Scripts -->
  <script src="assets/js/bootstrap.js"></script>
</body>

</html>