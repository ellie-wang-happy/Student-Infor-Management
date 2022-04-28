<?php
	class Student{		

		private $id;
		private $name;
		private $birthdate;
		private $image;
				
		function __construct($id, $name, $birthdate, $image){
			$this->setId($id);
			$this->setName($name);
			$this->setBirthDate($birthdate);
			$this->setImage($image);
			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getBirthDate(){
			return $this->birthdate;
		}
		
		public function setBirthDate($birthdate){
			$this->birthdate = $birthdate;
		}

		public function getImage(){
			return $this->image;
		}

		public function setImage($image){
			$this->image = $image;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>