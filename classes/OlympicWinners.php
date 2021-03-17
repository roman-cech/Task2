<?php
require_once "classes/Person.php";
require_once "classes/Placement.php";
require_once "classes/helper/Database.php";

class OlympicWinners
{
    private int $golds;
    private int $id;
    private string $name;
    private string $surname;
    private int $placing;
    private int $year;
    private string $city;
    private string $type;
    private string $discipline;
    private string $birth_day;
    private string $birth_place;
    private string $birth_country;
    private string $death_day;
    private string $death_place;
    private string $death_country;



    public function getOlympics(){
        return "
                <tr>
                    <td><a href='?getPerson=$this->id'>$this->name $this->surname</a> </td>
                    <td>$this->year</td>
                    <td>$this->city</td>
                    <td>$this->type</td>
                    <td>$this->discipline</td>
                    <td><a type='button' class='btn btn-success' href='edit-person.php?modify=$this->id'>Modify</a></td>
                    <td>
                        <form method='post' action='index.php?delete=$this->id'>
                            <button type='submit' name='deletePerson' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";
    }

    public function getMostValuableOlympic()
    {
        return "<tr>
                    <td>$this->golds</td>
                    <td><a href='?getPerson=$this->id'>".$this->name . " ". $this->surname."</a> </td>
                    <td>$this->birth_day</td>
                    <td>$this->birth_place</td>
                    <td>$this->birth_country</td>
                    <td>$this->death_day</td>
                    <td>$this->death_place</td>
                    <td>$this->death_country</td>
                    <td><a type='button' class='btn btn-success' href='edit-person.php?modify=$this->id'>Modify</a></td>
                    <td>
                        <form method='post' action='index.php?delete=$this->id'>
                            <button type='submit' name='deletePerson' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";
    }

    public function getFullName(){
        return $this->name . " " . $this->surname;
    }

    public function getPersonData(){
        return "<p class='card-text'><i class='fas fa-medal'></i>$this->year $this->city $this->type $this->discipline</p>";
    }
}