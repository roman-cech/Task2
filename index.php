<?php
require_once "classes/OlympicWinners.php";
require_once "classes/helper/Database.php";
$url = $_GET['getPerson'];

    try {
        $db = new Database();
        $conn = $db->getConnection();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db = $conn->prepare("SELECT osoby.id, osoby.name, osoby.surname, oh.year, oh.city, oh.type, umiestnenia.discipline FROM olympic_winners.osoby JOIN olympic_winners.umiestnenia ON osoby.id = umiestnenia.person_id JOIN olympic_winners.oh ON oh.id = umiestnenia.oh_id where  placing = 1");
        $db->execute();
        $result = $db->fetchAll(PDO::FETCH_CLASS, "OlympicWinners");

        $db = $conn->prepare("SELECT SUM(umiestnenia.placing = 1) AS golds, o.* FROM olympic_winners.umiestnenia JOIN olympic_winners.osoby AS o ON umiestnenia.person_id = o.id GROUP BY o.id, o.name, o.surname, o.birth_day, o.birth_place, o.birth_country, o.death_day, o.death_place, o.death_country ORDER BY golds DESC LIMIT 10");
        $db->execute();
        $topResults = $db->fetchAll(PDO::FETCH_CLASS, "OlympicWinners");

        $db = $conn->prepare("SELECT osoby.id,osoby.name,osoby.surname,umiestnenia.placing,oh.year,oh.city,oh.type,umiestnenia.discipline FROM olympic_winners.osoby JOIN olympic_winners.umiestnenia ON osoby.id = umiestnenia.person_id JOIN olympic_winners.oh ON oh.id = umiestnenia.oh_id WHERE osoby.id = :url");
        $db->bindParam(":url", $url, PDO::PARAM_INT);
        $db->execute();
        $onePerson = $db->fetchAll(PDO::FETCH_CLASS, "OlympicWinners");
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $delete = $_GET['delete'];
    if(isset($_POST['deletePerson'])){
        if(isset($delete)){
            $db = new Database();
            $db->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $db->getConnection()->prepare("DELETE FROM olympic_winners.umiestnenia WHERE person_id = :delete");
            $stmt->bindParam(":delete", $delete, PDO::PARAM_INT);
            $stmt->execute();
            $stmt = $db->getConnection()->prepare("DELETE FROM olympic_winners.osoby WHERE id = :delete");
            $stmt->bindParam(":delete", $delete, PDO::PARAM_INT);
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
    <title>Olympic winners</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/44b171361e.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="p-5 bg-info">
        <div class="container-fluid">
            <div class="row">
                <div class="col text-center mb-3">
                    <h1 class="text-light display-2">Olympic winners</h1>
                    <?php
                        if($_GET['getPerson']){
                            echo "<button type='button' class='btn btn-warning m-3' onclick=\"location.href='?index.php'\">Olympic winners</button>
                                 <div class='container d-flex justify-content-center'>
                                    <div class='card my-auto'>
                                        <div class='card-body'>
                                        <img src='assets/gold_medal.png' alt='Gold medal!' width='200' height='200'>
                                            <h5 class='card-title'>";
                                                    echo $onePerson[0]->getfullName();
                                                    echo "</h5> ";
                                                    foreach ($onePerson as $item)
                                                        echo $item->getPersonData();
                                                    echo " 
                                        </div>
                                    </div>
                                 </div>
                </div>";
                        }
                        else{
                            echo "
                                <p class='lead text-dark'>It is whole database of Olympic winners!</p>
                                <div class='col text-center mb-3'>
                                    <a type='button' class='btn btn-warning' href='new-person.php'>Create a new sportsman!</a>
                                    <a type='button' class='btn btn-warning' href='new-placement.php'>Create a new placement!</a>
                                </div>
                                <table id='myTable' class='table table-bordered table-light'>
                                    <thead class='table-dark'>
                                        <tr>
                                            <th scope='col'>Full name</th><th scope='col'>Year of win</th><th scope='col'>Place</th><th scope='col'>Type of OG</th>
                                            <th scope='col'>Discipline</th><th scope='col'>Modify</th><th scope='col'>Delete</th>
                                            </tr>
                                    </thead>
                                <tbody>
                            ";
                            foreach ($result as $game)
                                echo $game->getOlympics();
                            echo "</tbody></table>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="p-4 bg-success">
        <div class="container-fluid">
            <div class="row">
                <div class="col text-center mb-3">
                    <h1 class="text-warning display-2">Top 10 Olympic winners</h1>
                </div>
            </div>
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Number of golds</th>
                    <th scope="col">Full name</th>
                    <th scope="col">Birth day</th>
                    <th scope="col">Birth place</th>
                    <th scope="col">Birth country</th>
                    <th scope="col">Death day</th>
                    <th scope="col">Death place</th>
                    <th scope="col">Death country</th>
                    <th scope="col">Modify</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($topResults as $person){
                            echo $person->getMostValuableOlympic();
                        }
                    ?>

                </tbody>
            </table>
        </div>
    </section>


</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/mathusummut/confetti.js/confetti.min.js"></script><script>confetti.start(10000);</script>
    <script src="script.js"></script>
</body>
</html>
