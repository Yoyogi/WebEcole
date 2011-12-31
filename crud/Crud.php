<?php
require_once $icrud_file;

class Crud implements ICrud {
    var $connection;
    public static $instance = NULL;
    
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
        $student = new Etudiant();
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
        if (Doctrine_Core::getTable("Etudiant")->findOneBy("id_etudiant", $idStudent)) {
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
        if (Doctrine_Core::getTable("Etudiant")->find($idStudent)) {
            $student = Doctrine_Core::getTable("Etudiant")->find($idStudent);
            $student->delete();
        }
    }
    
    function getStudents() {
        return Doctrine_Core::getTable("Etudiant")->findAll();
    }
    
    function getStudentById($id) {
        return Doctrine_Core::getTable("Etudiant")->findOneBy("id_etudiant", $id);
    }
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function createTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        $teacher = new Enseignant();
        $teacher->nom = $nom;
        $teacher->prenom = $prenom;
        $teacher->date_naissance = $date_naisse;
        $teacher->rue = $rue;
        $teacher->cp = $cp;
        $teacher->ville = $ville;
        $teacher->email = $email;
        $teacher->ulogin = $ulogin;
        $teacher->passwd = $passwd;
        
        $teacher->save();
        
    }
    function updateTeacher($id, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        if (Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id)) {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id);
            $teacher->nom = $nom;
            $teacher->prenom = $prenom;
            $teacher->date_naissance = $date_naisse;
            $teacher->rue = $rue;
            $teacher->cp = $cp;
            $teacher->ville = $ville;
            $teacher->email = $email;
            $teacher->ulogin = $ulogin;
            $teacher->passwd = $passwd;

            $teacher->save();
        }
    }
    
    function deleteTeacher($idTeacher) {
        if (Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher)) {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher);
            $teacher->delete();
        }
    }
    
    function getTeachers() {
        return Doctrine_Core::getTable("Enseignant")->findAll();
    }
    
    function getTeacherById($id) {
        return Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id);
    }
    
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function getAdmins() {
        return Doctrine_Core::getTable("Administrateur")->findAll();
    }
    
    function getAdminById($id) {
        return Doctrine_Core::getTable("Administrateur")->findOneBy("id_administrateur", $id);
    }
    
    
    //---------------------------------------------------
    /* CRUD ABSENCES */
    //---------------------------------------------------
    function getAbsences() {
        return Doctrine_Core::getTable("Absence")->findAll();
    }
    
    function getAbsencesBylesson($idLesson) {
        return Doctrine_Core::getTable("Absence")->findBy("id_cours", $idLessons);
    }
    
    function getAbsencesByStudent($idStudent) {
        return Doctrine_Core::getTable("Absence")->findBy("id_etudiant", $idStudent);
    }
    
    
    //---------------------------------------------------
    /* CRUD COURS */
    //---------------------------------------------------
    function getLessons() {
        return Doctrine_Core::getTable("Cours")->findAll();
    }
    
    function getLessonsByTeacher($idTeacher) {
        return Doctrine_Core::getTable("Cours")->findBy("id_enseignant", $idTeacher);
    }
    
    function getLessonsBySubject($idSubject) {
        return Doctrine_Core::getTable("Cours")->findBy("id_matiere", $idSubject);
    }
    
    function getLessonsByPromotion($idPromotion) {
        return Doctrine_Core::getTable("Cours")->findBy("id_promotion", $idPromotion);
    }
    
    
    //---------------------------------------------------
    /* CRUD MATIERES */
    //---------------------------------------------------
    function getSubjects() {
        return Doctrine_Core::getTable("Matiere")->findAll();
    }
    
    function getSubjectsByTeacher($idTeacher) {
        $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher);
        $subjects = $teacher->Matieres;
        echo $subjects;
        foreach ($subjects as $subject) {
            echo $subject->id_matiere + " : " + $subject->libelle + "\n";
        }
    }
    
    function getSubjectsByLesson($idLesson) {
        $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $idLesson);
        $idSubject = $lesson->id_matiere;
        return Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $idSubject);
    }
}

?>
