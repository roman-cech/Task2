<?php
    include "classes/Placement.php";
    include "classes/helper/Database.php";

    $db = new Database();
    if(isset($_POST['person_id'])) {
        if (isset($_POST['oh_id'])) {
            $placement = new Placement();
            $placement->setPersonId($_POST['person_id']);
            $placement->setOhId($_POST['oh_id']);
            $placement->setPlacing($_POST['placing']);
            $placement->setDiscipline($_POST['discipline']);

            $person_id = $placement->getPersonId();
            $oh_id = $placement->getOhId();
            $placing = $placement->getPlacing();
            $discipline = $placement->getDiscipline();

            $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->getConnection()->prepare("INSERT INTO olympic_winners.umiestnenia (person_id,oh_id,placing,discipline) VALUES (:person_id, :oh_id, :placing, :discipline)");

            $stmt->bindParam(":person_id", $person_id, PDO::PARAM_INT);
            $stmt->bindParam(":oh_id", $oh_id, PDO::PARAM_INT);
            $stmt->bindParam(":placing", $placing, PDO::PARAM_INT);
            $stmt->bindParam(":discipline", $discipline, PDO::PARAM_STR);

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
    <title>Add Placement</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/44b171361e.js" crossorigin="anonymous"></script>
</head>
<body class="p-5 bg-info">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center mb-3">
                <h1 class="text-light display-2">Add Placement</h1>
                <a type='button' class='btn btn-warning m-3' href="index.php">Olympic winners</a>
                <div class="container">
                    <form method="post" action="new-placement.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="number" class="form-control" id="person_id" name="person_id" placeholder="Person identity number..." min="0">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="oh_id" name="oh_id" placeholder="Olympic games identity number..." min="0" max="25">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="placing" name="placing" placeholder="Placing...">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="discipline" name="discipline" placeholder="Discipline...">
                        </div>
                        <input type="submit" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
