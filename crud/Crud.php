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
        $student->date_naissance = $date_naissance;
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
            $student->date_naissance = $date_naissance;
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
    
    function getStudentByLogin($login) {
        $student = Doctrine_Core::getTable("Etudiant")->findOneBy("ulogin", $login);
        if ($student != null) {
            return $student;
        }
        return null;
    }
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function createTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        $teacher = new Enseignant();
        $teacher->nom = $nom;
        $teacher->prenom = $prenom;
        $teacher->rue = $rue;
        $teacher->cp = $cp;
        $teacher->ville = $ville;
        $teacher->email = $email;
        $teacher->ulogin = $ulogin;
        $teacher->passwd = $passwd;
        
        $teacher->save();
        
    }
    function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        if (Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id)) {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id);
            $teacher->nom = $nom;
            $teacher->prenom = $prenom;
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
    
    function getTeacherByLogin($login) {
        $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("ulogin", $login);
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
    
    function getAdminByLogin($login) {
        $admin = Doctrine_Core::getTable("Administrateur")->findOneBy("ulogin", $login);
        if ($admin != null) {
            return $admin;
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD ABSENCES */
    //---------------------------------------------------
    function createAbsence($motif, $etudiant, $cours) {
        $absence = new Absence();
        $absence->motif = $motif;
        $absence->id_etudiant = $etudiant->id_etudiant;
        $absence->id_cours = $cours->id_cours;
        $absence->Etudiant = $etudiant;
        $absence->Cours = $cours;
        $absence->save();
    }
    
    function updateAbsence($id, $motif, $etudiant, $cours) {
        if (Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id)) {
            $absence = Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id);
            $absence->motif = $motif;
            $absence->id_etudiant = $etudiant->id_etudiant;
            $absence->id_cours = $cours->id_cours;
            $absence->Etudiant = $etudiant;
            $absence->Cours = $cours;

            $absence->save();
        }
    }
    
    function deleteAbsence($id) {
        if (Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id)) {
            $absence = Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id);
            $absence->delete();
        }
    }
    
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
    function createLesson($date, $duree, $descript, $enseignant, $promotion, $matiere) {
        $lesson = new Cours();
        $lesson->date_cours = $date;
        $lesson->duree = $duree;
        $lesson->descript = $descript;
        $lesson->id_enseignant = $enseignant->id_enseignant;
        $lesson->id_promotion = $promotion->id_promotion;
        $lesson->id_matiere = $matiere->id_matiere;
        $lesson->Enseignant = $enseignant;
        $lesson->Promotion = $promotion;
        $lesson->Matiere = $matiere;

        $lesson->save();
    }
    
    function updateLesson($id, $date, $duree, $descript, $enseignant, $promotion, $matiere) {
        if (Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id)) {
            $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id);
            $lesson->date_cours = $date;
            $lesson->duree = $duree;
            $lesson->descript = $descript;
            $lesson->id_enseignant = $enseignant->id_enseignant;
            $lesson->id_promotion = $promotion->id_promotion;
            $lesson->id_matiere = $matiere->id_matiere;
            $lesson->enseignant = $enseignant;
            $lesson->promotion = $promotion;
            $lesson->matiere = $matiere;
            
            $lesson->save();
        }
    }
    
    function deleteLesson($id) {
        if (Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id)) {
            $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id);
            $lesson->delete();
        }
    }
    
    function addAbsence($absence) {
        if (!$lesson->Absences->contains($absence)) {
            $lesson->Absences->add($absence);
            $lesson->Absences->save();
            $lesson->save();
        }
    }
    
    function removeAbsence($absence) {
        if (!$lesson->Absences->contains($absence)) {
            $lesson->Absences->remove($absence);
            $lesson->Absences->save();
            $lesson->save();
        }
    }
    
    function addExercice($exercice) {
        if (!$lesson->Exercices->contains($exercice)) {
            $lesson->Exercices->add($exercice);
            $lesson->Exercices->save();
            $lesson->save();
        }
    }
    
    function removeExercice($exercice) {
        if (!$lesson->Exercices->contains($exercice)) {
            $lesson->Absences->remove($exercice);
            $lesson->Exercices->save();
            $lesson->save();
        }
    }
    
    function getLessons() {
        $lessons = Doctrine_Core::getTable("Cours")->findAll();
        if ($lessons != null) {
            return $lessons;
        }
        return null;
    }
    
    function getLessonById($id) {
        $lessons = Doctrine_Core::getTable("Cours")->findBy("id_cours", $id);
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
