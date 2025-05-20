<!--LUCAS SUPERINA 105914669-->

<?php
    define("NAME", 0);
    define("LINK", 1);

    define("INACTIVE_LINK_CLASS", '"nav-link"');
    define("ACTIVE_LINK_CLASS", '"nav-link active"');

    $Name_Link_Pairs = [
        ["Home", "index.php"],
        ["About", "about.php"],
        ["Jobs", "jobs.php"],
        ["Apply", "apply.php"],
    ];
    function createHeader($_current_page_name) { 
        global $Name_Link_Pairs;
        ?>
        <header>
                <div class="logo">
                    <img src="./styles/images/company_logo.png" alt="Terrible Software Limited Inc. logo">
                    <a href="index.php">Terrible Software Inc.</a>
                
                    <nav class="navbar">
                        <ul class="nav-links">
                            <?php 
                            for ($i = 0; $i < sizeof($Name_Link_Pairs); $i++) {
                                $Current_Pair = $Name_Link_Pairs[$i];
                                $Current_Name = $Current_Pair[NAME];
                                $Current_Link = $Current_Pair[LINK];

                                $Current_Link_Class = INACTIVE_LINK_CLASS;
                                if ($Current_Name == $_current_page_name) {
                                    $Current_Link_Class = ACTIVE_LINK_CLASS;
                                }
                                
                                echo "<li class=$Current_Link_Class><a href=$Current_Link>$Current_Name</a></li>";
                            }   
                            ?>
                        </ul>
                    </nav>
                </div>
            </header>
   <?php }; ?>
