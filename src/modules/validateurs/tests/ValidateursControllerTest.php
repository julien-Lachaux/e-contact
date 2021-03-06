<?php

namespace Modules\validateurs\tests;

require(__DIR__ . "/../../../class/interfaces/RequeteInterface.php");
require(__DIR__ . "/../../../class/interfaces/ReponseInterface.php");
require(__DIR__ . "/../../../class/Requete.php");
require(__DIR__ . "/../../../class/Controller.php");
require(__DIR__ . "/../ValidateursController.php");

use Source\Requete;
use PHPUnit\Framework\TestCase;
use Modules\validateurs\ValidateursController;

class ValidateursControllerTest extends TestCase {

    /**
     * test validateurEmail avec un paramètre n'implementant pas la class Requete
     * @expectedException TypeError
     */
    public function testValidateurEmailTypeError() {
        $ValidateursController = new ValidateursController;
        $parametreInvalide = new ValidateursController();
        $ValidateursController->validateurEmail($parametreInvalide);
    }

    /**
     * test validateurEmail sans email
     */
    public function testValidateurEmailSansEmail() {
        $requete = new Requete(array(
            "requestMethod" => "POST",
            "body"          => array("")
        ));
        $ValidateursController = new ValidateursController;
        
        $reponsePattern = [ "erreur" => "requete invalide" ];
        $reponsePattern = json_encode($reponsePattern, JSON_FORCE_OBJECT);
        $this->assertJsonStringEqualsJsonString($reponsePattern, $ValidateursController->validateurEmail($requete));
    }

    /**
     * test validateurEmail avec un email invalide
     */
    public function testValidateurEmailEmailInvalide() {
        $requete = new Requete(array(
            "requestMethod" => "POST",
            "body"          => [ "email" => "test" ],
        ));
        $ValidateursController = new ValidateursController;

        $reponsePattern = [
            "email"         => "test",
            "emailValide"   => false
        ];
        $reponsePattern = json_encode($reponsePattern, JSON_FORCE_OBJECT);
        $this->assertJsonStringEqualsJsonString($reponsePattern, $ValidateursController->validateurEmail($requete));
    }

    /**
     * test validateurEmail avec un email valide
     */
    public function testValidateurEmailEmailValide() {
        $requete = new Requete(array(
            "requestMethod" => "POST",
            "body"          => [ "email" => "lachauxwebdev@gmail.com" ]
        ));
        $ValidateursController = new ValidateursController;

        $reponsePattern = [
            "email"         => "lachauxwebdev@gmail.com",
            "emailValide"   => true
        ];
        $reponsePattern = json_encode($reponsePattern, JSON_FORCE_OBJECT);
        $this->assertJsonStringEqualsJsonString($reponsePattern, $ValidateursController->validateurEmail($requete));
    }

}
