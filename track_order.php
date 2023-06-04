<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Pizza Ordering System</title>    
</head>
<body>     -->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-center mb-4 page-title">
                <h1 class="text-white">My Order List</h1>
                <hr class="divider my-4 bg-dark" />
            </div>
            
        </div>
    </div>
</header>
	<section class="page-section" id="menu">
        <div class="container">      
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Order ID</th>                        
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $cats = $conn->query("SELECT * FROM orders where user_id = '".$_SESSION['login_user_id']."'");
                    while($row=$cats->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++ ?></td>
                        <td class="text-center">
                            <?php echo $row['id'] ?>
                        </td>
                        <td class="text-center">
                            <?php if($row['status'] == 1): ?>
                                <span class="badge badge-success">Confirmed</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">For Verification</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary see_details" data-id="<?php echo $row['id'] ?>" >See Details</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        </div>
    </section>        
<!-- </body>
</html> -->
<script>
	$('.see_details').click(function(){
		uni_modal('Tracking','tracking_details.php?id='+$(this).attr('data-id'))
	})
	// $('table').dataTable();
</script>