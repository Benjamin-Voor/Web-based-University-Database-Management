<?php
    include 'header.php';

    function admin_search( $conn ) {
        $query = $_POST['command_input'];
        displayQueryResults( $query, $conn );
    }
?>

<div id = "row">
    <span>
        <div id = "admin_search_bar">
            <h2>Input SQL Query</h2>
            <form method = "post" action = "" id = "execute_bar">
                <textarea id = "command_input" name = "command_input" cols = "100" rows = "1" required>SELECT * FROM products;</textarea><br>
                <button type = "submit">Execute Query</button>
            </form>
        </div>
        <div id = "display_menu">
            <div id = "display_results">
                    <?php
                        if( isset( $_POST['command_input'] ) ) {
                            admin_search( $conn );
                        }
                    ?>
            </div>
        </div>
    </span>
</div>

<?php
    include 'footer.php'
?>