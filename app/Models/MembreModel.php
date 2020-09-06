<?php namespace App\Models;

use CodeIgniter\Model;

class MembreModel extends Model{
    protected $table = 'membres';
    protected $allowedFields = ['identifiant', 'password', 'last_name', 'first_name', 'email', 'sex', 'nb_parain'];
    
    public function getMembres($identifiant = false, $password = false, $fonction = NULL){
        if($fonction === NULL){
            $userData = ($identifiant === false) ? $this->findAll() : $this->asArray()->where(['identifiant' => $identifiant ])->first();
            echo $password;
            return \password_verify($password, $userData['password']) ? $userData : false;
        }else{
            $userData = ($identifiant === false) ? $this->asArray()->where(['fonction' => $fonction]) : $this->asArray()->where(['fonction' => $fonction, 'identifiant' => $identifiant]);
            return \password_verify($password, $userData['password']) ? $userData : false;
        }
    }

    // Augmente le nombre de personne parrainé par l'utilisateur
    public function incrementUserNbParain($parainageCode){
        $userData = $this->asArray()->where(['code_parainage' => $parainageCode])->first();
        $this->save([
            'id' =>$userData['id'], 
            'code_parainage' => $userData['code_parainage']
        ]);
    }
}