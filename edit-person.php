<?php
    include "classes/helper/Database.php";
    include "classes/Person.php";

    $action = $_GET['modify'];
    $db = new Database();
    $person = new Person();
    try {
        $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $db->getConnection()->prepare("SELECT osoby.id,osoby.name,osoby.surname FROM olympic_winners.osoby WHERE osoby.id = :action;");
        $stmt->bindParam(":action", $action, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
        $person = $stmt->fetch();
    }
    catch (PDOException $exception){
        echo "Error: " . $exception->getMessage();
    }

    if(isset($_POST['name'])){
        if(isset($_POST['id'])){
            $person_id = $_POST['id'];
            $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $stmt = $db->getConnection()->prepare("SELECT osoby.id,osoby.name,osoby.surname FROM olympic_winners.osoby WHERE osoby.id = :person_id;");
            $stmt->bindParam(":person_id", $person_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Person");
            $person = $stmt->fetch();

            $person->setId($_POST['id']);
            $person->setName($_POST['name']);
            $person->setSurname($_POST['surname']);

            $stmt = $db->getConnection()->prepare("UPDATE olympic_winners.osoby SET osoby.name = :name, osoby.surname = :surname WHERE osoby.id = :id;");

            $id = $person->getId();
            $name = $person->getName();
            $surname = $person->getSurname();

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);

            $stmt->execute();

            header("Refresh:0; url = index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Olympic</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/44b171361e.js" crossorigin="anonymous"></script>
</head>
<body class="p-5 bg-info">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center mb-3">
                <h1 class="text-light display-2">Edit Olympic</h1>
                <a type='button' class='btn btn-warning m-3' href='index.php'>Olympic winners</a>
                <div class="container">
                    <form method="post" action="edit-person.php">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?php  echo  $person->getId();?>" placeholder="Name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" value="<?php  echo  $person->getName();?>" placeholder="Name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="surname" name="surname" value="<?php  echo  $person->getSurname();?>" placeholder="Surname...">
                        </div>
                        <input type="submit" class="btn btn-success btn-lg">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
