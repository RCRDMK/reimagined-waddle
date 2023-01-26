<?php

class uebersicht_profile_darstellung_logik
{

    /**
     * @param array $profileAusSuche (UID, NAME)
     */
    public function __construct($profileAusSuche)
    {
        foreach ($profileAusSuche as $key => $profil) {
            $uid = $profil["UID"];
            $name = $profil["NAME"];
            ?>
            <a class="profil-link"
               href="profil.php?id=<?php echo $uid ?>"> <?php echo $name ?></a>

            <?php
        }
    }
}

?>