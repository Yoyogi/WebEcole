<?php
    require_once $add_lesson_class;
    $add_lesson_class = AddLesson::getInstance();
    $teachers = $add_lesson_class->getTeachers();

?>

<table class="sub_body">
    <tr>
        <td class="menu">
        </td>
        <td class="content_td">
             <form method="POST" action="adm-addLesson.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <select name="teacher" id="teacher">
                <?php

                    
                    foreach ($teachers as $key => $row)
                    {
                        
                        echo "<option value=\" " . $row . " \">";
                        
                        foreach($row as $cell)
                        {
                            echo " " . $cell . " "; 
                            
                        }
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                
                <input type="submit" name="assign" value="Assign" />
            </form>
        </td>
    </tr>
</table>
    
