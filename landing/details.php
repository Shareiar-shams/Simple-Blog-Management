<?php 

	function main_section(){
		?>
		<!-- News With Sidebar Start -->
	    <div class="container-fluid">
	        <div class="container">
	            <div class="row">
	            	<div class="col-lg-8">
						<?php
						include '../components/landingDetails.php';
						?>
					</div>
					<div class="col-lg-4">
						<?php
						include 'include/sideBarOnly.php';
						?>
					</div>
				</div>
	        </div>
	    </div>
	    <!-- News With Sidebar End -->
		<?php
		
	} 
	include('layout.php');
?>