<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    include('admin/db_connect.php');
    // echo $_SESSION['login_user_id'];
    $query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
    foreach ($query as $key => $value) {
      if(!is_numeric($key))
        $_SESSION['setting_'.$key] = $value;
    }
    include('header.php');
   
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Pizza Ordering System</title>    
</head>
<style>
    header.masthead {
		  background: url(assets/img/1676509500_pizza-bg.jpg);
		  background-repeat: no-repeat;
		  background-size: cover;
		  background-position: center center;
      position: relative;
      /* height: 85vh !important; */
      height: 90vh !important;
		}
    header.masthead:before {
      content: "";
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      backdrop-filter: brightness(0.8);
  }
</style>
<body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-white">            
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="./"><?php echo "Online Pizza Ordering System"; ?></a>
                    <!-- <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item">
                          <!-- go to home.php page when clicking on home button  -->
                          <a class="nav-link js-scroll-trigger" href="index.php?page=home">Home</a>                           
                        </li>
                        <?php 
                        $categories = $conn->query("SELECT * FROM `category_list` order by `name` asc");                        
                        if($categories->num_rows > 0):
                        ?>
                        <li class="nav-item position-relative " id="cat-menu-link">
                          <a class="nav-link"  href="#">Categories</a>
                          <div id="category-menu" class="">
                            <ul>
                              <?php 
                                while($row = $categories->fetch_assoc()):
                              ?>
                                <li>
                                    <a href="index.php?page=category&id=<?= $row['id'] ?>"><?= $row['name'] ?></a>
                                </li>
                              <?php 
                            endwhile; 
                            ?>
                            </ul>
                          </div>
                        </li>
                        <?php 
                        endif; 
                        ?>

                        <li class="nav-item">
                          <a class="nav-link js-scroll-trigger" href="index.php?page=cart_list">
                            <span> <span class="badge badge-danger item_count">0</span> <i class="fa fa-shopping-cart"></i>  </span>
                          Cart</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link js-scroll-trigger" href="index.php?page=about">About</a>
                        </li>
                        <?php 
                        if(isset($_SESSION['login_user_id'])): 
                        ?>
                        <li class="nav-item">
                          <a class="nav-link js-scroll-trigger" href="admin/ajax.php?action=logout2">
                            <?php 
                            echo "Welcome ". $_SESSION['login_first_name'].' '.$_SESSION['login_last_name'] 
                            ?> 
                            <i class="fa fa-power-off"></i></a>
                        </li>
                        <?php 
                          else: 
                        ?>
                        <li class="nav-item">
                          <a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now">Sign In</a> 
                          <!-- javascript:void(0)=> preventing from page reload  -->
                        </li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="./admin">Admin Sign In</a></li>
                      <?php 
                        endif; 
                      ?>
                    </ul>
                </div>
            </div>
        </nav>
       
        <?php 
        
        if(isset($_GET['page']))
        {
          $page = $_GET['page'];
        }
        else{
          $page = "home";
        }
        // $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>

<!-- modal  -->
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- login starts -->
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="login_title"></h5>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- login ends -->
  <!-- modal for products display starts here -->
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="fa fa-arrow-right"></span>
          </button>
        </div>
        <div class="modal-body" id="product_modal_body">
        </div>
      </div>
    </div>
  </div>
  <!-- modal for products display ends here -->
        <footer class="bg-light py-5">
            <div class="container"><div class="small text-center text-muted">Copyright © 
                <?= date("Y") ?> - 
             <?= "Online Pizza Ordering System" ?> | 
             <a href="mailto:sabijinibarua01@gmail.com" target="_blank">sabijinibarua01@gmail.com</a></div></div>
        </footer>
        
       <?php 
       include('footer.php') 
       ?>
    </body>
</html>
<script>
  /* navbar color change when scrolling  */
  $(function () {
    $(document).scroll(function () {
      var $nav = $("#mainNav");
      $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
    });
  });
</script>