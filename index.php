<?php
require('database.php');


/*First check if we are adding or deleting items. Once table updates are complete, return current table.*/

/*Check if we are adding a toDoItem*/
if(isset($_POST["addToDoItem"]))
{
    /*Sanitize the title and description*/
    $toDoTitle = filter_input(INPUT_POST, "title",FILTER_SANITIZE_STRING);
    $toDoDescription = filter_input(INPUT_POST, "desc",FILTER_SANITIZE_STRING);

    /*Verify that a title and description were provided*/
    $toDoItemValid = true;
    if(is_null($toDoTitle)) {
        echo "Invalid Title provided.";
        $toDoItemValid = false;
    }
    if(is_null($toDoDescription)) {
        echo "Invalid Title provided.";
        $toDoItemValid = false;
    }

    /*A valid toDoItem title and description were provided. Process the item.*/
    if($toDoItemValid) {

        /*Trim and shorten the title and description to match the SQL table*/
        $toDoTitle = substr(trim($toDoTitle),0,20);
        $toDoDescription = substr(trim($toDoDescription),0,50);

        /*Insert the toDoItem into the table*/
        $query = "INSERT INTO todoitems 
                (Title, Description) 
            VALUES 
                (:title, :description)";
        $statement = $db->prepare($query);
        $statement->bindValue(":title", $toDoTitle);
        $statement->bindValue(":description", $toDoDescription);
        $statement->execute();
        $statement->closeCursor();
    }
}

/*Check to see if we are deleting a toDoItem*/
else if(isset($_POST["deleteToDoItem"]))
{
    /*Sanitize the toDoItem to delete*/
    $deleteItemNum = filter_input(INPUT_POST, "deleteToDoItem",FILTER_SANITIZE_NUMBER_INT);

    /*Delete the toDoItem*/
    $query =    "DELETE FROM todoitems WHERE ItemNum = :itemNum";
    $statement = $db->prepare($query);
    $statement->bindValue(":itemNum",$deleteItemNum);
    $statement->execute();
    $statement->closeCursor();
}


/*Get current toDoItems from table*/
$query = "SELECT * FROM todoitems ORDER BY ItemNum ASC";
$statement = $db->prepare($query);
$statement->execute();
$toDoItems = $statement->fetchAll();
$statement->closeCursor();

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="css/main.css">
</head>


<body>
    <header><h1>ToDo List</h1></header>
    <main>
        <?php if(empty($toDoItems)) { ?>
            <section>
                <div>No to do list items exist yet.</div>
            </section>
        <?php } else{?>
            <section>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <?php foreach ($toDoItems as $toDoItem) : ?>
                    <div class="Test flex-container flex-between">
                        <div class="flex-item">
                            <h5><?=$toDoItem['Title']?></h5>
                            <div class="description"><?=$toDoItem['Description']?></div>
                        </div>
                        <div class="flex-item">
                            <button class="Delete" type="submit" name="deleteToDoItem" value="<?=$toDoItem['ItemNum']?>">&#x274C;</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                </form>
            </section>
        <?php } ?>
        <section>
            <h2>Add Item</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="Test flex-container flex-between">
                    <div class="flex-item" style="width: 100%">
                        <input type="text" placeholder="Title" name="title" maxlength="20" required style="width:100%; font-size: 1.5rem;">
                        <input type="text" placeholder="Description" name="desc" maxlength="50" required style="width:70%; font-size:1.5rem; margin-top: .3rem;">
                    </div>
                    <div class="flex-item">
                        <button id= "AddItem" class="Delete" type="submit" name="addToDoItem" value="True">
                            Add</br>Item
                        </button>
                    </div>
                </div>
            </form>
        </section>

    </main>
<footer
    <div>&copy; <?php echo date("Y"); ?> FHSU Developer</div>
</body>
</html>
<?php
/*Debug POST variables*/
/*echo "<pre>"; print_r($_POST) ;  echo "</pre>"; */
