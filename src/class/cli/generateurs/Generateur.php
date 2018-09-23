<?php
namespace Source\cli\generateurs;

use Source\Utils;

abstract class Generateur {

    protected $cheminDossierConfig;
    protected $cheminDossierModule;
    protected $cheminDossierDepots;
    protected $cheminDossierModels;

    /**
     * Constructeur
     */
    public function __construct() {
        $this->cheminDossierConfig = __DIR__ . "/../../../../config/orm";
        $this->cheminDossierModule = __DIR__ . "/../../../modules";
    }
    
    protected function genererClassHeader($nomClass, $nomModule, $abstract = false, $interface = false, $dependances = false) {
        $classHeader  = $this->ajouterLignePhp("<?php", 0, 2);
        $classHeader .= $this->ajouterLignePhp("namespace Modules\\{$nomModule};", 0, 2);
        if ($abstract !== false) { 
            $classHeader .= $this->ajouterLignePhp("use Source\\{$abstract};");
        }
        if ($dependances !== false) {
            foreach($dependances as $dependance) {
                $classHeader .= $this->ajouterLignePhp("use {$dependance->source}\\{$dependance->nom};");
            }
        }
        $classHeader .= $this->ajouterLignePhp("");
        
        $classHeaderDefinition = "class {$nomClass} ";
        if ($abstract !== false) { $classHeaderDefinition .= "extends {$abstract} "; }
        if ($interface !== false) { $classHeaderDefinition .= "implements {$interface} "; }
        
        $classHeader .= $this->ajouterLignePhp($classHeaderDefinition);
        $classHeader .= $this->ajouterLignePhp("{");

        return $classHeader;
    }

    protected function genererCommentaireMethode($description, $params = [], $retour = NULL) {
        $commentaire  = $this->ajouterLignePhp("/**", 1);
        $commentaire .= $this->ajouterLignePhp(" * {$description}", 1);
        $commentaire .= $this->ajouterLignePhp(" *", 1);

        foreach ($params as $param) {
            $commentaire .= $this->ajouterLignePhp(" * @param {$param->type} \${$param->nom}", 1);
        }

        if ($retour !== NULL) { $commentaire .= $this->ajouterLignePhp(" * @return {$retour}", 1); }

        $commentaire .= $this->ajouterLignePhp(" */", 1);

        return $commentaire;
    }

    protected function convertirTypeSqlVersPhp($sqlType) {
        switch ($sqlType) {

            case 'varchar':
                $phpType = "String";
                break;

            case 'text':
                $phpType = "String";
                break;

            case 'int':
                $phpType = "Integer";
                break;
            
            default:
                $phpType = "Void";
                break;

        }

        return $phpType;
    }

    protected function ajouterLignePhp($ligne, $indentation = 0, $sautDeLigne = 1) {
        $indentationTexte = "";
        for ($i=0; $i < $indentation; $i++) { 
            $indentationTexte .= "\t";
        }
        $sautDeLigneTexte = "";
        for ($i=0; $i < $sautDeLigne; $i++) { 
            $sautDeLigneTexte .= "\n";
        }
        $lignePhp = $indentationTexte . $ligne . $sautDeLigneTexte;
        return $lignePhp;
    }
}