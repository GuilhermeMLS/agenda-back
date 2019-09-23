<?php

class mixService
{
    /**
     * @param $jsonBody
     */
    public function mixByName($jsonBody)
    {
        $sql = "
            SELECT GROUP_CONCAT(p.id) as ids,
                   GROUP_CONCAT(p.email) as emails,
                   GROUP_CONCAT(p.birthday) as birthdays,
                   GROUP_CONCAT(p.company) as companies,
                   GROUP_CONCAT(p.name) as names,
                   GROUP_CONCAT(ph.phone) as phones
            FROM persons p
                     LEFT JOIN phones ph
                               ON p.id = ph.user_id
            WHERE p.name LIKE '" . $jsonBody->name . "%'
            GROUP BY p.name;
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $mergedContact['ids'] = $result[0]['ids'];
        $mergedContact['emails'] = $result[0]['emails'];
        $mergedContact['birthdays'] = $result[0]['birthdays'];
        $mergedContact['companies'] = $result[0]['companies'];
        $mergedContact['names'] = $result[0]['names'];
        $mergedContact['phones'] = $result[0]['phones'];

        for ($i = 0; $i < count($result)-1; $i++) {
            $mergedContact['ids'] = trim($mergedContact['ids'] . ','.$result[$i+1]['ids']);
            $mergedContact['emails'] = trim($mergedContact['emails'] . ','.$result[$i+1]['emails']);
            $mergedContact['birthdays'] = trim($mergedContact['birthdays'] . ','.$result[$i+1]['birthdays']);
            $mergedContact['companies'] = trim($mergedContact['companies'] . ','.$result[$i+1]['companies']);
            $mergedContact['names'] = trim($mergedContact['names'] . ','.$result[$i+1]['names']);
            $mergedContact['phones'] = trim($mergedContact['phones'] . ','.$result[$i+1]['phones']);
        }

        $ids = explode(',', $mergedContact['ids']);
        $unique_ids = array_unique($ids);
        if (count($unique_ids) == 1) {
            return;
        }
        $emails = explode(',', $mergedContact['emails']);
        $birthdays = explode(',', $mergedContact['birthdays']);
        $companies = explode(',', $mergedContact['companies']);
        $names = explode(',', $mergedContact['names']);
        $sql = "
            INSERT INTO persons
                (`name`, `company`, `birthday`, `email`, `created_at`, `updated_at`)
            VALUES
                (:variable, :company, :birthday, :email, :created_at, :updated_at)
        ";

        $req = Database::getBdd()->prepare($sql);
        $req->execute([
            'variable' => $names[0],
            'company' => $companies[0],
            'birthday' => $birthdays[0] == "" ? null : $birthdays[0],
            'email' => $emails[0],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $sql = "SELECT id FROM persons ORDER BY id DESC LIMIT 0, 1";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        $user_id = $req->fetch(PDO::FETCH_ASSOC);

        $phones = explode( ',', $mergedContact['phones']);
        foreach ($phones as $phone) {
            if ($phone != NULL) {
                $sql = "
                    INSERT INTO phones
                        (`user_id`, `phone`, `created_at`, `updated_at`)
                    VALUES
                        (:user_id, :phone, :created_at, :updated_at)
                ";
                $req = Database::getBdd()->prepare($sql);
                $req->execute([
                    'user_id' => (int)$user_id['id'],
                    'phone' => $phone,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        $this->deleteOldPersons($ids);
    }

    /**
     * @param $ids
     */
    private function deleteOldPersons($ids)
    {
        foreach ($ids as $id) {
            $id = (int)$id;
            $sql = 'DELETE FROM persons WHERE id = ?';
            $req = Database::getBdd()->prepare($sql);
            $req->execute([$id]);
        }
    }
}
