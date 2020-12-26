<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Css/dashboard.css">
    <title> VOIA </title>
</head>

<body>
    <div id='dashboard'>
        <div id="left-side">
            <li><i class="fas fa-handshake"></i><span> Parainages</span> </li>
        </div>
        <div id="right-side">
            <!-- parainages -->
            <div id="parainages">
                <!-- <h1>Parainages</h1> -->
                <div id="parain-tree">
                    <!-- 1- Etat du parainage -->

                    <?php

use App\Libraries\Helper;

function remainDays($sub_date, $duration)
                    {
                        $secondes_total =  $duration - (time() - $sub_date);
                        $days = 0;

                        if ($secondes_total > 0) {
                            $days = floor($secondes_total / (60 * 60 * 24));
                            // $hours = floor($secondes_total % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                            // $minutes = floor($secondes_total % (1000 * 60 * 60) / (1000 * 60));
                            // $seconds = floor($secondes_total % (1000 * 60) / 1000);
                        } else {
                            return 0;
                        }

                        return $days;
                    }

                    function pourcentage($pack, $nbre_fileuls = 0)
                    {
                        $nbre_fileuls_total = 1;

                        switch ($pack) {
                            case 5000:
                                $nbre_fileuls_total = 10;
                                break;
                            case 10000:
                                $nbre_fileuls_total = 5;
                                break;

                            default:
                                break;
                        }

                        return ($nbre_fileuls * 100) / $nbre_fileuls_total;
                    }

                    if (isset($subscribedPackage)) {
                        // var_dump($subscribedPackage);

                    ?>
                        <div id="product">
                            <div class="product-header">
                                <span style="display: flex; flex-direction:column; justify-content :space-between; width : 80% ">
                                    <span>Etat du parainage</span>
                                    <span style="font-size: 12px; color : orange">Ce package expire dans <span id="package-expiration-delay" class="badge badge-primary"> <?php echo remainDays($subscribedPackage['subscriptionDate'], $subscribedPackage['package']['timeOut']); ?> jours</span></span>
                                </span>
                                <i class="fa fa-minus"></i>
                            </div>

                            <div id="product-content">
                                <div id="package-info">
                                    <div>Package : <span> <?php echo $subscribedPackage['package']["designation"]; ?> </span></div>
                                    <div>Souscription : <span> <?php echo $subscribedPackage['package']["price"]; ?> fr CFA</span></div>
                                    <div> Description du package :
                                        <div style="margin-left: 5%; font-size: 12px; "> <?php echo $subscribedPackage['package']["description"]; ?> </div>
                                    </div>
                                    <div>Quota de parainage : <span> <?php echo (pourcentage($subscribedPackage['package']["price"], count($sponsors))) ?> %</span> </div>
                                    <div class="progress" style="height: 20px; border-radius : 5px">
                                        <div class="progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?php echo (pourcentage($subscribedPackage['package']["price"], count($sponsors))) ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div>
                                        Code de pairainge <br>
                                        <code style="background-color : white; padding: 8px; border-radius : 5px; margin : 10px; color:red;">
                                            <?php echo Helper::getBaseUrl() . "/inscription/" . $currentUser["matricule"] . "/" . $subscribedPackage["package"]['slug']; ?>
                                        </code>
                                    </div>
                                </div>
                                <div id="bonus">
                                    <div>Prix à gagner</div>
                                    <div style="min-height : 100px; min-width : 90%; border : 1px solid white; display:flex;flex-direction:row;align-items:center;justify-content:center;">
                                        <img src="<?php echo $subscribedPackage['package']["product"]["logoPath"]; ?>" alt="image-prix">
                                    </div>
                                    <div> Caracteristiques du telephone</div>
                                    <div style="max-height : 100px; overflow-y : auto;" >
                                        <div  style='text-align:justify;'> <?php echo $subscribedPackage['package']["product"]["description"]; ?> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- 2- Containers : Liste des fileuls -->
                    <div id="fileuls">
                        <?php
                        if (isset($sponsors) && !empty($sponsors)) {
                        ?>
                            <div class="parain-tree-header"> <span>Filleuls <span style="font-size: 14px" class="badge badge-secondary"> <?php echo count($sponsors); ?> </span></span> <i class="fa fa-minus"></i></div>
                            <div id="parain-tree-list">
                                <!-- 2.1- Liste des fileuls -->
                                <?php
                                foreach ($sponsors as $key) {
                                ?>
                                    <div class="fileul">
                                        <div class="fileul-pic">
                                            <!-- <img src="/Images/pic-test/pic.jpg" alt="pic"> -->
                                        </div>
                                        <div class="fileul-data">
                                            <div><?php echo $key["first_name"] . ' ' . $key['last_name']; ?></div>
                                            <div><?php echo $key['type']; ?></div>
                                            <div><?php echo $key['email']; ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php }else{ ?>
                                <h4>
                                    Pas de filleuls !
                                </h4>
                            <?php } ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</body>

<script>
    function show_parainages(params = 'on') {
        if (params == "on") {
            $("#parainages").css({
                "display": "flex"
            })
        } else if (params == "off") {
            $("#parainages").css({
                "display": "none"
            })
        }
    }

    $("#left-side li:nth(1)").on("click", function(e) {
        show_parainages('off')
    })

    $("#left-side li:nth(0)").on("click", function(e) {
        show_parainages()
    })

    $(".parain-tree-header i").on("click", function() {
        $(".parain-tree-header i").toggleClass("fa fa-plus")
        $(".parain-tree-header i").toggleClass("fa fa-minus")
        $("#parain-tree-list").slideToggle(1000)
        $("#parain-tree-list").css({
            "display": "flex"
        })
    })

    $(".product-header i").on("click", function() {
        $(".product-header i").toggleClass("fa fa-plus")
        $(".product-header i").toggleClass("fa fa-minus")
        $("#product-content").slideToggle(1000)
        $("#product-content").css({
            "display": "flex"
        })
    })
</script>

</html>