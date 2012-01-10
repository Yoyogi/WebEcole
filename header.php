<?php
    session_start();
?>

<div id="header">
    <p id="header_title">Web Ecole</p>
    <?php
    if (isset($_SESSION["type"])) {
        ?>
        <div id="header_login">
            <span>Connecté : 
                <?php
                    echo $_SESSION["prenom"]." ";
                    if (isset($_SESSION["nom"])) {
                        echo $_SESSION["nom"];
                    }
                ?>
            </span>
            <input type="button" value="deconnexion" onclick='window.location.href="deconnexion.htm";'/>
        </div>
        <?php
    }
    ?>
</div>