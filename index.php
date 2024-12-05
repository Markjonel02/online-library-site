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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    /* Header */
    header {
      background-color: #fff;
      color: #555;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .header-title {
      display: flex;
      align-items: center;
    }

    .header-title img {
      margin-right: 15px;
      border-radius: 8px;
    }

    .header-title strong {
      font-size: 1.8em;
      letter-spacing: 1px;
    }

    .header-links a {
      color: #fff;
      text-decoration: none;
      font-size: 1em;
      margin-left: 15px;
      border: 1px solid #007bff;
      padding: 10px 25px;
      border-radius: 5px;
      background-color: #007bff;
      transition: background-color 0.3s, color 0.3s;
    }

    .header-links a:hover {
      color: #007bff;
      background-color: transparent;
    }

    /* Book Cards */
    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;

    }

    .card {
      background: #fff;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      width: 300px;
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      margin: 2em 2em;

    }

    .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-header {
      background: #007bff;
      display: flex;
      justify-content: center;
      flex-direction: column;
      color: #fff;
      padding: 15px;
      font-size: 1.2em;
      text-align: center;
      border-radius: 12px 12px 0 0;
    }

    .card-body {
      padding: 15px;
    }

    .card-body p {
      margin: 5px 0;
      font-size: 1em;
      color: #555;
    }

    .card-footer {
      text-align: center;
      padding: 10px;
      background: #f1f1f1;
      border-radius: 0 0 12px 12px;
    }

    .card-footer a {
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
      font-size: 1em;
      transition: color 0.3s ease;
    }

    .card-footer a:hover {
      color: #ff5722;
    }

    /* Footer */
    .footer-section {
      padding: 15px;
      color: #fff;
      background: linear-gradient(to right, #007bffff, #007bffff);
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
      box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
    }

    .footer-section a {
      color: #ffcc00;
      text-decoration: none;
      margin: 0 10px;
      font-size: 1.2em;
    }

    .footer-section a:hover {
      text-decoration: underline;
    }

    /* Responsive Fix for Footer */
    @media (max-width: 768px) {
      .footer-section {
        position: relative;
        box-shadow: none;
      }

      .header-title strong {
        font-size: 1.5em;
      }

      .header-links a {
        font-size: 0.9em;
      }

      .card {
        width: 90%;
      }
    }
  </style>
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
</head>

<body>
  <header>
    <div class="header-title">
      <img src="assets/img/ACLClogo.png" class="headerlogo" width="60px" />
      <strong>Online Library</strong>
    </div>
    <div class="header-links">
      <a href="login.php">Login</a>
    </div>
  </header>

  <!-- Book Cards -->
  <div class="container">


    <?php if (!empty($books)): ?>
      <?php foreach ($books as $book): ?>
        <div class="card">
          <div class="card-header">
            <i class="fi fi-ss-book" style="font-size:50px"></i>
            <?php echo htmlspecialchars($book->BookName); ?>
          </div>
          <div class="card-body">

            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book->ISBNNumber); ?></p>
            <p><strong>Price:</strong> ₱ <?php echo htmlspecialchars($book->BookPrice); ?></p>
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