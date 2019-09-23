<?php


class Person extends Model
{
    /**
     * @param $name
     * @param $company
     * @param $birthday
     * @param $email
     * @return null |null
     */
    public function create(
        $name,
        $company,
        $birthday,
        $email
    ) {
        $sql = "
            INSERT INTO persons
                (`name`, `company`, `birthday`, `email`, `created_at`, `updated_at`)
            VALUES
                (:variable, :company, :birthday, :email, :created_at, :updated_at)
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([
            'variable' => $name,
            'company' => $company,
            'birthday' => $birthday,
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $sql = "
            SELECT p.id, p.name, p.company,
               p.birthday, p.email, ph.phone, ph.id as phone_id
            FROM persons p
                   LEFT JOIN phones ph
                   ON p.id=ph.user_id
            WHERE p.id = " . $id;
        ;
        $req = Database::getBdd()->prepare($sql);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function all()
    {
        $sql = "
            SELECT p.id,
                   p.name,
                   p.company,
                   p.birthday,
                   p.email,
                   GROUP_CONCAT(ph.phone) as phones
            FROM persons p
                LEFT JOIN phones ph
                    ON p.id=ph.user_id
            GROUP BY p.id;
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @param $name
     * @param $company
     * @param $birthday
     * @param $email
     * @return null |null
     */
    public function edit(
        $id,
        $name,
        $company,
        $birthday,
        $email
    ){
        $sql = "
            UPDATE persons SET
                `name` = :variable,
                `company` = :company,
                `birthday` = :birthday,
                `email` = :email,
                updated_at = :updated_at
            WHERE id = :id
        ";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([
            'id' => $id,
            'variable' => $name,
            'company' => $company,
            'birthday' => $birthday == '' ? null : $birthday,
            'email' => $email,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM persons WHERE id = ?';
        $req = Database::getBdd()->prepare($sql);

        return $req->execute([$id]);
    }
}
