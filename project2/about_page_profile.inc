<!--LUCAS SUPERINA 105914669-->

<?php 
    define("LEFT", 0);
    define("RIGHT", 1);

    define("TITLE_CLASS_SIDE", [
        '"left_profile_title"', '"right_profile_title"'
    ]);

    define("PROFILE_CLASS_SIDE", [
        '"about_left_profile"', '"about_right_profile"'
    ]);


    $profiles_created = 0;

    function left_or_right_profile() {
        global $profiles_created;

        if ($profiles_created % 2 == 0) {
            return LEFT;
        } else {
            return RIGHT;
        };
    }

    function about_profile($_title, $_image_path, $_image_alt_text, $_contributions) {
        global $profiles_created;
        $profile_side = left_or_right_profile();

        $title_side = TITLE_CLASS_SIDE[$profile_side];
        $description_side = PROFILE_CLASS_SIDE[$profile_side];
        
        echo "<dt class=$title_side>";
            echo "<p>$_title</p>";
        echo "</dt>";
        echo "<dd class=$description_side>";
            if ($profile_side == LEFT){
                about_profile_image($_image_path, $_image_alt_text);
                about_profile_contributions($_contributions);
            } else {
                about_profile_contributions($_contributions);
                about_profile_image($_image_path, $_image_alt_text);
            }
        
        echo "</dd>";



        $profiles_created += 1;
    }

    function about_profile_image($_image_path, $_image_alt_text) {
        $_image_alt_text = '"'.$_image_alt_text.'"';
        echo "<img src=$_image_path class='soup-image' alt=$_image_alt_text>";
    };

    function about_profile_contributions($_contributions) {
        echo "<ul>";
        for ($i = 0; $i < sizeof($_contributions); $i++) {
            $current_contribution = $_contributions[$i];
            echo "<li>$current_contribution</li>";
        }
        echo "</ul>";
    };
?>
