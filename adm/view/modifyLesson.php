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
    require_once $modify_lesson_class;
    require_once $matiereclass_file;
    require_once $promotionclass_file;
    require_once $enseignantclass_file;
    
    try {
        $modify_lesson = ModifyLesson::getInstance();
        $teachers = $modify_lesson->getTeachers();
        $promotions = $modify_lesson->getPromotions();
        $matieres = $modify_lesson->getMatieres();
    }
    catch (Exception $e) {
        echo $e;
    }
    
    if ($isValided != null) {
        if (($date_cours != null) && ($duree != null) && ($descript != null)) {
            try {
                $date = $modify_lesson->convertStringToDate($date_cours);
                $modify_lesson->updateLesson($v_id, $date, $duree, $descript, $teacher, $promotion, $matiere);
                header('Location: adm-manageLesson.htm');
            }
            catch (Exception $e) {
                echo $e;
            }
        } else {

            echo $isValided;
            echo "Veillez a remplir tous les champs correctement";
        }
    }
    
    $lesson = $modify_lesson->getLessonByID($v_id);

?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <p class="subtitle">Modifier un cours</p>
            <form method="POST" action="adm-modifyLesson-<?php echo $v_id; ?>.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <!-- combobox teacher -->
                Professeur : <select name="teacher" id="teacher" selected="<?php echo $lesson->id_enseignant; ?>">
                <?php

                    
                    foreach ($teachers as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_enseignant"] . "\"";
                        if ($row["id_enseignant"] == $lesson->id_enseignant) {
                            echo " selected='selected' ";
                        }
                        echo "\>";
                        
                        echo " " . $row["nom"] . " "; 
                        echo " " . $row["prenom"] . " ";
                        
                        echo "</option>";
                    } 
                ?>
                </select>
                
                <!-- combobox promotion -->
                Classe : <select name="promotion" id="promotion" selected="<?php echo $lesson->id_promo; ?>">
                <?php

                    
                    foreach ($promotions as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_promo"] . "\"";
                        if ($row["id_promo"] == $lesson->id_promo) {
                            echo " selected='selected' ";
                        }
                        echo "\>";
                        
                        echo " " . $row["libelle"] . " ";

                        echo "</option>";
                    } 
                ?>
                </select>
                
                <!-- combobox matiere -->
                Matière : <select name="matiere" id="matiere" selected="<?php echo $lesson->id_matiere; ?>">
                <?php

                    
                    foreach ($matieres as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row["id_matiere"] . "\"";
                        if ($row["id_matiere"] == $lesson->id_matiere) {
                            echo " selected='selected' ";
                        }
                        echo "\>";
                        
                        echo " " . $row["libelle"] . " ";
                        
                        echo "</option>";
                    } 
                ?>
                </select>
                
                <p><label> Date : </label> <input type=text name=date_cours value="<?php echo date("d/m/Y", strtotime($lesson->date_cours)); ?>"> </p>
                <p><label> Durée : </label> <input type=text name=duree value="<?php echo $lesson->duree; ?>"> </p>
                <p><label> Description : </label> <input type=text name=descript value="<?php echo $lesson->descript; ?>"> </p>
                
                <input type="submit" name="modifyLesson" value="Modifier le cours" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='adm-manageLesson.htm';" />
            </form>
        </td>
    </tr>
</table>
    
