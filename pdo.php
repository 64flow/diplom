<?php
/*

  PDO SQL Routines by Elmar Hanlhofer 03/09/2018 https://www.plop.at
  Free to use. Comes without warranty.

 ------------------------------------------------------------

 function SQL_Connect    ($user, $pass, $db, $host = "localhost", $charset = "utf8mb4");
 function SQL_Exec       ($pdo, $query, $values = false);
 function SQL_Fetch      ($pdo, $query, $values = false);
 function SQL_MultiFetch ($pdo, $query, $values = false);
 function SQL_LastID     ($pdo);
 function SQL_Error      ($e, $query);

 ------------------------------------------------------------

 Define PDO_DEBUG for detailed error messages.

 PDO_DEBUG values:

    1: Print the error message.
    2: Print also the SQL Statement.
    3: Print SQL Statement and traceback with detailed information where the error occurs.

 Example: define ("PDO_DEBUG", "2");

*/

function SQL_Connect ($user, $pass, $db, $host = "localhost", $charset = "utf8mb4")
{
    try
    {
        $pdo = new PDO ("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    }
    catch (PDOException $e)
    {
        SQL_Error ($e);
    }

    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Returned values are only indexed by column name.
    // Set it to PDO::FETCH_BOTH if you also want to have the 0-indexed column number in your result.
    // $pdo->setAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}

function SQL_Exec ($pdo, $query, $values = false)
{
    try
    {
        if (!$values)
        {
            $pdo->exec ($query);
        }
        else
        {
            $stmt = $pdo->prepare ($query);
            $stmt->execute ($values);
            $stmt = null;
        }
    }
    catch (PDOException $e)
    {
        SQL_Error ($e, $query);
    }
}

function SQL_Fetch ($pdo, $query, $values = false)
{
    try
    {    
        if (!$values)
        {
            return $pdo->query ($query)->fetch();
        }
        else
        {
            $stmt = $pdo->prepare ($query);
            $stmt->execute ($values);
            $arr = $stmt->fetch ();
            $stmt = null;    
            return $arr;
        }
    }    
    catch (PDOException $e)
    {
        SQL_Error ($e, $query);
    }
}

function SQL_MultiFetch ($pdo, $query, $values = false)
{
    try
    {
        $stmt = $pdo->prepare ($query);
        if (!$values)
        {
            $stmt->execute ();
        }    
        else
        {    
            $stmt->execute ($values);
        }
        $arr = $stmt->fetchAll ();
        $stmt = null;    
        return $arr;
    }    
    catch (PDOException $e)
    {
        SQL_Error ($e, $query);
    }
}

function SQL_LastID ($pdo)
{
    return $pdo->lastInsertId();
}

function SQL_Error ($e, $query)
{
    echo "<pre>";
    
    if (defined ("PDO_DEBUG"))
    {
        echo "SQL Error: " . $e->getMessage() . "\n\n";
    
        if (PDO_DEBUG >= "2")
        {
            echo "$query\n\n";
        }
        
        if (PDO_DEBUG == "3")
        {
            // Print details like script name and line.
            print_r ($e);
        }
    }
    else
    {
        echo "SQL Error! Please contact the administrator.";
    }

    echo "</pre>";

    // Stop on error.
    exit;
}
?>