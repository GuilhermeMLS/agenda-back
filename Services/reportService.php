<?php

class reportService
{
    /**
     * @return array
     */
    public function getReport()
    {
        $report = [];

        // Número total de contatos
        $sql = "SELECT count(id) as count_persons FROM persons";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $count_persons = $req->fetch(PDO::FETCH_ASSOC);
        array_push($report, $count_persons);

        // Quantos fazem aniversário esse mês
        $sql = "
            SELECT count(id) as birthdays_this_month from persons
            WHERE MONTH(birthday) = :this_month
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute(['this_month' => date('m')]);
        $birthdays_this_month = $req->fetch(PDO::FETCH_ASSOC);
        array_push($report, $birthdays_this_month);

        //Quantos vão fazer aniversário nos próximos 30 dias
        $sql = "
            SELECT count(id) as birthdays_next_30_days FROM  persons
            WHERE  DATE_ADD(birthday, INTERVAL YEAR(CURDATE())-YEAR(birthday)
                    + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(birthday),1,0)YEAR)
            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY);
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $birthdays_next_month = $req->fetch(PDO::FETCH_ASSOC);
        array_push($report, $birthdays_next_month);

        // Média de idade
        $sql = "
            SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) AS age_average FROM persons WHERE birthday IS NOT NULL;
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $age_average = $req->fetch(PDO::FETCH_ASSOC);
        array_push($report, $age_average);

        #Quantos contatos de cada DDD
        $count_ddd = [
            'count_ddd' => [],
        ];
        for ($i = 11; $i < 100; $i++) {
            $sql = "
                SELECT count(p.id) as '".$i."' FROM persons p
                LEFT JOIN phones ph
                    ON p.id = ph.user_id
                WHERE SUBSTRING(ph.phone, 1, 4) = '(".$i.")'
            ";
            $req = Database::getBdd()->prepare($sql);
            $req->execute();
            $count = $req->fetch(PDO::FETCH_ASSOC);
            if($count[$i] > 0) {
                array_push($count_ddd['count_ddd'], $count);
            }
        }
        array_push($report, $count_ddd);

        return $report;
    }
}
