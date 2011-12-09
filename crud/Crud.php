<?php
require_once $icrud_file;

class Crud implements ICrud {
    var $connection;
    private static $instance = NULL;
    
    function Crud() {
        $connection = Doctrine_Manager::connection(CFG_DB_DSN);
    }
    
    static public function getInstance() {
        if (Crud::$instance == NULL) {
            Crud::$instance = new Crud();
        }
        return Crud::$instance;
    }
    
    //---------------------------------------------------
    /* CRUD ETUDIANT */
    //---------------------------------------------------
    function createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        $student = new Student();
        $student->nom = $nom;
        $student->prenom = $prenom;
        $student->date_naissance = $date_naisse;
        $student->rue = $rue;
        $student->cp = $cp;
        $student->ville = $ville;
        $student->email = $email;
        $student->ulogin = $ulogin;
        $student->passwd = $passwd;
        $student->photo = $photo;
        
        $student->save();
    }
    
    function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        if (Doctrine_Core::getTable("Student")->find($idStudent)) {
            $student = $this->getStudentById($idStudent);
            $student->nom = $nom;
            $student->prenom = $prenom;
            $student->date_naissance = $date_naisse;
            $student->rue = $rue;
            $student->cp = $cp;
            $student->ville = $ville;
            $student->email = $email;
            $student->ulogin = $ulogin;
            $student->passwd = $passwd;
            $student->photo = $photo;

            $student->save();
        }
    }
    
    function deleteStudent($idStudent) {
        if (Doctrine_Core::getTable("Student")->find($idStudent)) {
            $student = Doctrine_Core::getTable("Student")->find($idStudent);
            $student->delete();
        }
    }
    
    function getStudents() {
        return Doctrine_Core::getTable("Student")->findAll();
    }
    
    function getStudentById($id) {
        return Doctrine_Core::getTable("Student")->find($id);
    }
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function createTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteTeacher($idTeacher);
    function getTeachers() {
        return Doctrine_Core::getTable("Teacher")->findAll();
    }
    function getTeacherById($id);
    
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function getAdmins();
    function getAdminById($id);
    
    
    //---------------------------------------------------
    /* CRUD ABSENCES */
    //---------------------------------------------------
    function getAbsencesBylesson($idLesson);
    function getAbsencesByStudent($idStudent);
    
    
    //---------------------------------------------------
    /* CRUD COURS */
    //---------------------------------------------------
    function getLessons();
    function getLessonsByTeacher($idTeacher);
    function getLessonsBySubject($idSubject);
    function getLessonsByPromotion($idPromotion);
    
    
    //---------------------------------------------------
    /* CRUD MATIERES */
    //---------------------------------------------------
    function getSubjects();
    function getSubjectsByTeacher($idTeacher);
    function getSubjectsByLesson($idLesson);
}

?>
