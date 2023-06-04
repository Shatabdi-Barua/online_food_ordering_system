 <style>
.alert_login {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
}
 </style>
 <!-- Masthead-->
 <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-center mb-4 page-title">
                    	<h1 class="text-white">Shopping Cart</h1>
                        <hr class="divider my-4 bg-dark" />
                    </div>
                    
                </div>
            </div>
        </header>
	<section class="page-section" id="menu">
        <div class="container">
        	<div class="row">
        	<div class="col-lg-8">
        		<div class="sticky">
	        		<div class="card">
	        			<div class="card-body">
						<?php
						if(empty($_SESSION['login_user_id']))
						{?>
							<div class="alert_login">
							<!-- <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> -->
							To view your cart list please login first!!							
							</div> 
						<?php
						}
						?>
	        				<div class="row">
		        				<div class="col-md-8"><b>Items</b></div>
		        				<div class="col-md-4"><b>Total</b></div>
	        				</div>
	        			</div>
	        		</div>
	        	</div>
        		<?php 
        		if(isset($_SESSION['login_user_id'])){
					$data = "where c.user_id = '".$_SESSION['login_user_id']."' ";	
				}			
				
				$total = 0;
				if(isset($_SESSION['login_user_id']))
				{
					$get = $conn->query("SELECT *,c.id as cid FROM cart c inner join product_list p on p.id = c.product_id ".$data);
					if($get->num_rows > 0)
					{					
						while($row= $get->fetch_assoc()):
							$total += ($row['qty'] * $row['price']);
							// $total = $total + ($row['qty'] * $row['price']);
						?>

						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-4 d-flex align-items-center" style="text-align: -webkit-center">
										<div class="col-auto">	
											<a href="admin/ajax.php?action=delete_cart&id=<?php echo $row['cid'] ?>" class="rem_cart btn btn-sm btn-outline-danger" data-id="<?php echo $row['cid'] ?>"><i class="fa fa-trash"></i></a>
										</div>	
										<div class="col-auto flex-shrink-1 flex-grow-1 text-center">	
											<img src="assets/img/<?php echo $row['img_path'] ?>" alt="">
										</div>	
									</div>
									<div class="col-md-4">
										<p><b><large><?php echo $row['name'] ?></large></b></p>
										<p class='truncate'> <b><small>Desc :<?php echo $row['description'] ?></small></b></p>
										<p> <b><small>Unit Price :<?php echo number_format($row['price'],2) ?></small></b></p>
										<p><small>QTY :</small></p>
										<div class="input-group mb-3">
										<div class="input-group-prepend">
											<button class="btn btn-outline-secondary qty-minus" type="button"   data-id="<?php echo $row['cid'] ?>"><span class="fa fa-minus"></button>
										</div>
										<input type="number" readonly value="<?php echo $row['qty'] ?>" min = 1 class="form-control text-center" name="qty" >
										<div class="input-group-prepend">
											<button class="btn btn-outline-secondary qty-plus" type="button" id=""  data-id="<?php echo $row['cid'] ?>"><span class="fa fa-plus"></span></button>
										</div>
										</div>
									</div>
									<div class="col-md-4">
										<b><large><?php echo number_format($row['qty'] * $row['price'],2) ?></large></b>
									</div>
								</div>
							</div>
						</div>

						<?php 
						endwhile; 
					}
					else
					{
						?>
						<div class="card text-center text-danger">Your Cart is Empty!!</div>
						<?php
					}
				}
					?>
        	</div>
			
        	<div class="col-md-4">
        		<div class="sticky">
					<!-- for tacking order  -->
					<?php
					if(isset($_SESSION['login_user_id']))
					{
						$has_order = $conn->query("SELECT id FROM `orders` WHERE status NOT IN (2) AND user_id = '".$_SESSION['login_user_id']."'");
						if($has_order->num_rows >0){
							?>
						<!-- <div class="text-center">
							<a class="btn btn-block btn-outline-primary" href="index.php?page=track_order" type="button" id="track_order">Track My Order</a>
						</div> -->
						<?php 
						}
					}
					?>
        			<div class="card">
        				<div class="card-body">
						
        					<p><large>Total Amount</large></p>
        					<hr>
        					<p class="text-right"><b><?php echo number_format($total,2) ?></b></p>
        					<hr>
        					<div class="text-center">								
        						<button class="btn btn-block btn-outline-dark" type="button" id="checkout" <?php 
								if(isset($_SESSION['login_user_id']))
								{ 
									if($get->num_rows == 0)
									{ ?> disabled <?php } 
								}
								else{
									?> disabled
								<?php } ?>>Proceed to Checkout</button>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	</div>
        </div>
    </section>
    <style>
    	.card p {
    		margin: unset
    	}
    	.card img{
		    max-width: calc(100%);
		    max-height: calc(59%);
    	}
    	div.sticky {
		  position: -webkit-sticky; /* Safari */
		  position: sticky;
		  top: 4.7em;
		  z-index: 10;
		  background: white
		}
		.rem_cart{
		   position: absolute;
    	   left: 0;
		}
    </style>
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product','view_prod.php?id='+$(this).attr('data-id'))
        })
        $('.qty-minus').click(function(){
		var qty = $(this).parent().siblings('input[name="qty"]').val();
		update_qty(parseInt(qty) -1,$(this).attr('data-id'))
		if(qty == 1){
			return false;
		}else{
			 $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) -1);
		}
		})
		$('.qty-plus').click(function(){
			var qty =  $(this).parent().siblings('input[name="qty"]').val();
				 $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) +1);
		update_qty(parseInt(qty) +1,$(this).attr('data-id'))
		})
		function update_qty(qty,id){
			start_load()
			$.ajax({
				url:'admin/ajax.php?action=update_cart_qty',
				method:"POST",
				data:{id:id,qty},
				success:function(resp){
					if(resp == 1){
						load_cart()
						end_load()
					}
				}
			})
		}
		$('#checkout').click(function(){			
			if('<?php echo isset($_SESSION['login_user_id']) ?>' == 1){
				location.replace("index.php?page=checkout")
			}else{
				uni_modal("Checkout","login.php?page=checkout")
			}
		})
		// $('#track_order').click(function(){
		// 	$.ajax({
		// 		url:'admin/ajax.php?action=track_order',
		// 		method:"POST",
		// 		data:{id:id,qty},
		// 		success:function(resp){
		// 			if(resp == 1){
		// 				load_cart()
		// 				end_load()
		// 			}
		// 		}
		// 	})
		// })
    </script>
	
