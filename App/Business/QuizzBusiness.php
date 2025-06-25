<?php

namespace App\Business;

use App\Lib\Auth\JWT;

class QuizzBusiness extends Business{

    public function validateData(array $requestData): bool{
        if(empty($requestData) == true){
            return false;
        }

        $requestData = array_values($requestData);

        $engine_displacement = ['1.0L', '1.0L - 2.0L', '2.0L and above'];
        $engine_type = ['gasoline', 'diesel', 'electric', 'hybrid'];
        $car_size = ['hatch', 'coupe', 'suv', 'offroad', 'sedan'];
        $price_range = ['up to 50k', '50k to 100k', '100k to 150k', '150k and above'];

        $allowedValues = [$engine_displacement, $engine_type, $car_size, $price_range];
        foreach($allowedValues as $index => $values){
            if(in_array($requestData[$index], $values) == false){
                return false;
            }
        }
        
        return true;
    }

    public function save(array $quizzData): bool {
        $userId = JWT::getSessionData("sub");
        $encodedQuizzResponses = json_encode($quizzData);
        $hasSaved = $this->model->save($encodedQuizzResponses, $userId);
        return $hasSaved;
    }

    public function update(array $quizzData): bool {
        $userId = JWT::getSessionData("sub");
        $encodedData = json_encode($quizzData);
        $hasUpdated = $this->model->updateData($encodedData, $userId);
        return $hasUpdated;
    }

    public function quizzWasAnswered(): bool{
        $userId = JWT::getSessionData("sub");
        $userResponseExists = $this->model->exists($userId);
        return $userResponseExists;
    }

    public function getCars(): array {
        $userAnswers = $this->getAnswers();
        $cars = $this->model->getCarsByAnswers($userAnswers);
        return $cars;
    }

    private function getAnswers(): array {
        $userId = JWT::getSessionData('sub');
        $databaseData = $this->model->getAnswersByUserId($userId);
        $userAnswers= json_decode($databaseData, true);
        return $userAnswers;
    }

    public function checkQuizz(string $userId): bool {
        return $this->model->checkQuizz($userId);
    }
}