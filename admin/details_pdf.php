<?php
include('authentication.php');
include('assets/includes/header.php');
include('assets/includes/sidebar.php');
include('assets/includes/topbar.php');
?>

    <p style="text-align: center;">User Details</p>
    <table  width="100%" border="1">
        <tr>
          
            <td> <img src="uploads/docs/<?=$user['documents']; ?>" width="50px" height="50px" alt="image"></td>
        
        </tr>
        <tr>
        </tr>
    </table>
</body>
</html>