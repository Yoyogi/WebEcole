<?php
    require_once $add_absence_class;
    require_once $coursclass_file;
    require_once $etudiantclass_file;
    $add_absence = AddAbsence::getInstance();
    $pupils = $add_absence->getPupils();
    $lessons = $add_absence->getLessons();
    
    
    
    if ($isValided != null) {
        if ($motif != null) {
            $LessonObj = new Cours();
            $LessonObj = $add_absence->getLessonByIdFunc($lesson);
            $PupilObj = new Etudiant();
            $PupilObj = $add_absence->getPupilByIdFunc($pupil);
            $add_absence->addAbsenceFunc($motif, $PupilObj, $LessonObj);
            echo "Absence ajoutée";
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
             <form method="POST" action="adm-addAbsence.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <!-- combobox teacher -->
                Etudiant : <select name="pupil" id="pupil">
                <?php

                    
                    foreach ($pupils as $key => $row)
                    {
                        
                        echo "<option value=\"" . $row["id_etudiant"] . "\">";
                        
                            echo " " . $row["nom"] . " "; 
                            echo " " . $row["prenom"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                
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
                                
                <p><label> Motif : </label> <input type=text name=motif> </p>
                
                <input type="submit" name="addAbsence" value="Créer le cours" />
            </form>
        </td>
    </tr>
</table>
    
