<?php

class tipsService
{
    /**
     * @return mixed
     */
    public function getTips()
    {
        $sql = "SELECT name FROM persons";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        foreach ($result as $name) {
            $names[$i++] = $this->getFirstName($name['name']);
        }

        foreach ($names as $name) {
            $sql = "SELECT * FROM persons WHERE name LIKE '".$name."%'";
            $req = Database::getBdd()->prepare($sql);
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 1) {
                $mesclar[$name] = $result;
            }
        }

        return $mesclar;
    }

    /**
     * @param $name
     * @return mixed
     */
    private function getFirstName($name){
        return explode(' ', $name)[0];
    }
}
