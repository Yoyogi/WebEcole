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
        $students = Doctrine_Core::getTable("Etudiant")->findAll();
        if ($students != null) {
            return $students;
        }
        return null;
    }
    
    function getStudentById($id) {
        $student = Doctrine_Core::getTable("Etudiant")->findOneBy("id_etudiant", $id);
        if ($student != null) {
            return $student;
        }
        return null;
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
        $teachers = Doctrine_Core::getTable("Enseignant")->findAll();
        if ($teachers != null) {
            return $teachers;
        }
        return null;
    }
    
    function getTeacherById($id) {
        $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id);
        if ($teacher != null) {
            return $teacher;
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function getAdmins() {
        $admins = Doctrine_Core::getTable("Administrateur")->findAll();
        if ($admins != null) {
            return $admins;
        }
        return null;
    }
    
    function getAdminById($id) {
        $admin = Doctrine_Core::getTable("Administrateur")->findOneBy("id_administrateur", $id);
        if ($admin != null) {
            return $admin;
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD ABSENCES */
    //---------------------------------------------------
    function getAbsences() {
        $absences = Doctrine_Core::getTable("Absence")->findAll();
        if ($absences != null) {
            return $absences;
        }
        return null;
    }
    
    function getAbsencesBylesson($idLesson) {
        $absences = Doctrine_Core::getTable("Absence")->findBy("id_cours", $idLessons);
        if ($absences != null) {
            return $absences;
        }
        return null;
    }
    
    function getAbsencesByStudent($idStudent) {
        $absences = Doctrine_Core::getTable("Absence")->findBy("id_etudiant", $idStudent);
        if ($absences != null) {
            return $absences;
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD COURS */
    //---------------------------------------------------
    function getLessons() {
        $lessons = Doctrine_Core::getTable("Cours")->findAll();
        if ($lessons != null) {
            return $lessons;
        }
        return null;
    }
    
    function getLessonsByTeacher($idTeacher) {
        $lessons = Doctrine_Core::getTable("Cours")->findBy("id_enseignant", $idTeacher);
        if ($lessons != null) {
            return $lessons;
        }
        return null;
    }
    
    function getLessonsBySubject($idSubject) {
        $lessons = Doctrine_Core::getTable("Cours")->findBy("id_matiere", $idSubject);
        if ($lessons != null) {
            return $lessons;
        }
        return null;
    }
    
    function getLessonsByPromotion($idPromotion) {
        $lessons = Doctrine_Core::getTable("Cours")->findBy("id_promotion", $idPromotion);
        if ($lessons != null) {
            return $lessons;
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD MATIERES */
    //---------------------------------------------------
    function getSubjects() {
        $subjects = Doctrine_Core::getTable("Matiere")->findAll();
        if ($subjects != null) {
            return $subjects;
        }
        return null;
    }
    
    function getSubjectsByTeacher($idTeacher) {
        $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher);
        $subjects = $teacher->Matieres;
        if ($subjects != null) {
            return $subjects;
        }
        return null;
    }
    
    function getSubjectByLesson($idLesson) {
        $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $idLesson);
        $idSubject = $lesson->id_matiere;
        
        $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $idSubject);
        if ($subject != null) {
            return $subject;
        }
        return null;
    }
}

?>
