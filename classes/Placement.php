<?php


class Placement
{
    private int $id;
    private int $person_id;
    private int $oh_id;
    private int $placing;
    private string $discipline;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPersonId(): int
    {
        return $this->person_id;
    }

    /**
     * @param int $person_id
     */
    public function setPersonId(int $person_id): void
    {
        $this->person_id = $person_id;
    }

    /**
     * @return int
     */
    public function getOhId(): int
    {
        return $this->oh_id;
    }

    /**
     * @param int $oh_id
     */
    public function setOhId(int $oh_id): void
    {
        $this->oh_id = $oh_id;
    }

    /**
     * @return int
     */
    public function getPlacing(): int
    {
        return $this->placing;
    }

    /**
     * @param int $placing
     */
    public function setPlacing(int $placing): void
    {
        $this->placing = $placing;
    }

    /**
     * @return int
     */
    public function getDiscipline(): string
    {
        return $this->discipline;
    }

    /**
     * @param string $discipline
     */
    public function setDiscipline(string $discipline): void
    {
        $this->discipline = $discipline;
    }


}