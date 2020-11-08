<?php
require_once "inc/header.php" ?>

<main>

  <div class="row">
  <h1>Bienvenue sur le site de la ludothèque</h1>
  </div>


  
    <div class="row justify-content-center">


      <form class="col-4 md-12" action="" method="POST">

        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Connection</button>
      </form>
  </div>

  
    <div class="row justify-content-center">

      <p class="col-4 md-12">
        Pas encore inscrit? C'est par <a href="register.php"> ici </a>
      </p>
      
    </div>
  


</main>


<?php
require_once "inc/footer.php" ?>