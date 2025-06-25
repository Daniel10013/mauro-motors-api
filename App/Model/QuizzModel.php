<?php

namespace App\Model;

class QuizzModel extends Model {
    private string $resultTable = "quizz_results";
    private string $quizzResponseTable = "user_quizz";

    public function save(string $encodedQuizzData, int $userId): bool{
        $query = "insert into {$this->quizzResponseTable} (user_id, responses) values(:user_id, :responses)";
        $result = $this->insert($query, ["user_id" => $userId, "responses" => $encodedQuizzData]);
        return $result != false ? true : false;
    }

    public function exists(int $userId): bool {
        $query = "select count(user_id) from {$this->quizzResponseTable} where user_id = :user_id";
        $exists = $this->select($query, ["user_id" => $userId]);

        if($exists[0]["count(user_id)"] == 0){
            return false;
        }
        return true;
    }

    public function updateData(string $responses, int $userId): bool {
        $query = "update {$this->quizzResponseTable} set responses = :responses where user_id = :user_id";
        $result = $this->update($query, ["responses" => $responses, "user_id" => $userId]);
        if($result == 0){
            return false;
        }
        return true;
    }

    public function getAnswersByUserId(int $userId): string {
        $query = "select responses from {$this->quizzResponseTable} where user_id = :user_id";
        $result = $this->select($query, ["user_id" => $userId]);
        return $result[0]['responses'];
    }

    public function getCarsByAnswers(array $answers) : array {
        $where = "engine_displacement = :engine_displacement and engine_type = :engine_type and car_size = :car_size and price_range = :price_range";
        $query = "select * from {$this->resultTable} where {$where} order by name";
        return $this->select($query, $answers);
    }

    public function checkQuizz(string $userId): bool {
        $query = "select 1 from {$this->quizzResponseTable} where user_id = :user_id";
        $result = $this->select($query, ["user_id" => $userId]);
        return empty($result) == false ? true : false;
    }
}
