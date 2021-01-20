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


                    if (isset($subscribedPackage)) {
                        $niveau1_lenght = isset($sponsors["niveau-1"]) ? count($sponsors["niveau-1"]) : 0;
                        $niveau2_lenght = isset($sponsors["niveau-2"]) ? count($sponsors["niveau-2"]) : 0;

                        $pack_user = $subscribedPackage['package']["price"];
                        $type_user = $_SESSION["currentUser"]["type"];
                        $percent = Helper::pourcentage3($pack_user, $type_user, $niveau1_lenght, $niveau2_lenght)[0];
                        $percent2 = Helper::pourcentage3($pack_user, $type_user, $niveau1_lenght, $niveau2_lenght)[1] ? Helper::pourcentage3($pack_user, $type_user, $niveau1_lenght, $niveau2_lenght)[1] : 0;
                    ?>
                        <div id="product">
                            <div class="product-header">
                                <span style="display: flex; flex-direction:column; justify-content :space-between; width : 80% ">
                                    <span>Etat du parainage</span>
                                    <span style="font-size: 12px; color : orange">Ce package expire dans <span id="package-expiration-delay" class="badge badge-primary"> <?php echo Helper::remainDays($subscribedPackage['subscriptionDate'], $subscribedPackage['package']['timeOut']); ?> jours</span></span>
                                </span>
                                <i class="fa fa-minus"></i>
                            </div>

                            <div id="product-content">
                                <div id="package-info">
                                    <div>Package : <span> <?php echo $_SESSION["currentUser"]["type"] == 'communicateur' ? "Package 1, Package 2" : $subscribedPackage['package']["designation"]; ?> </span></div>
                                    <?php echo $_SESSION["currentUser"]["type"] == 'communicateur' ? '' : "<div>Souscription : <span>" . $subscribedPackage['package']["price"] . " fr CFA</span></div>" ?>

                                    <div> Description du package :
                                        <div style="margin-left: 5%; font-size: 12px; "> <?php echo $subscribedPackage['package']["description"]; ?> </div>
                                    </div>
                                    <!-- Package 1  -->

                                    <div style="padding: 10px;font-size:15px;text-align:center"> Package 1 </div>

                                    <div>Quota de parainage : <span> <?php echo $percent; ?> %</span> </div>
                                    <div class="progress" style="height: 20px; border-radius : 5px">
                                        <div class="progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?php echo $percent; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>


                                    <div>
                                        Code de pairainge <br><br>
                                        <div>Package 1
                                            <code style="background-color : white; border-radius : 5px; margin : 10px; color:red;">
                                                <?php echo Helper::getBaseUrl() . "/inscription/" . $currentUser["matricule"] . "/niveau-1" ?>
                                            </code>
                                        </div>
                                    </div>

                                    <!-- Package 2  -->

                                    <div style="padding: 10px;font-size:15px;text-align:center"> Package 2 </div>

                                    <?php if ($_SESSION["currentUser"]["type"] == "communicateur") { ?>
                                        <div>Quota de parainage : <span> <?php echo $percent2; ?> %</span> </div>
                                        <div class="progress" style="height: 20px; border-radius : 5px">
                                            <div class="progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: <?php echo $percent2; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    <?php } ?>

                                    <div> Code de pairainge <br><br>
                                        <div>Package 2
                                            <code style="background-color : white; border-radius : 5px; margin : 10px; color:red;">
                                                <?php echo Helper::getBaseUrl() . "/inscription/" . $currentUser["matricule"] . "/niveau-2" ?>
                                            </code>
                                        </div>
                                    </div>

                                </div>
                                <div id="bonus">
                                    <div>Prix à gagner</div>
                                    <div style="min-height : 100px; min-width : 90%; border : 1px solid white; display:flex;flex-direction:row;align-items:center;justify-content:center;">
                                        <img src="/Data/Products/images/techo-pop-4.jpg" alt="image-prix">
                                    </div>
                                    <div> Caracteristiques du telephone</div>
                                    <div style="max-height : 200px; overflow-y : auto;">
                                        <div style='text-align:justify;'>Système d'exploitation (OS) : Androïde 10.0 ; mesure de l'écran : 6 pouces ; Processeur : Mediatek MT6580 ; RAM 2GB ; Espace intérieur : 32GB ; appareil photo : 5 MP ; Réseau : 3G UMTS HSDPA 850/1900, 4G FDD LTE, Ne prend pas en charge le réseau 4G LTE ; SIM : Deux tranches (nano-sim, double veille) ; Technologie de l'écran : IPS LCD capacitive touchscreen 16, 16 millions de couleurs ; Batterie : 5000 MAH, Li-polymère, non amovible ; Caméra fond : 5 MP, Les fonctions de la caméra : Mise au point de géolocalisation, flash LED, Tournage vidéo : 720 pixel 30 ips, Caméra frontale : 8 MP.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- 2- Containers : Liste des fileuls -->
                    <div id="fileuls">
                        <?php

                        function ranger($array)
                        {
                            $_array = [];

                            $_niveau_tmp = [];

                            foreach ($array as $key => $value) {
                                foreach ($array[$key] as $key1 => $value1) {
                                    $_niveau_tmp[$key1] = $value1['admissionDate'];
                                }
                                asort($_niveau_tmp);
                                foreach ($_niveau_tmp as $key2 => $value) {
                                    $_niveau_tmp[$key2]  = $array[$key][$key2];
                                }

                                $_array[$key] = $_niveau_tmp;
                            }

                            return $_array;
                        }


                        if (isset($sponsors) && !empty($sponsors)) {

                            $sponsors = ranger($sponsors);

                            $niveau1 = isset($sponsors["niveau-1"]) ? $sponsors["niveau-1"] : [];
                            $niveau2 = isset($sponsors["niveau-2"]) ? $sponsors["niveau-2"] : [];
                        ?>
                            <div class="parain-tree-header"> <span>Filleuls </span> <i class="fa fa-minus"></i></div>
                            <div id="parain-tree-list">
                                <!-- 2.1- Liste des fileuls -->
                                <div class="fileul-wrap">
                                    <h3>Package 1 <span style="font-size: 14px" class="badge badge-secondary"> <?php echo $niveau1_lenght; ?> </span> </h3>
                                    <?php
                                    foreach ($niveau1 as $key) {
                                    ?>
                                        <div class="fileul">
                                            <div class="fileul-data">
                                                <div><?php echo $key["first_name"] . ' ' . $key['last_name']; ?></div>
                                                <div><?php echo $key['type']; ?></div>
                                                <div><?php echo $key['email']; ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="fileul-wrap">
                                    <h3>Package 2 <span style="font-size: 14px" class="badge badge-secondary"> <?php echo $niveau2_lenght; ?> </span> </h3>
                                    <?php
                                    foreach ($niveau2 as $key) {
                                        //var_dump($key);
                                    ?>
                                        <div class="fileul">
                                            <div class="fileul-data">
                                                <div><?php echo $key["first_name"] . ' ' . $key['last_name']; ?></div>
                                                <div><?php echo $key['type']; ?></div>
                                                <div><?php echo $key['email']; ?></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
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

<script src="/JS/dashboard.js"></script>

</html>