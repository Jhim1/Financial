
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<!-- <a href="index.php?page=loans" class="nav-item nav-loans"><span class='icon-field'><i class="fa fa-file-invoice-dollar"></i></span> Loans</a>	 -->
				<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-money-bill"></i></span> Transaction</a>
				<a href="index.php?page=borrowers" class="nav-item nav-borrowers"><span class='icon-field'><i class="fa fa-user-friends"></i></span> Credit</a>
				<!-- <a href="index.php?page=Transaction" class="nav-item nav-plan"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Transaction</a>	 -->
				<a href="index.php?page=bank_reconciliation" class="nav-item nav-bank_reconciliation"><span class='icon-field'>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="margin-bottom: 5px; width: 15px; height: 15px; fill: white;">

				  <path d="M243.4 2.6l-224 96c-14 6-21.8 21-18.7 35.8S16.8 160 32 160v8c0 13.3 10.7 24 24 24H456c13.3 0 24-10.7 24-24v-8c15.2 0 28.3-10.7 31.3-25.6s-4.8-29.9-18.7-35.8l-224-96c-8-3.4-17.2-3.4-25.2 0zM128 224H64V420.3c-.6 .3-1.2 .7-1.8 1.1l-48 32c-11.7 7.8-17 22.4-12.9 35.9S17.9 512 32 512H480c14.1 0 26.5-9.2 30.6-22.7s-1.1-28.1-12.9-35.9l-48-32c-.6-.4-1.2-.7-1.8-1.1V224H384V416H344V224H280V416H232V224H168V416H128V224zM256 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>

				</svg>
				</span> Bank Reconciliation</a>		
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				<a href="index.php?page=reports" class="nav-item nav-loans"><span class='icon-field'><i class="fa fa-list-alt"></i></span> Reports</a>
				
				
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
