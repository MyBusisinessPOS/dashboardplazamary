<?php 
$user = current_user(); 
?>
<!DOCTYPE html>
<html lang="en">

<!-- blank.html  21 Nov 2019 03:54:41 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php if (!empty($page_title))
                echo remove_junk($page_title);
            elseif (!empty($user))
                echo ucfirst($user['name']);
            else echo "Todo Barato"; ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bundles/izitoast/css/iziToast.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/components.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='<?= BASE_URL ?>/assets/img/favicon.ico' />
</head>

<body>
	<div class="loader"></div>
	<div id="app">
		<div class="main-wrapper main-wrapper-1">
			<div class="navbar-bg"></div>
			<nav class="navbar navbar-expand-lg main-navbar sticky">
				<div class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
						<li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
								<i data-feather="maximize"></i>
							</a></li>						
					</ul>
				</div>
				<ul class="navbar-nav navbar-right">					
					<li class="dropdown"><a href="#" data-toggle="dropdown"
							class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
                            
                            <!-- <img alt="image" src="assets/img/user.png" class="user-img-radious-style">  -->
                            <figure class="avatar mr-2 avatar-sm" data-initial="<?=avatarInitial($user["name"])?>"></figure>
                                <span class="d-sm-none d-lg-inline-block"></span></a>
						<div class="dropdown-menu dropdown-menu-right pullDown">
							<div class="dropdown-title">Hola <?=$user["name"]?></div>
							<a href="<?=BASE_URL?>profile.php" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Perfil
							</a> 
							<div class="dropdown-divider"></div>
							<a href="<?=BASE_URL?>logout.php" class="dropdown-item has-icon text-danger"> <i
									class="fas fa-sign-out-alt"></i>
								Salir
							</a>
						</div>
					</li>
				</ul>
			</nav>
			<div class="main-sidebar sidebar-style-2">
				<aside id="sidebar-wrapper">
					<div class="sidebar-brand">
						<a href="<?=BASE_URL?>"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
								class="logo-name">Plaza Mary</span>
						</a>
					</div>
					<ul class="sidebar-menu">
				
						<li class="menu-header">Main</li>

						<li class="dropdown">
							<a href="<?=BASE_URL?>" class="nav-link"><i
									data-feather="monitor"></i><span>Dashboard</span></a>
						</li>
						<!-- Settings -->
                        <?php if ($user['role_id'] == 1)  {?>
                        <li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="settings"></i><span>Configuraciones</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>users.php">Usuarios</a></li>			
							</ul>
						</li>
                        <?php } ?>			

						
						  <?php if ($user['role_id'] == 1)  {?>
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Ventas</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>sales_for_day.php">Por fecha</a></li>	
								<li><a class="nav-link" href="<?=BASE_URL?>sales_for_products.php">Por Mes por sucursal</a></li>	
								<li><a class="nav-link" href="<?=BASE_URL?>sales_by_month.php">Ventas por mes</a></li>
							</ul>
						</li>	
						  <?php } ?>	

						<?php if ($user['role_id'] == 1)  {?>
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Egresos</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>egres_by_concept.php">Por sucursal</a></li>	
								<li><a class="nav-link" href="<?=BASE_URL?>expenses_by_month.php">Gastos por mes</a></li>
							</ul>
						</li>	
		  				<?php } ?>	
		  				
		  				
		  				
						<?php if ($user['role_id'] == 1)  {?>
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Traspasos</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>transfers_for_month.php">Traspasos por mes</a></li>
							</ul>
						</li>	
		  				<?php } ?>
		  				
		  				<?php if ($user['role_id'] == 1)  {?>
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Compras</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>purchases_by_month.php">Compras por mes</a></li>
							</ul>
						</li>	
		  				<?php } ?>
		  				
		  				
		  					<?php if ($user['role_id'] == 1)  {?>
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Beneficios</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>benefits_per_month.php">Beneficios por mes</a></li>
							</ul>
						</li>	
		  				<?php } ?>
		  				
		  				
		  				
		  				
		  			
						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Arqueos</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="<?=BASE_URL?>logs_users.php">Por sucursal</a></li>					
							</ul>
						</li>	


						<li class="dropdown">
							<a href="#" class="menu-toggle nav-link has-dropdown"><i
									data-feather="pie-chart"></i><span>Inventario</span></a>
							<ul class="dropdown-menu">
							    	<li><a class="nav-link" href="<?=BASE_URL?>products.php">Catalogo de productos</a></li>	
								<li><a class="nav-link" href="<?=BASE_URL?>inventory_by_branch.php">Por sucursal</a></li>	

	                            <?php if ($user['role_id'] == 1)  {?>
								<li><a class="nav-link" href="<?=BASE_URL?>inventory_costo.php">Valor Inventario</a></li>
								<li><a class="nav-link" href="<?=BASE_URL?>inventory_costo_month.php">Valor Inventario Mensual</a></li>
								<?php } ?>	
							</ul>
						</li>						
					</ul>
				</aside>
			</div>
			
			