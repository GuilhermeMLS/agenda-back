<?php


class calendarService
{
    public function getBirthdays($day, $month)
    {
        $sql = "SELECT * from persons 
                    WHERE DAY(birthday) = '".$day."'
                    AND MONTH(birthday) = '".$month."'";
        if ($day != null) {
            $sql = $sql." AND DAY(birthday) = ".$day;
        }
        $req = Database::getBdd()->prepare($sql);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
