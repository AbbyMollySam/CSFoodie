<?php
    /**
    Molly Cinnamon
    11.5.14
    Generates the home page
    **/

    // configuration
    require("../includes/config.php"); 
    
    //creates an empty array to hold all of the data from tables
    $positions = [];
    //stores all of the user's stock symbols and shares from portfolios
    $rows = query("SELECT symbol, shares FROM portfolios WHERE id = ?", $_SESSION["id"]);
    //stores the current balance of the user
    $cash = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    $money = $cash[0]["cash"];
    
    //loads positions with all of the information to be printed
    foreach ($rows as $row)
    {
        $stock = lookup($row["symbol"]);
        if ($stock !== false)
        {
            $positions[] = [
                "name" => $stock["name"],
                //formats the numbers to the appropriate number of decimal placess
                "price" => number_format($stock["price"]*$row["shares"],3),
                "shares" => $row["shares"],
                "symbol" => $row["symbol"]
            ];
        }
    }
    // render portfolio
    render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "money" => $money,]);

?>
