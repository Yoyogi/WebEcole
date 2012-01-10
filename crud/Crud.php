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
        try {
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
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        try {
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
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteStudent($idStudent) {
        try {
            if (Doctrine_Core::getTable("Etudiant")->find($idStudent)) {
                $student = Doctrine_Core::getTable("Etudiant")->find($idStudent);
                $student->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addPromotionToStudent(Etudiant $student, Promotion $promotion) {
        try {
            if (!$student->Promotions->contains($promotion)) {
                $student->Promotions->add($promotion);
                $student->Promotions->save();
            }

            if (!$promotion->Etudiants->contains($student)) {
                $promotion->Etudiants->add($student);
                $promotion->Etudiants->save();
            }

            $sp = new EtudiantPromotion();
            $sp->id_etudiant = $student->id_etudiant;
            $sp->id_promo = $promotion->id_promo;
            $sp->Etudiant = $student;
            $sp->Promotion = $promotion;

            if (!$student->EtudiantPromotion->contains($sp)) {
                $student->EtudiantPromotion->add($sp);
                $student->EtudiantPromotion->save();
            }

            if (!$promotion->EtudiantPromotion->contains($sp)) {
                $promotion->EtudiantPromotion->add($sp);
                $promotion->EtudiantPromotion->save();
            }

            $r_sp = Doctrine_Core::getTable("EtudiantPromotion")->findOneById_etudiantAndId_promotion($student->id_etudiant, $promotion->id_promo);
            if ($r_sp == null) {
                $sp->save();
            }

            $student->save();
            $promotion->save();
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removePromotionToStudent(Etudiant $student, Promotion $promotion) {
        try {
            $sp = Doctrine_Core::getTable("EtudiantPromotion")->findOneById_etudiantAndId_promotion($student->id_etudiant, $promotion->id_promo);
            if ($sp != null) {
                $student->EtudiantPromotion->remove($sp);
                $student->EtudiantPromotion->save();
                $promotion->EtudiantPromotion->remove($sp);
                $promotion->EtudiantPromotion->save();
                $sp->delete();

                $student->Promotions->remove($promotion);
                $student->Promotions->save();

                $promotion->Etudiants->remove($student);
                $promotion->Etudiants->save();

                $student->save();
                $promotion->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addAbsenceToStudent(Absence $absence, Etudiant $student) {
        try {
            if (!$student->Absences->contains($absence)) {
                $student->Absences->add($absence);
                $student->Absences->save();
                $student->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeAbsenceToStudent(Absence $absence, Etudiant $student) {
        try {
            if (!$student->Absences->contains($absence)) {
                $student->Absences->remove($absence);
                $student->Absences->save();
                $student->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getStudents() {
        try {
            $students = Doctrine_Core::getTable("Etudiant")->findAll();
            if ($students != null) {
                return $students;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getStudentById($id) {
        try {
            $student = Doctrine_Core::getTable("Etudiant")->findOneBy("id_etudiant", $id);
            if ($student != null) {
                return $student;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getStudentByLogin($login) {
        try {
            $student = Doctrine_Core::getTable("Etudiant")->findOneBy("ulogin", $login);
            if ($student != null) {
                return $student;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getStudentByAbsence($absence) {
        try {
            $students = Doctrine_Core::getTable("Etudiant")->findAll();
            foreach ($students as $student) {
                if ($student->Absences->contains($absence)) {
                    return $student;
                }
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function createTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        try {
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
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        
    }
    function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        try {
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
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteTeacher($idTeacher) {
        try {
            if (Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher)) {
                $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher);
                $teacher->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addSubjectToTeacher(Enseignant $enseignant, Matiere $matiere) {
        try {
            if (!$enseignant->Matieres->contains($matiere)) {
                $enseignant->Matieres->add($matiere);
                $enseignant->Matieres->save();
            }

            if (!$matiere->Enseignants->contains($enseignant)) {
                $matiere->Enseignants->add($enseignant);
                $matiere->Enseignants->save();
            }

            $em = new EnseignantMatiere();
            $em->id_enseignant = $enseignant->id_enseignant;
            $em->id_matiere = $matiere->id_matiere;
            $em->Enseignant = $enseignant;
            $em->Matiere = $matiere;

            if (!$enseignant->EnseignantMatiere->contains($em)) {
                $enseignant->EnseignantMatiere->add($em);
                $enseignant->EnseignantMatiere->save();
            }

            if (!$matiere->EnseignantMatiere->contains($em)) {
                $matiere->EnseignantMatiere->add($em);
                $matiere->EnseignantMatiere->save();
            }

            $r_em = Doctrine_Core::getTable("EnseignantMatiere")->findOneById_enseignantAndId_matiere($enseignant->id_enseignant, $matiere->id_matiere);
            if ($r_em == null) {
                $em->save();
            }

            $enseignant->save();
            $matiere->save();
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeSubjectToTeacher(Enseignant $enseignant, Matiere $matiere) {
        try {
            $em = Doctrine_Core::getTable("EnseignantMatiere")->findOneById_enseignantAndId_matiere($enseignant->id_enseignant, $matiere->id_matiere);
            if ($em != null) {
                $enseignant->EnseignantMatiere->remove($em);
                $enseignant->EnseignantMatiere->save();
                $matiere->EnseignantMatiere->remove($em);
                $matiere->EnseignantMatiere->save();
                $em->delete();

                $enseignant->Matieres->remove($matiere);
                $enseignant->Matieres->save();

                $matiere->Enseignants->remove($enseignant);
                $matiere->Enseignants->save();

                $enseignant->save();
                $matiere->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addLessonToTeacher(Enseignant $enseignant, Cours $cours) {
        try {
            if (!$enseignant->Cours->contains($cours)) {
                $enseignant->Cours->add($cours);
                $enseignant->Cours->save();
                $enseignant->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeLessonToTeacher(Enseignant $enseignant, Cours $cours) {
        try {
            if (!$enseignant->Cours->contains($cours)) {
                $enseignant->Cours->remove($cours);
                $enseignant->Cours->save();
                $enseignant->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getTeachers() {
        try {
            $teachers = Doctrine_Core::getTable("Enseignant")->findAll();
            if ($teachers != null) {
                return $teachers;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getTeacherById($id) {
        try {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $id);
            if ($teacher != null) {
                return $teacher;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getTeacherByLogin($login) {
        try {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("ulogin", $login);
            if ($teacher != null) {
                return $teacher;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getTeacherByLesson($lesson) {
        try {
            $teachers = Doctrine_Core::getTable("Enseignant")->findAll();
            foreach ($teachers as $teacher) {
                if ($teacher->Cours->contains($lesson)) {
                    return $teacher;
                }
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD ENSEIGNANT */
    //---------------------------------------------------
    function getAdmins() {
        try {
            $admins = Doctrine_Core::getTable("Administrateur")->findAll();
            if ($admins != null) {
                return $admins;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getAdminById($id) {
        try {
            $admin = Doctrine_Core::getTable("Administrateur")->findOneBy("id_administrateur", $id);
            if ($admin != null) {
                return $admin;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getAdminByLogin($login) {
        try {
            $admin = Doctrine_Core::getTable("Administrateur")->findOneBy("ulogin", $login);
            if ($admin != null) {
                return $admin;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD ABSENCES */
    //---------------------------------------------------
    function createAbsence($motif, Etudiant $etudiant, Cours $cours) {
        try {
            $absence = new Absence();
            $absence->motif = $motif;
            $absence->id_etudiant = $etudiant->id_etudiant;
            $absence->id_cours = $cours->id_cours;
            $absence->Etudiant = $etudiant;
            $absence->Cours = $cours;
            $absence->save();

            $this->addAbsenceToStudent($absence, $etudiant);
            $this->addAbsenceToLesson($cours, $absence);
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateAbsence($id, $motif, Etudiant $etudiant, Cours $cours) {
        try {
            if (Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id)) {
                $absence = Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id);

                $this->removeAbsenceToStudent($absence, $etudiant);
                $this->removeAbsenceToLesson($cours, $absence);

                $absence->motif = $motif;
                $absence->id_etudiant = $etudiant->id_etudiant;
                $absence->id_cours = $cours->id_cours;
                $absence->Etudiant = $etudiant;
                $absence->Cours = $cours;
                $absence->save();

                $this->addAbsenceToStudent($absence, $etudiant);
                $this->addAbsenceToLesson($cours, $absence);
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteAbsence($id) {
        try {
            if (Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id)) {
                $absence = Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id);

                $student = $this->getStudentByAbsence($absence);
                $lesson = $this->getLessonByAbsence($absence);
                $this->removeAbsenceToStudent($absence, $student);
                $this->removeAbsenceToLesson($lesson, $absence);

                $absence->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getAbsences() {
        try {
            $absences = Doctrine_Core::getTable("Absence")->findAll();
            if ($absences != null) {
                return $absences;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getAbsencesBylesson($idLesson) {
        try {
            $absences = Doctrine_Core::getTable("Absence")->findBy("id_cours", $idLessons);
            if ($absences != null) {
                return $absences;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getAbsencesByStudent($idStudent) {
        try {
            $absences = Doctrine_Core::getTable("Absence")->findBy("id_etudiant", $idStudent);
            if ($absences != null) {
                return $absences;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD COURS */
    //---------------------------------------------------
    function createLesson($date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
        try {
            $lesson = new Cours();
            $lesson->date_cours = $date;
            $lesson->duree = $duree;
            $lesson->descript = $descript;
            $lesson->id_enseignant = $enseignant->id_enseignant;
            $lesson->id_promo = $promotion->id_promo;
            $lesson->id_matiere = $matiere->id_matiere;
            $lesson->Enseignant = $enseignant;
            $lesson->Promotion = $promotion;
            $lesson->Matiere = $matiere;
            $lesson->save();

            $this->addLessonToPromotion($promotion, $lesson);
            $this->addLessonToSubject($matiere, $lesson);
            $this->addLessonToTeacher($enseignant, $lesson);
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateLesson($id, $date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
        try {
            if (Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id)) {
                $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id);

                $this->removeLessonFromPromotion($promotion, $lesson);
                $this->removeLessonToSubject($matiere, $lesson);
                $this->removeLessonToTeacher($enseignant, $lesson);

                $lesson->date_cours = $date;
                $lesson->duree = $duree;
                $lesson->descript = $descript;
                $lesson->id_enseignant = $enseignant->id_enseignant;
                $lesson->id_promo = $promotion->id_promo;
                $lesson->id_matiere = $matiere->id_matiere;
                $lesson->enseignant = $enseignant;
                $lesson->promotion = $promotion;
                $lesson->matiere = $matiere;
                $lesson->save();

                $this->addLessonToPromotion($promotion, $lesson);
                $this->addLessonToSubject($matiere, $lesson);
                $this->addLessonToTeacher($enseignant, $lesson);
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteLesson($id) {
        try {
            if (Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id)) {
                $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id);

                $teacher = $this->getTeacherByLesson($lesson);
                $promotion = $this->getPromotionsByLesson($lesson);
                $subject = $this->getSubjectByLesson($id);
                $this->removeLessonFromPromotion($promotion, $lesson);
                $this->removeLessonToSubject($subject, $lesson);
                $this->removeLessonToTeacher($teacher, $lesson);

                $lesson->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addAbsenceToLesson(Cours $lesson, Absence $absence) {
        try {
            if (!$lesson->Absences->contains($absence)) {
                $lesson->Absences->add($absence);
                $lesson->Absences->save();
                $lesson->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeAbsenceToLesson(Cours $lesson, Absence $absence) {
        try {
            if (!$lesson->Absences->contains($absence)) {
                $lesson->Absences->remove($absence);
                $lesson->Absences->save();
                $lesson->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addExerciceToLesson(Cours $lesson, Exercice $exercice) {
        try {
            if (!$lesson->Exercices->contains($exercice)) {
                $lesson->Exercices->add($exercice);
                $lesson->Exercices->save();
                $lesson->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeExerciceToLesson(Cours $lesson, Exercice $exercice) {
        try {
            if (!$lesson->Exercices->contains($exercice)) {
                $lesson->Exercices->remove($exercice);
                $lesson->Exercices->save();
                $lesson->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getLessons() {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findAll();
            if ($lessons != null) {
                return $lessons;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getLessonById($id) {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findBy("id_cours", $id);
            if ($lessons != null) {
                return $lessons;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getLessonsByTeacher($idTeacher) {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findBy("id_enseignant", $idTeacher);
            if ($lessons != null) {
                return $lessons;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getLessonsBySubject($idSubject) {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findBy("id_matiere", $idSubject);
            if ($lessons != null) {
                return $lessons;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getLessonsByPromotion($idPromotion) {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findBy("id_promo", $idPromotion);
            if ($lessons != null) {
                return $lessons;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getLessonByAbsence($absence) {
        try {
            $lessons = Doctrine_Core::getTable("Cours")->findAll();
            foreach ($lessons as $lesson) {
                if ($lesson->Absences->contains($absence)) {
                    return $lesson;
                }
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD MATIERES */
    //---------------------------------------------------
    function createSubject($libelle) {
        try {
            $subject = new Matiere();
            $subject->libelle = $libelle;

            $subject->save();
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateSubject($id, $libelle) {
        try {
            if (Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id)) {
                $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
                $subject->libelle = $libelle;

                $subject->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteSubject($id) {
        try {
            if (Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id)) {
                $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
                $subject->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addTeacherToSubject(Matiere $subject, Enseignant $teacher) {
        $this->addSubjectToTeacher($teacher, $subject);
    }
    
    function removeTeacherToSubject(Matiere $subject, Enseignant $teacher) {
        $this->removeSubjectToTeacher($teacher, $subject);
    }
    
    function addLessonToSubject(Matiere $subject, Cours $lesson) {
        try {
            if (!$subject->Cours->contains($lesson)) {
                $subject->Cours->add($lesson);
                $subject->Cours->save();
                $subject->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeLessonToSubject(Matiere $subject, Cours $lesson) {
        try {
            if (!$subject->Cours->contains($lesson)) {
                $subject->Cours->remove($lesson);
                $subject->Cours->save();
                $subject->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getSubjects() {
        try {
            $subjects = Doctrine_Core::getTable("Matiere")->findAll();
            if ($subjects != null) {
                return $subjects;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getSubjectById($id) {
        try {
            $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
            if ($subject != null) {
                return $subject;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getSubjectsByTeacher($idTeacher) {
        try {
            $teacher = Doctrine_Core::getTable("Enseignant")->findOneBy("id_enseignant", $idTeacher);
            $subjects = $teacher->Matieres;
            if ($subjects != null) {
                return $subjects;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getSubjectByLesson($idLesson) {
        try {
            $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $idLesson);
            $idSubject = $lesson->id_matiere;

            $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $idSubject);
            if ($subject != null) {
                return $subject;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD AIDE */
    //---------------------------------------------------
    function createHelp($page, $libelle) {
        try {
            $help = new Aide();
            $help->libelle = $libelle;
            $help->page = $page;

            $help->save;
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateHelp($id, $page, $libelle) {
        try {
            if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
                $help = Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
                $help->libelle = $libelle;
                $help->page = $page;

                $help->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteHelp($id) {
        try {
            if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
                $help = Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);

                $help->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getHelps() {
        try {
            $helps = Doctrine_Core::getTable("Aide")->findAll();
            if ($helps != null) {
                return $helps;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getHelpById($id) {
        try {
            if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
                return Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getHelpsByPage($page) {
        try {
            if (Doctrine_Core::getTable("Aide")->findBy("page", $page)) {
                return Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD PROMOTION */
    //---------------------------------------------------
    function createPromotion($libelle) {
        try {
            $promotion = new Promotion();
            $promotion->libelle = $libelle;

            $promotion->save();
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updatePromotion($id, $libelle) {
        try {
            $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
            if ($promotion != null) {
                $promotion->libelle = $libelle;
                $promotion->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deletePromotion($id) {
        try {
            $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
            if ($promotion != null) {
                $promotion->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function addStudentToPromotion(Promotion $promotion, Etudiant $student) {
        $this->addPromotionToStudent($student, $promotion);
    }
    
    function removeStudentFromPromotion(Promotion $promotion, Etudiant $student) {
        $this->removePromotionToStudent($student, $promotion);
    }
    
    function addLessonToPromotion(Promotion $promotion, Cours $lesson) {
        try {
            if (!$promotion->Cours->contains($lesson)) {
                $promotion->Cours->add($lesson);
                $promotion->Cours->save();
                $promotion->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function removeLessonFromPromotion(Promotion $promotion, Cours $lesson) {
        try {
            if (!$promotion->Cours->contains($lesson)) {
                $promotion->Cours->remove($lesson);
                $promotion->Cours->save();
                $promotion->save();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getPromotions() {
        try {
            $promotions = Doctrine_Core::getTable("Promotion")->findAll();
            if ($promotions != null) {
                return $promotions;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getPromotionById($id) {
        try {
            $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
            if ($promotion != null) {
                return $promotion;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getPromotionsByStudent($student) {
        try {
            $results = array ();
            $promotions = $this->getPromotions();
            $i = 0;
            foreach ($promotions as $promotion) {
                if ($promotion->Etudiants->contains($student)) {
                    $results[$i] = $promotion;
                    $i++;
                }
            }
            return $results;
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getPromotionsByLesson($lesson) {
        try {
            $results = array ();
            $promotions = $this->getPromotions();
            $i = 0;
            foreach($promotions as $promotion) {
                if ($promotion->Cours->contains($lesson)) {
                    $results[$i] = $promotion;
                    $i++;
                }
            }
            return $results;
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    
    //---------------------------------------------------
    /* CRUD EXERCICE */
    //---------------------------------------------------
    function createExercice($libelle, Cours $lesson) {
        try {
            $exercice = new Exercice();
            $exercice->libelle = $libelle;
            $exercice->id_cours = $lesson->id_cours;
            $exercice->Cours = $lesson;
            $exercice->save();

            $this->addExerciceToLesson($lesson, $exercice);
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function updateExercice($id, $libelle, Cours $lesson) {
        try {
            $exercice = Doctrine_Core::getTable("Exercice")->findOneBy("id_exercice", $id);
            if ($exercice != null) {
                $this->removeExerciceToLesson($lesson, $exercice);

                $exercice->libelle = $libelle;
                $exercice->id_cours = $lesson->id_cours;
                $exercice->Cours = $lesson;
                $exercice->save();

                $this->addExerciceToLesson($lesson, $exercice);
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function deleteExercice($id) {
        try {
            $exercice = Doctrine_Core::getTable("Exercice")->findOneBy("id_exercice", $id);
            if ($exercice != null) {
                $exercice->delete();
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
    }
    
    function getExercices() {
        try {
            $exercices = Doctrine_Core::getTable("Exercice")->findAll();
            if ($exercices != null) {
                return $exercices;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getExerciceById($id) {
        try {
            $exercice = Doctrine_Core::getTable("Exercice")->findOneBy("id_exercice", $id);
            if ($exercice != null) {
                return $exercice;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
    
    function getExercicesByLesson($id_lesson) {
        try {
            $exercices = Doctrine_Core::getTable("Exercice")->findBy("id_cours", $id_lesson);
            if ($exercices != null) {
                return $exercices;
            }
        }
        catch (Doctrine_Validator_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Connection_Exception $e) {
            echo $e->errorMessage();
        }
        catch (Doctrine_Manager_Exception $e) {
            echo $e->errorMessage();
        }
        return null;
    }
}

?>
