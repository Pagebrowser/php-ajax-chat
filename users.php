<?php 
  // session_start() starts new or resumes existing sessions
  session_start();
  include_once "php/config.php";
  //If the unique_id session is not set we redirect to the login page so as to login & set the session
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<!-- This page displays all the users in the database either online or offline -->
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <!-- We get profile photo from the db -->
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <!-- We get the first & last name from the db -->
            <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
            <!-- We get the status from the db -->
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
