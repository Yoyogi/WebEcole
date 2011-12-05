<?php

require_once $classes_repo.$studentclass_file;

interface ICrud {
    function createStudent();
    function getStudents();
}

?>
