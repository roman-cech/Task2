<?php
    include "classes/Person.php";
    include "classes/helper/Database.php";

    $db = new Database();
    if(isset($_POST['name'])) {
        try{
            $person = new Person();
            $person->setName($_POST['name']);
            $person->setSurname($_POST['surname']);
            $person->setBirthDay($_POST['birth_day']);
            $person->setBirthPlace($_POST['birth_place']);
            $person->setBirthCountry($_POST['birth_country']);

            $name = $person->getName();
            $surname = $person->getSurname();
            $birth_day = $person->getBirthDay();
            $birth_place = $person->getBirthPlace();
            $birth_country = $person->getBirthCountry();

            $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->getConnection()->prepare("INSERT INTO olympic_winners.osoby (name, surname, birth_day, birth_place, birth_country) VALUES (:name, :surname, :birth_day, :birth_place, :birth_country)");

            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":surname", $surname, PDO::PARAM_STR);
            $stmt->bindParam(":birth_day", $birth_day, PDO::PARAM_STR);
            $stmt->bindParam(":birth_place", $birth_place, PDO::PARAM_STR);
            $stmt->bindParam(":birth_country", $birth_country, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e){
            header("Refresh:0; url = index.php");

        }
        header("Refresh:0; url = index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Olympic</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/44b171361e.js" crossorigin="anonymous"></script>
</head>
<body class="p-5 bg-info">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center mb-3">
                <h1 class="text-light display-2">Add Olympic</h1>
                <a type='button' class='btn btn-warning m-3' href='index.php'>Olympic winners</a>
                <div class="container">
                    <form method="post" action="new-person.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="birth_day" name="birth_day" placeholder="Birth day...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Birth place...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="birth_country" name="birth_country" placeholder="Birth country...">
                        </div>
                        <input type="submit" class="btn btn-success btn-lg">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
