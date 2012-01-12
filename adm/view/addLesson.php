<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "admin") {
            if ($_SESSION["type"] == "teacher") {
                header('Location: tea-indexTeacher.htm');
            }
            else if ($_SESSION["type"] == "student") {
                header('Location: pup-indexPupil.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    require_once $add_lesson_class;
    require_once $matiereclass_file;
    require_once $promotionclass_file;
    require_once $enseignantclass_file;
    $add_lesson = AddLesson::getInstance();
    $teachers = $add_lesson->getTeachers();
    $promotions = $add_lesson->getPromotions();
    $matieres = $add_lesson->getMatieres();
    
    
    
    if ($isValided != null) {
        if (($date_cours != null) && ($duree != null) && ($descript != null)) {
            $matiereObj = new Matiere();
            $matiereObj = $add_lesson->getSubjectByIdFunc($matiere);
            $teacherObj = new Enseignant();
            $teacherObj = $add_lesson->getTeacherByIdFunc($teacher);
            $promoObj = new Promotion();
            $promoObj = $add_lesson->getPromotionByIdFunc($promotion);
            $date = $add_lesson->convertStringToDate($date_cours);
            $add_lesson->addLessonFunc($date, $duree, $descript, $teacherObj, $promoObj, $matiereObj);
            header('Location: adm-manageLesson.htm');
        } else {

            echo $isValided;
            echo "Veillez a remplir tous les champs correctement";
        }
    }

?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <p class="subtitle">Ajout d'un cours</p>
            <form method="POST" action="adm-addLesson.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <!-- combobox teacher -->
                Professeur : <select name="teacher" id="teacher">
                <?php

                    
                    foreach ($teachers as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_enseignant"] . " \">";
                        
                            echo " " . $row["nom"] . " "; 
                            echo " " . $row["prenom"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                
                <!-- combobox promotion -->
                Classe : <select name="promotion" id="promotion">
                <?php

                    
                    foreach ($promotions as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_promo"] . " \">";
                        
                            echo " " . $row["libelle"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                
                <!-- combobox matiere -->
                Matière : <select name="matiere" id="matiere">
                <?php

                    
                    foreach ($matieres as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_matiere"] . " \">";
                        
                            echo " " . $row["libelle"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                
                <p><label> Date : </label> <input type=text name=date_cours> </p>
                <p><label> Durée : </label> <input type=text name=duree> </p>
                <p><label> Description : </label> <input type=text name=descript> </p>
                
                <input type="submit" name="addLesson" value="Créer le cours" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='adm-manageLesson.htm';" />
            </form>
        </td>
    </tr>
</table>
    
