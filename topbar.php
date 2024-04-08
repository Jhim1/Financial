<style>
	.logo {
		margin: auto;
		font-size: 60px;
		background: url('fg.png') center/contain no-repeat;
		padding: 18px;
		border-radius: 55%;
		color: #000000b3;
	}

</style>

<nav class="navbar navbar-light fixed-top bg-primary" style="padding:0;">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-1 float-left" style="display: flex;">
        <div class="logo"></div>
      </div>
      <div class="col-md-4 float-left text-white">
        <large><b>Financial Guardian</b></large>
      </div>
      <div class="col-md-2 float-right text-white">
        <a href="ajax.php?action=logout" class="text-white"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
      </div>
    </div>
  </div>
</nav>
