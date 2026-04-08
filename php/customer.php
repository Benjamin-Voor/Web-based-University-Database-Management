<?php
    include 'header.php';

    function customer_search( $conn ) {
        $search_text = $_POST['search_box'];
        $sort_by = "products.".$_POST['sort_box'];
        $rev_sort = $_POST['rev_sort'];
        $show_top = $_POST['show_top'];
        $search_category = $_POST['search_category'];

        if ( $rev_sort == 'on' ) {
            $rev_sort = 'ASC';
        } else {
            $rev_sort = 'DESC';
        }

        if ( $show_top ) {
            $show_top = "LIMIT ".$show_top;
        }

        $query = "SELECT products.name AS Product, products.category AS Category, products.price AS Price, products.quantity AS Stock, products.product_id as ID
        FROM products
        WHERE products.name LIKE '%$search_text%' AND products.category LIKE '%$search_category%'
        ORDER BY $sort_by $rev_sort $show_top;";

        displayQueryResults( $query, $conn );
    }

    function customer_purchase( $conn ) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $customer_balance = $_POST['wallet'];
        $product_ID = $_POST['product_id'];
        $quantity = $_POST['product_quantity'];

        $query = "SELECT products.name AS Product, products.price AS Price, products.quantity AS Stock
        FROM products
        WHERE products.product_id = '$product_ID';"; 

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $product_name = $row["Product"];
            $product_price = $row["Price"];
            $product_stock = $row["Stock"];

            if ( $product_price * $quantity > $customer_balance ) {
                echo "<p>Not enough money in wallet! To purchase $quantity $product_name(s), you need $".$quantity * $product_price."!</p>";
            } else if ( $quantity > $product_stock ) {
                echo "<p>Not enough $product_name(s) in stock! Please purchase $product_stock of $product_name(s) or less!</p>";
            } else {
                $query = "SELECT customers.first_name AS first_name, customers.last_name AS last_name, customers.customer_ID AS customer_ID
                from customers
                WHERE first_name = '$first_name' AND last_name = '$last_name';";

                $cust_result = $conn->query($query);
                if ($cust_result->num_rows == 0) {
                    $query = "SELECT customers.customer_ID 
                    AS cust_ID 
                    FROM customers
                    ORDER BY cust_ID DESC 
                    LIMIT 1;";
 
                    $new_id = ( $conn->query($query) -> fetch_assoc() )["cust_ID"] + 1;
                    $query = "INSERT INTO customers values( '$new_id', '$first_name', '$last_name' )";

                    $conn -> query($query);
                } 

                $query = "SELECT customers.first_name AS first_name, customers.last_name AS last_name, customers.customer_ID AS customer_ID
                from customers
                WHERE first_name = '$first_name' AND last_name = '$last_name';";

                $customer_id = ( $conn->query($query) -> fetch_assoc() )["customer_ID"];

                $query = "SELECT orders.order_ID 
                    AS order_ID 
                    FROM orders
                    ORDER BY order_ID DESC 
                    LIMIT 1;";
                $new_id = ( $conn->query($query) -> fetch_assoc() )["order_ID"] + 1;
                $current_date = date("Y-m-d");

                $query = "INSERT INTO orders values( '$new_id', '$product_ID', '$quantity', '$customer_id', '$current_date' );";
                $conn -> query($query);
                $new_stock = $product_stock - $quantity;
                $query = "UPDATE products
                    SET products.quantity = '$new_stock'
                    WHERE products.product_id = '$product_ID';";
                $conn -> query($query);

                $purchase_price = $quantity * $product_price;
                echo "<p>Successfully purchased $quantity $product_name(s) for $$purchase_price! Thank you for shopping, $first_name!</p>";
            }
            
        } else {
            echo "Product ID does not exist!";
        }
    }
?>

<div id = "row">
    <span id = "column_left">
        <div id = "search_menu">
            <h2>Search Products</h2>
            <div>
                <form method = "post" action = "" id = "search_bar">
                    <span>
                        <input type = "text" id = "search_box" placeholder = "Product Search" size = "50" name = "search_box">
                        <button type = "submit">Search</button>
                    </span>

                    <span>
                        <label for = "search_category">Category: </label>
                        <select id = "search_category" name = "search_category">
                            <option value = "">Any</option>
                            <option value = "food">Food</option>
                            <option value = "kitchen">Kitchen</option>
                            <option value = "crafts">Crafts</option>
                            <option value = "misc">Misc</option>
                        </select>
                    </span>
                    
                    <span>
                        <label for = "sort_box">Sort: </label>
                        <select id = "sort_box" name = "sort_box">
                            <option value = "name">Name</option>
                            <option value = "price">Price</option>
                            <option value = "quantity">Quantity</option>
                        </select>
                        <input type = "checkbox" id = "rev_sort" name = "rev_sort">
                        <label for = "rev_sort">ascending</label>
                    </span>
                    
                    <span>
                        <label for = "filter_box">Show only top </label>
                        <input type = "text" id = "filter_box" name = "show_top">
                        <label for = "filter_box"> items</label>
                    </span>
                </form>
            </div>
        </div>

        <div id = "display_menu">
            <div id = "display_results"> 
                <?php
                    if( isset( $_POST['search_box'] ) ) {
                        customer_search( $conn );
                    }
                ?>
            </div>
        </div>
    </span>
    <span id = "column_right">
        <h2>Shopping Cart</h2>
            <div id = "shopping_cart">
                <form method = "post" action = "" id = "shopping_form">
                    <div>
                        <label for = "customer_first_name">Customer Name: </label>
                        <input type = "text" id = "customer_first_name" placeholder = "First Name" size = "9" name = "first_name" required>
                        <input type = "text" id = "customer_last_name" placeholder = "Last Name" size = "9" name = "last_name" required>
                    </div>

                    <div>
                        <label for = "wallet">Customer Balance: $</label>
                        <input type = "text" id = "wallet" placeholder = "0" size = "10" name = "wallet" required>
                    </div>

                    <div>
                        <label for = "product_id">Product ID: </label>
                        <input type = "text" id = "product_id" placeholder = "0" size = "5" name = "product_id" required>
                    </div>

                    <div>
                        <label for = "product_quantity">Amount: </label>
                        <input type = "text" id = "product_quantity" placeholder = "1" size = "7" name = "product_quantity" value = "1">
                    </div>

                    <button type = "submit">Purchase</button>
                </form>
                <div id = "cart_results">
                    <?php
                        if( isset( $_POST['product_id'] ) ) {
                            customer_purchase( $conn );
                        }
                    ?>
                </div>
            </div>
    </span>
</div>
<?php
    include 'footer.php'
?>
