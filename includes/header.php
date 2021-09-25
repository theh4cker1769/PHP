<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if($page=='home'){ echo 'active'; }?>" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page=='slider'){ echo 'active'; }?>" aria-current="page" href="slider.php">Slider</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page=='signup'){ echo 'active'; }?>" aria-current="page" href="signup.php">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page=='login'){ echo 'active'; }?>" aria-current="page" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>