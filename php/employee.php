<?php
    include 'header.php';

    function employee_products( $conn ) {
        $query = "SELECT 
        products.name AS Product,
        products.quantity AS Stock,
        products.product_id AS ID
        FROM products
        ORDER BY Stock ASC;";

       displayQueryResults( $query, $conn );
    }

    function restock_request( $conn ) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['product_quantity'];

        $query = "SELECT MAX(restock.restock_ID) AS MAX_ID FROM restock;";
        $restock_id = ( $conn->query($query) -> fetch_assoc() )["MAX_ID"] + 1;

        $query = "SELECT 
        products.name AS Product,
        products.quantity AS Quantity
        FROM products 
        WHERE products.product_id = $product_id;";

        $product = $conn -> query( $query );

        if ( $product -> num_rows == 0 ) {
            echo "Product you are attempting to restock does not exist!";
        } else {
            $product = $product -> fetch_assoc();

            $product_name = $product['Product'];
            $product_quantity = $product['Quantity'];

            $query = "INSERT INTO restock values( '$restock_id', '$product_id', '$quantity' );";
            $conn->query($query);

            $new_stock = $product_quantity + $quantity;

            $query = "UPDATE products
            SET products.quantity = '$new_stock'
            WHERE products.product_id = '$product_id';";

            $conn->query($query);

            echo "Successfully sent a restock request for $quantity $product_name(s)!";
        }
    };
?>
<div id = "row">
    <span id = "column_left">
        <div id = "display_results">
            <?php
                employee_products( $conn );
            ?>
        </div>
    </span>
    <span id = "column_right">
        <h2>Restock Wizard</h2>
            <div id = "shopping_cart">
                <form method = "post" action = "" id = "shopping_form">
                    <div>
                        <label for = "product_id">Product ID: </label>
                        <input type = "text" id = "product_id" placeholder = "0" size = "5" name = "product_id" required>
                    </div>

                    <div>
                        <label for = "product_quantity">Amount: </label>
                        <input type = "text" id = "product_quantity" placeholder = "1" size = "7" name = "product_quantity" value = "1">
                    </div>

                    <button type = "submit">Send Restock Request</button>
                </form>
                <div id = "cart_results">
                    <?php
                        if( isset( $_POST['product_id'] ) ) {
                            restock_request( $conn );
                        }
                    ?>
                </div>
            </div>
    </span>
</div>
<?php
    include 'footer.php'
?>
