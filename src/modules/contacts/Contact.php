<?php

namespace Modules\contacts;

use Source\Model;

class Contact extends Model 
{

	protected static $table = 'contacts';

	/**
	 * Retourne la valeur de id
	 *
	 * @return Integer
	 */
	public function getId($valeur) {
		 return $this->id;
	}

	/**
	 * Affecte la valeur $valeur à id
	 *
	 * @param Integer $id
	 * @return Integer
	 */
	public function setId($valeur) {
		$this->id = $valeur;
	}

	/**
	 * Retourne la valeur de email
	 *
	 * @return String
	 */
	public function getEmail($valeur) {
		 return $this->email;
	}

	/**
	 * Affecte la valeur $valeur à email
	 *
	 * @param String $email
	 * @return String
	 */
	public function setEmail($valeur) {
		$this->email = $valeur;
	}

	/**
	 * Retourne la valeur de nom
	 *
	 * @return String
	 */
	public function getNom($valeur) {
		 return $this->nom;
	}

	/**
	 * Affecte la valeur $valeur à nom
	 *
	 * @param String $nom
	 * @return String
	 */
	public function setNom($valeur) {
		$this->nom = $valeur;
	}

	/**
	 * Retourne la valeur de prenom
	 *
	 * @return String
	 */
	public function getPrenom($valeur) {
		 return $this->prenom;
	}

	/**
	 * Affecte la valeur $valeur à prenom
	 *
	 * @param String $prenom
	 * @return String
	 */
	public function setPrenom($valeur) {
		$this->prenom = $valeur;
	}

	/**
	 * Retourne la valeur de user_id
	 *
	 * @return Void
	 */
	public function getUser_id($valeur) {
		 return $this->user_id;
	}

	/**
	 * Affecte la valeur $valeur à user_id
	 *
	 * @param Void $user_id
	 * @return Void
	 */
	public function setUser_id($valeur) {
		$this->user_id = $valeur;
	}

	/**
	 * Valide les données de Contact
	 *
	 * @param Object $ContactData
	 * @return Boolean
	 */
	public static function valider($ContactData) {
		foreach ($ContactData as $data) {
			if (gettype($data) !== 'string'
			 && gettype($data) !== 'integer'
			 && gettype($data) !== 'boolean'
			 && gettype($data) !== 'NULL') {
				return false;
			}
		}
		return true;
	}

	/**
	 * Retourne la valeur de Contact
	 *
	 * @return Boolean
	 */
	public function creer() {
		$colonnesString = "";
		$valeursString = "";
		$colonnes = get_object_vars($this);

		foreach ($colonnes as $colonne => $valeur) {
			$colonnesString .= "{$colonne}, ";
			$valeursString .= "{$valeur}, ";
		}

		$colonnesString = substr($colonnesString, 0, -2);
		$valeursString = substr($valeursString , 0, -2);

		$creation = Base::getInstance()->query("INSERT INTO contacts ({$colonnesString}) VALUES({$valeursString})");

		if ($creation === false) { return false; }

		return true;
	}

	/**
	 * Retourne la liste des Adresses du contact
	 *
	 * @return Array
	 */
	public function getAdresses() {
		return Base::getInstance()->query("SELECT * FROM contacts INNER JOIN Adresses ON contact.id=Adresses.contacts_id WHERE Adresses.contacts_id=''")->fetchObject();
	}


	/**
	 * Retourne le User du contact
	 *
	 * @return Object
	 */
	public function getUser() {
		return Users::findById($this->id);
	}

}
