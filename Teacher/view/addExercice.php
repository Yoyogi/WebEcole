<?php

    require_once $add_exercice_class;
    require_once $coursclass_file;
    $add_exercice = AddExercice::getInstance();
    $lessons = $add_exercice->getLessons();
    
    
    echo "allalalal  : " + $lesson;
    
    if ($isValided != null) {
        if ($libelle != null) {
            $LessonObj = new Cours();
            $LessonObj = $add_exercice->getLessonByIdFunc($lesson);
            $add_exercice->addExerciceFunc($libelle, $LessonObj);
            echo "Exercice ajouté";
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
             <form method="POST" action="tea-addExercice.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <!-- combobox promotion -->
                Cours : <select name="lesson" id="lesson">
                <?php

                    
                    foreach ($lessons as $key => $row)
                    {
                        
                        echo "<option value=\"" . $row["id_cours"] . "\">";
                        
                            echo " " . $row["descript"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                                
                <p><label> Libelle : </label> <input type=text name=libelle> </p>
                
                <input type="submit" name="addExercice" value="Créer le cours" />
            </form>
        </td>
    </tr>
</table>