<?php
require_once('abstractDAO.php');
require_once('./model/student.php');

class studentDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getStudent($studentId){
        $query = 'SELECT * FROM students WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $student = new Student($temp['id'],$temp['name'], $temp['birthDate'], $temp['image']);
            $result->free();
            return $student;
        }
        $result->free();
        echo 'get null';
        return false;
    }


    public function getStudents(){
        //The query method returns a mysqli_result object

        $result = $this->mysqli->query('SELECT * FROM students');
        if($result == NULL){
            echo "no students found";
        }
        $students = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new student object, and add it to the array.
               // $student = new student($temp['id'],$temp['name'], $temp['birthDate'],temp['image']);
                $student = new Student($row['id'],$row['name'], $row['birthDate'],$row['image']);
                $students[] = $student;
            }
            $result->free();
            return $students;
        }
        $result->free();
        return false;
    }   
    
    public function addStudent($student){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO students (name, birthDate, image) VALUES (?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $student->getName();
			        $birthDate = $student->getBirthDate();
			        $image = $student->getImage(); 
			        $stmt->bind_param('sss', 
				        $name,
				        $birthDate,
				        $image
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $student->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updateStudent($student){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE students SET name=?, birthDate=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $student->getId();
                    $name = $student->getName();
			        $birthDate = $student->getBirthDate();
			        $image = $student->getImage();
			        $stmt->bind_param('sssi', 
				        $name,
				        $birthDate,
				        $image,
                        $id
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $student->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteStudent($studentId){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM students WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $studentId);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

