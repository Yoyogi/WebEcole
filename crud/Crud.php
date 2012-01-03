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
    
    function addPromotionToStudent(Etudiant $student, Promotion $promotion) {
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
    
    function removePromotionToStudent(Etudiant $student, Promotion $promotion) {
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
    
    function addAbsenceToStudent(Absence $absence, Etudiant $student) {
        if (!$student->Absences->contains($absence)) {
            $student->Absences->add($absence);
            $student->Absences->save();
            $student->save();
        }
    }
    
    function removeAbsenceToStudent(Absence $absence, Etudiant $student) {
        if (!$student->Absences->contains($absence)) {
            $student->Absences->remove($absence);
            $student->Absences->save();
            $student->save();
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
    
    function getStudentByAbsence($absence) {
        $students = Doctrine_Core::getTable("Etudiant")->findAll();
        foreach ($students as $student) {
            if ($student->Absences->contains($absence)) {
                return $student;
            }
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
    
    function addSubjectToTeacher(Enseignant $enseignant, Matiere $matiere) {
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
    
    function removeSubjectToTeacher(Enseignant $enseignant, Matiere $matiere) {
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
    
    function addLessonToTeacher(Enseignant $enseignant, Cours $cours) {
        if (!$enseignant->Cours->contains($cours)) {
            $enseignant->Cours->add($cours);
            $enseignant->Cours->save();
            $enseignant->save();
        }
    }
    
    function removeLessonToTeacher(Enseignant $enseignant, Cours $cours) {
        if (!$enseignant->Cours->contains($cours)) {
            $enseignant->Cours->remove($cours);
            $enseignant->Cours->save();
            $enseignant->save();
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
    
    function getTeacherByLesson($lesson) {
        $teachers = Doctrine_Core::getTable("Enseignant")->findAll();
        foreach ($teachers as $teacher) {
            if ($teacher->Cours->contains($lesson)) {
                return $teacher;
            }
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
    function createAbsence($motif, Etudiant $etudiant, Cours $cours) {
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
    
    function updateAbsence($id, $motif, Etudiant $etudiant, Cours $cours) {
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
    
    function deleteAbsence($id) {
        if (Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id)) {
            $absence = Doctrine_Core::getTable("Absence")->findOneBy("id_absence", $id);
            
            $student = $this->getStudentByAbsence($absence);
            $lesson = $this->getLessonByAbsence($absence);
            $this->removeAbsenceToStudent($absence, $student);
            $this->removeAbsenceToLesson($lesson, $absence);
            
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
    function createLesson($date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
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
        
        $this->addLessonToPromotion($promotion, $lesson);
        $this->addLessonToSubject($matiere, $lesson);
        $this->addLessonToTeacher($enseignant, $lesson);
    }
    
    function updateLesson($id, $date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
        if (Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id)) {
            $lesson = Doctrine_Core::getTable("Cours")->findOneBy("id_cours", $id);
            
            $this->removeLessonFromPromotion($promotion, $lesson);
            $this->removeLessonToSubject($matiere, $lesson);
            $this->removeLessonToTeacher($enseignant, $lesson);
            
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
        
            $this->addLessonToPromotion($promotion, $lesson);
            $this->addLessonToSubject($matiere, $lesson);
            $this->addLessonToTeacher($enseignant, $lesson);
        }
    }
    
    function deleteLesson($id) {
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
    
    function addAbsenceToLesson(Cours $lesson, Absence $absence) {
        if (!$lesson->Absences->contains($absence)) {
            $lesson->Absences->add($absence);
            $lesson->Absences->save();
            $lesson->save();
        }
    }
    
    function removeAbsenceToLesson(Cours $lesson, Absence $absence) {
        if (!$lesson->Absences->contains($absence)) {
            $lesson->Absences->remove($absence);
            $lesson->Absences->save();
            $lesson->save();
        }
    }
    
    function addExerciceToLesson(Cours $lesson, Exercice $exercice) {
        if (!$lesson->Exercices->contains($exercice)) {
            $lesson->Exercices->add($exercice);
            $lesson->Exercices->save();
            $lesson->save();
        }
    }
    
    function removeExerciceToLesson(Cours $lesson, Exercice $exercice) {
        if (!$lesson->Exercices->contains($exercice)) {
            $lesson->Exercices->remove($exercice);
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
    
    function getLessonByAbsence($absence) {
        $lessons = Doctrine_Core::getTable("Cours")->findAll();
        foreach ($lessons as $lesson) {
            if ($lesson->Absences->contains($absence)) {
                return $lesson;
            }
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD MATIERES */
    //---------------------------------------------------
    function createSubject($libelle) {
        $subject = new Matiere();
        $subject->libelle = $libelle;
        
        $subject->save();
    }
    
    function updateSubject($id, $libelle) {
        if (Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id)) {
            $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
            $subject->libelle = $libelle;
            
            $subject->save();
        }
    }
    
    function deleteSubject($id) {
        if (Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id)) {
            $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
            $subject->delete();
        }
    }
    
    function addTeacherToSubject(Matiere $subject, Enseignant $teacher) {
        $this->addSubjectToTeacher($teacher, $subject);
    }
    
    function removeTeacherToSubject(Matiere $subject, Enseignant $teacher) {
        $this->removeSubjectToTeacher($teacher, $subject);
    }
    
    function addLessonToSubject(Matiere $subject, Cours $lesson) {
        if (!$subject->Cours->contains($lesson)) {
            $subject->Cours->add($lesson);
            $subject->Cours->save();
            $subject->save();
        }
    }
    
    function removeLessonToSubject(Matiere $subject, Cours $lesson) {
        if (!$subject->Cours->contains($lesson)) {
            $subject->Cours->remove($lesson);
            $subject->Cours->save();
            $subject->save();
        }
    }
    
    function getSubjects() {
        $subjects = Doctrine_Core::getTable("Matiere")->findAll();
        if ($subjects != null) {
            return $subjects;
        }
        return null;
    }
    
    function getSubjectById($id) {
        $subject = Doctrine_Core::getTable("Matiere")->findOneBy("id_matiere", $id);
        if ($subject != null) {
            return $subject;
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
    
    
    //---------------------------------------------------
    /* CRUD AIDE */
    //---------------------------------------------------
    function createHelp($page, $libelle) {
        $help = new Aide();
        $help->libelle = $libelle;
        $help->page = $page;
        
        $help->save();
    }
    
    function updateHelp($id, $page, $libelle) {
        if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
            $help = Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
            $help->libelle = $libelle;
            $help->page = $page;
            
            $help->save();
        }
    }
    
    function deleteHelp($id) {
        if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
            $help = Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
            
            $help->delete();
        }
    }
    
    function getHelps() {
        $helps = Doctrine_Core::getTable("Aide")->findAll();
        if ($helps != null) {
            return $helps;
        }
        return null;
    }
    
    function getHelpById($id) {
        if (Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id)) {
            return Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
        }
        return null;
    }
    
    function getHelpsByPage($page) {
        if (Doctrine_Core::getTable("Aide")->findBy("page", $page)) {
            return Doctrine_Core::getTable("Aide")->findOneBy("id_aide", $id);
        }
        return null;
    }
    
    
    //---------------------------------------------------
    /* CRUD PROMOTION */
    //---------------------------------------------------
    function createPromotion($libelle) {
        $promotion = new Promotion();
        $promotion->libelle = $libelle;
        
        $promotion->save();
    }
    
    function updatePromotion($id, $libelle) {
        $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
        if ($promotion != null) {
            $promotion->libelle = $libelle;
            $promotion->save();
        }
    }
    
    function deletePromotion($id) {
        $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
        if ($promotion != null) {
            $promotion->delete();
        }
    }
    
    function addStudentToPromotion(Promotion $promotion, Etudiant $student) {
        $this->addPromotionToStudent($student, $promotion);
    }
    
    function removeStudentFromPromotion(Promotion $promotion, Etudiant $student) {
        $this->removePromotionToStudent($student, $promotion);
    }
    
    function addLessonToPromotion(Promotion $promotion, Cours $lesson) {
        if (!$promotion->Cours->contains($lesson)) {
            $promotion->Cours->add($lesson);
            $promotion->Cours->save();
            $promotion->save();
        }
    }
    
    function removeLessonFromPromotion(Promotion $promotion, Cours $lesson) {
        if (!$promotion->Cours->contains($lesson)) {
            $promotion->Cours->remove($lesson);
            $promotion->Cours->save();
            $promotion->save();
        }
    }
    
    function getPromotions() {
        $promotions = Doctrine_Core::getTable("Promotion")->findAll();
        if ($promotions != null) {
            return $promotions;
        }
        return null;
    }
    
    function getPromotionById($id) {
        $promotion = Doctrine_Core::getTable("Promotion")->findOneBy("id_promo", $id);
        if ($promotion != null) {
            return $promotion;
        }
        return null;
    }
    
    function getPromotionsByStudent($student) {
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
    
    function getPromotionsByLesson($lesson) {
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
    
    
    //---------------------------------------------------
    /* CRUD EXERCICE */
    //---------------------------------------------------
    function createExercice($libelle, Cours $lesson) {
        $exercice = new Exercice();
        $exercice->libelle = $libelle;
        $exercice->id_cours = $lesson->id_cours;
        $exercice->Cours = $lesson;
        $exercice->save();
        
        $this->addExerciceToLesson($lesson, $exercice);
    }
    
    function updateExercice($id, $libelle, Cours $lesson) {
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
    
    function deleteExercice($id) {
        $exercice = Doctrine_Core::getTable("Exercice")->findOneBy("id_exercice", $id);
        if ($exercice != null) {
            $exercice->delete();
        }
    }
    
    function getExercices() {
        $exercices = Doctrine_Core::getTable("Exercice")->findAll();
        if ($exercices != null) {
            return $exercices;
        }
        return null;
    }
    
    function getExerciceById($id) {
        $exercice = Doctrine_Core::getTable("Exercice")->findOneBy("id_exercice", $id);
        if ($exercice != null) {
            return $exercice;
        }
        return null;
    }
    
    function getExercicesByLesson($id_lesson) {
        $exercices = Doctrine_Core::getTable("Exercice")->findBy("id_cours", $id_lesson);
        if ($exercices != null) {
            return $exercices;
        }
        return null;
    }
}

?>
