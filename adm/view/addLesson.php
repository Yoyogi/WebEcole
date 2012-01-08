<?php
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
            $add_lesson->addLessonFunc($date_cours, $duree, $descript, $teacherObj, $promoObj, $matiereObj);
            echo "Cours ajoutee";
        } else {

            echo $isValided;
            echo "Veillez a remplir tous les champs correctement";
        }
    }

?>

<table class="sub_body">
    <tr>
        <td class="menu">
        </td>
        <td class="content_td">
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
                Matiere : <select name="matiere" id="matiere">
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
                <p><label> Duree : </label> <input type=text name=duree> </p>
                <p><label> Description : </label> <input type=text name=descript> </p>
                
                <input type="submit" name="addLesson" value="Créer le cours" />
            </form>
        </td>
    </tr>
</table>
    
