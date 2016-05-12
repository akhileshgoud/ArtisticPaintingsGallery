<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-navbar-collapse">
						 <span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					</button><a class="navbar-brand" id="top-anchor" href="index.php" style="font-size:24px; color: #337ab7;">Online Art Store</a>
				</div>
				
				<div class="collapse navbar-collapse" id="custom-navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						<li><a href="paintings.php"><span class="glyphicon glyphicon-th"></span> Gallery</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
					<?php
						if(!$_SESSION["isLogged"]) {
							echo '<li><a href="signin.php"><span class="glyphicon glyphicon-user"></span> Login</a></li>';
							echo '<li><a href="signin.php"><span class="glyphicon glyphicon-pencil"></span> Register</a></li>';
						}
						else {
							if ($_SESSION["role"] == 'admin') {
								echo '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-briefcase"></span> '.$_SESSION["user"].' <span class="caret"></span></a>
										<ul class="dropdown-menu">
										  <li><a href="adminpage.php">Admin Panel</a></li>
										  <li><a href="customerprofile.php">Customer Panel</a></li>
										</ul>
									  </li>';
							}
							if ($_SESSION["role"] == 'customer') {
								echo '<li><a href="customerprofile.php"><span class="glyphicon glyphicon-briefcase"></span> '.$_SESSION["user"].'</a></li>';
							}
							echo '<li><a href="shoppingcart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>';
							echo '<li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>';	
						}
					?>
					</ul>
						
					<form class="navbar-form navbar-right" role="search" style="margin-right: 10px;"action="paintings.php" method="post">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search For Paintings" id="search" name="search" autocomplete="off" value="<?php if(isset($_REQUEST['search'])) echo $_REQUEST['search'] ?>">
						</div> 
						<button type="submit" class="btn btn-default">
							Search
						</button>
					</form>
				</div>
			</nav>
		</div>
	</div>