<?php
    // Include the TCPDF library
    require_once('tcpdf/tcpdf.php');
    
    // Function to generate PDF invoice
    function generateInvoice($transaction_id, $conn) {
        // Initialize PDF object
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');
        $pdf->SetKeywords('Invoice');

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('dejavusans', '', 12);

        // Add header
        $html = '<h1>Invoice</h1>';
        $html .= '<p>Transaction ID: ' . $transaction_id . '</p>';
        $html .= '<table border="1" cellpadding="5">';
        $html .= '<tr><th>Product Name</th><th>Quantity</th><th>Unit Price</th></tr>';

        // Retrieve transaction details from database
        $sql = "SELECT p.product_name, td.quantity, p.price 
                FROM transaction_details td
                INNER JOIN products p ON td.product_id = p.product_id 
                WHERE td.transaction_id = $transaction_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>';
            $html .= '<td>' . $row['product_name'] . '</td>';
            $html .= '<td>' . $row['quantity'] . '</td>';
            $html .= '<td>' . $row['price'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        // Add footer
        $html .= '<p>Thank you for your purchase.</p>';

        // Output HTML to PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF
        $pdf->Output('invoice.pdf', 'I');
    }

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "wholesale");

    // Check if the generate invoice form is submitted
    if (isset($_POST['generate_invoice'])) {
        // Get transaction ID from the form
        $transaction_id = $_POST['transaction_id'];

        // Generate invoice for the specified transaction
        generateInvoice($transaction_id, $conn);
    }

    // Close database connection
    mysqli_close($conn);
?>

<?php
    session_start(); 
    if(!isset($_SESSION['loginUser'])){
        header("Location:logout.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Transactions</title>
    <link rel='stylesheet' href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head> 
<body>
    <div class="topStyle">
        <h2 style="color:white;">Wholesale DataBase Management</h2>
        <a class='userNameDisplay'><?php echo $_SESSION['loginUser']; ?></a>
    </div>
    <div class='sidebar'>
        <button onclick="location.href='customerHome.php'">Home</button>
        <button onclick="location.href='viewProductsCustomer.php'">View Products</button>
        <button onclick="location.href='order.php'">Order</button>
        <button onclick="location.href='cart.php'">Cart</button>
        <button onclick="location.href='customerViewTransactions.php'">My Transactions</button>
        <button onclick="location.href='logout.php'">Logout</button>
    </div>
    <div class='container'>
        <fieldset>
            <legend><b>My Transactions</b></legend>
            <table class='tableLarge'>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Action</th> <!-- New column for the button -->
                </tr>
                <?php 
                    $conn=mysqli_connect("localhost","root","","wholesale");
                    $curUser=$_SESSION['loginUser'];
                    $sql="SELECT * FROM transaction WHERE customer_id='$curUser'";
                    $result=mysqli_query($conn,$sql);
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$row['transaction_id']."</td>";
                        echo "<td>".$row['transaction_amount']."</td>";
                        echo "<td>".$row['payment']."</td>";
                        echo "<td>".$row['phone']."</td>";
                        echo "<td style='font-size: 15px;'>".$row['address']."</td>";
                        echo "<td>".$row['date']."</td>";
                        echo "<td><form method='post' action='".$_SERVER["PHP_SELF"]."'><input type='hidden' name='transaction_id' value='".$row['transaction_id']."'><input type='submit' name='generate_invoice' input class = 'btn' value='Generate Invoice'></form></td>"; // Button for generating invoice
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
            </table>
        </fieldset>
    </div>
</body>
</html>

