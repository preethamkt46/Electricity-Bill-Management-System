<?php 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php');
    require_once('../Includes/admin.php');

    $aid = $_SESSION['aid'];

    // Get current date and next 30 days date
    $query  = "SELECT curdate() AS bdate , adddate( curdate(),INTERVAL 30 DAY ) AS ddate , user.id AS uid , user.name AS uname FROM user ";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_assoc($result);
    
    $bdate = $row['bdate'];
    $ddate = $row['ddate'];

    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
    }
    if (isset($_POST['units'])) {
        $units = $_POST['units']; 
    }
    if (isset($_POST['uname'])) {
        $uname = $_POST['uname']; 
    }

    if (isset($_POST['generate_bill'])) {
        if(isset($_POST["units"]) && !empty($_POST["units"]))
        {
            // Calculate energy costs
            $energy_cost = 0;
            $remaining_units = $units;

            // Calculate cost for the first 100 units
            if ($remaining_units >= 100) {
                $energy_cost += 100 * 4.22;
                $remaining_units -= 100;
            } else {
                $energy_cost += $remaining_units * 4.22;
                $remaining_units = 0;
            }

            // Calculate cost for the next 100 units
            if ($remaining_units >= 100) {
                $energy_cost += 100 * 5.02;
                $remaining_units -= 100;
            } else {
                $energy_cost += $remaining_units * 5.02;
                $remaining_units = 0;
            }

            // Calculate cost for the next 80 units
            if ($remaining_units > 0) {
                $energy_cost += $remaining_units * 5.87;
            }

            // Add fixed fee and energy duty
            $total_bill_amount = $energy_cost + 40 + ($units * 0.15);

            // Insert values into bill table
            $query  = " INSERT INTO bill (aid , uid , units , amount , status , bdate , ddate )";
            $query .= " VALUES ( {$aid} , {$uid} , {$units} , {$total_bill_amount} , 'PENDING' , '{$bdate}' , '{$ddate}' )";
            $result2 = mysqli_query($con,$query);  
            
            // Insert values into transaction table
            $query2 = "SELECT id , amount FROM bill WHERE aid={$aid} AND uid={$uid} AND units={$units} ";
            $query2 .= "AND status='PENDING'  AND bdate='{$bdate}' AND ddate='{$ddate}' ";

            $result3 = mysqli_query($con,$query2);
            $row = mysqli_fetch_row($result3);

            $bid = $row[0];
            $amount = $row[1];
            insert_into_transaction($bid,$amount);
        }  
    }
    header("Location:bill.php");
?>
