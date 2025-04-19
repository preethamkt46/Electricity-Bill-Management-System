<?php 
    require_once('head_html.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/user.php'); 
    if ($logged==false) {
         header("Location:../index.php");
    }
?>


<body>

    <div id="wrapper">

       <?php 
            require_once("nav.php");
            require_once("sidebar.php");
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Charges
                            <small>Standardized</small>
                        </h1>
                        <div class="info">
                        <pre><ul><h3><b>Calculate the energy cost based on the usage of units:</b></h3>
                                <h4><li>First 100 units: Rs. 4.22 per unit</li>
                                <li>Next 100 units: Rs. 5.02 per unit</li>
                                <li>Remaining units: Rs. 5.87 per unit</li>
                                <li>Add the fixed fee: Rs. 40</li>
                                <li>Add the energy duty: Rs. 0.15 per unit</li></h4>
                                <h4>Total energy bill = Energy cost + Fixed fee + Energy duty</h4>
                                </ul></pre>
                    </div>
                    <!-- /.col-lg-12 -->                    
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-content-wrapper -->
        
        


    </div>
    <!-- /#wrapper -->

    <?php 
    require_once("footer.php");
    require_once("js.php");
    ?>
    
</body>

</html>


