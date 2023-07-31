<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once("auth.php");
//Load Composer's autoloader
require 'vendor/autoload.php';
//check token
if ( $_POST['submit'] == "J'y vais" && $_POST['token'] === $_SESSION['token']){
    $mail = new PHPMailer(true);
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $mailpassword = password_verify($password, $hashed);
    function valid_data($data){
        $pattern = "/^[a-z]\w{2,23}[^_]$/i";
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = htmlentities($data);
        $name = strip_tags($_POST['lastname']);
        $name = substr($name,0,25);
        //clean out any potential hexadecimal characters
        $name = cleanHex($name);
        $name = preg_match($pattern, $_POST['lastname']);
        return $data;
    }
    
    if(isset($_POST['lastname'])){
        $name = valid_data($_POST['lastname']);
    }

    if(isset($_POST['day']) && !empty($_POST["day"])) {
        $days = $_POST['day'];
        foreach($days as $day) {
            $choice .= $day . ' ';
        }
    }
    if(!empty($name) && $mailpassword){        
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();
            $mail->setLanguage('fr');
            $mail->CharSet    = 'UTF-8';                                   //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'alvardsandz@gmail.com';
            $mail->Password   = $password;                                //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
            $mail->Port       = 587;                                    
            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        
            //Recipients
            $mail->setFrom('alvardsandz@gmail.com', $name);
            $mail->addAddress('alvardsandz@gmail.com', 'Denis Godec');     //Add a recipient    
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Réservation Belle-ile-en-mer';
            $mail->Body    = '<b>Réservation : </b>'.$name.' '.$choice.'';
        
            $mail->send();
            header("Location: ./response.php");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }    
    }    
}
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
function cleanHex( $input){
    $clean = preg_replace("![][xX]([A-Fa-f0–9]{1,3})!", "", $input);
    return $clean;
}
// Set time left
    $birthday = 1699142340;
    $time_left = $birthday - time();

    $days = floor($time_left / (60*60*24));
    $time_left %= (60 * 60 * 24);

    $hours = floor($time_left / (60 * 60));
    $time_left %= (60 * 60);

    $min = floor($time_left / 60);
    $time_left %= 60;
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="description" content="Birthday">
    <meta name="author" content="Denis Godec">
    <meta name="theme-color" content="#ffffff">
    <link
      rel="stylesheet"
      media="all"
      href="assets/fontawesome/css/fontawesome-ile.css"
   >
    <link
      rel="stylesheet"
      media="all"
      href="assets/fontawesome/css/solid.css"
   >
    <link rel="stylesheet" media="all" href="assets/css/style.min.css">
    <title>60 ans - Belle-Île-en-Mer</title>
  </head>
  <body>
    <header>
      <div class="birth-title">
        <h1 class="birthday">Belle-Île-en-Mer</h1>
        <h1 class="birthday">60 ans &#x1F382; Denis</h1>
      </div>
      <nav>
        <div class="nav-item">
          <i data-icon="info" class="icon fa fa-info" aria-hidden="false"></i>
          <div class="nav-item_text">Invitation</div>
        </div>
        <div class="nav-item">
          <i data-icon="bed" class="icon fa fa-bed" aria-hidden="false"></i>
          <div class="nav-item_text">Se&nbsp;loger</div>
        </div>
        <div class="nav-item">
          <i data-icon="cutlery" class="icon fa fa-cutlery" aria-hidden="false"></i>
          <div class="nav-item_text">À&nbsp;table</div>
        </div>
        <div class="nav-item">
          <i data-icon="ship" class="icon fa fa-ship" aria-hidden="false"></i>
          <div class="nav-item_text">Accès</div>
        </div>
      </nav>
    </header>
    <main>
      <div id="display-countdown">
        <div class="days"><?php echo $days; ?> jours</div>
        <div class="hours"><?php echo $hours; ?> heures</div>
        <div class="minutes"><?php echo $min; ?> minutes</div>
      </div>
      <div class="container">
        <div class="content info hide">
          <div class="content-header">
            <h2>Invitation</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>
          <figure>
            <img
              loading="lazy"
              src="assets/img/denis-kerpaour.webp"
              width="650"
              height="347"
              srcset="
                assets/img/denis-kerpaour-351x209.webp 351w,
                assets/img/denis-kerpaour-750x347.webp 750w
              "
              sizes="(max-width: 650px) 100vw"
              alt="Collège Kerpaour"
              class="info-pic"
           >
          </figure>
          <blockquote>
            <strong>3 au 5 novembre 2023</strong><br>
            Belle-Île-en-Mer.
            <address>
              Le Relais-Côtier <br>
              Chemin de Port-Puce, <br>
              56320 Sauzon
            </address>
          </blockquote>
          <p>
            <i class="fa fa-quote-left" aria-hidden="true"></i> On dit que dans
            chaque vieux, il y a un jeune qui se demande ce qu’il s’est passé.
            <br>C’est lui sur la mobylette, le jeune. C’est moi ça ! Faut
            absolument que je remette la main sur ce gilet&nbsp;!
          </p>

          <p>
            Comme j’avais envie de fêter mes 50 ans, j’ai un peu de retard, mais
            maintenant, je sens bien qu’il ne faut pas tarder à s’amuser.
            <br>Alors ni une ni deux dans un cadre splendide, je vous invite à
            fêter cet événement.
          </p>
          <div style="clear: both"></div>
          <p>Certes, il y aura des huîtres, mais pas que…</p>
          <p>
            Afin d’organiser au mieux les réjouissances, vous pouvez me
            confirmer votre présence par mail
            <a href="mailto:alvardsandz@gmail.com">alvardsandz@gmail.com</a> ou
            par téléphone avant le 20 septembre.
          </p>

          <p>
            Dites-moi si vous souhaitez arriver le vendredi ou le samedi afin de
            préparer les repas en conséquence.
          </p>
          <p>
            Dans le gîte,
            <a
              href="https://le-relais-cotier.fr/"
              target="_blank"
              rel="noopener noreferrer"
              >Le Relais côtier</a
            >, il y a 32 places, vous pourrez y loger, pour les premiers
            arrivés. <br>Dans la rubrique « Se loger », vous trouverez les
            infos pour réserver d’autres
            <a
              href="https://www.belle-ile.com/organiser/les-hebergements/"
              target="_blank"
              rel="noopener noreferrer"
              >hébergements</a
            >.
          </p>
          <p>
            Je rajouterai ici, au besoin, d’autres infos, mais n’hésitez pas à
            me contacter si vous avez des questions.
          </p>

          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" accept-charset="UTF-8">
            <fieldset>
              <input type="text" name="lastname" id="name" value="" autocomplete="on" aria-placeholder="Prénoms" placeholder="Prénoms" required minlength="4" maxlength="25" pattern="^[A-zÀ-ÿ ]*$">
              <div class="day">
                <label for="friday">Vendredi</label>
                <input type="checkbox" name="day[]" id="friday" value="Vendredi">
              </div>
              <div class="day">
                <label for="saturday">Samedi</label>
                <input type="checkbox" name="day[]" id="saturday" value="Samedi">
              </div>
              <input type="hidden" name="token" value="<?php echo $token;?>"/>
              <input type="submit" name="submit" id="submit" value="J'y vais"/>
            </fieldset>
          </form>

        </div>
        <div class="content bed hide">
          <div class="content-header">
            <h2>Se&nbsp;loger</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>
          <p>Vous allez trouver votre bonheur à Belle-Île-en-Mer !</p>
          <p>Mais attention, c'est les vacances de la Toussaint et les places à Sauzon se font rares</p>
          <p>Vous pouvez essayer <a href="https://hotel-belleile-auxtamaris.fr/" target="_blank"
              rel="noopener noreferrer">l'hôtel Tamaris</a> où il reste quelques places pour le moment &#x1F60A;.</p>
          <p>
            Dans le gîte que j'ai réservé, 
            <a
              href="https://le-relais-cotier.fr/"
              target="_blank"
              rel="noopener noreferrer"
              >le Relais côtier </a
            >, il y a 11 chambres : 2 personnes ou 3 personnes.
          </p>
          <p>
          Vous trouverez les tarifs sur leur
          <a
            href="https://le-relais-cotier.fr/index.html#Tarifs"
            target="_blank"
            rel="noopener noreferrer"
            >site.</a
          ></p>
          <p>
            Il n'y aura pas de place pour tout le monde, réservez votre chambre
            en me contactant car j'ai l'exclusivité et la gestion du gîte pour
            cette période.
          </p>
          <table>
            <thead>
              <tr>
                <th colspan="2">Chambres restantes *</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>2 lits</td>
                <td>3 lits</td>
              </tr>
              <tr>
                <td>1</td>
                <td>5</td>
              </tr>
            </tbody>
          </table>
          <p>* mis à jour / réservation</p>
          <hr>
          <p>
            Sur le site de Belle-Île-en-Mer, vous trouverez tous les
            <a
              href="https://www.belle-ile.com/organiser/les-hebergements/"
              target="_blank"
              rel="noopener noreferrer"
              >hébergements :</a
            >
          </p>
          <ul>
            <li>Airbnb</li>
            <li>Chambres d'hôtes</li>
            <li>Hôtels</li>
          </ul>
        </div>
        <div class="content cutlery hide">
          <div class="content-header">
            <h2>À&nbsp;table</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>          
          <h3>Coming soon! &#x1F60B;</h3>
        </div>
        <div class="content ship hide">
          <div class="content-header">
            <h2>Accès</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>
          <p>En train ou en voiture jusqu'à Quiberon</p>
          <hr>
          <p>
            Il vous faudra prévoir d'arriver une heure avant l'embarquement afin
            de stationner dans un des parkings situés à Quiberon.
          </p>
          <p>
            Sur le site de l'office de tourisme, vous trouverez tous les
            <a
              href="https://www.belle-ile.com/organiser/venir-en-bateau-une-ile-plusieurs-ports-de-depart/au-depart-de-quiberon/ou-garer-sa-voiture-quiberon/"
              target="_blank"
              rel="noopener noreferrer"
              >parkings pour stationner à Quiberon</a
            >.
          </p>
          <p>
            Les parkings ci-dessous sont ouverts jusqu'au 6 novembre.<br>
            <a href="https://www.ville-quiberon.fr/parking-des-iles/"
              >Parking des îles</a
            >
            (navettes gratuites)
          </p>
          <p>
            <a
              href="https://parkingdekerne.com/"
              target="_blank"
              rel="noopener noreferrer"
              >Parking de Kerné</a
            >
            réservation (navettes gratuites)
          </p>
          <p>
            <a href="https://quiberon-parking.fr/index.html">Parking de Sizorn</a>
            le plus proche de la gare maritime
          </p>
          <hr>
          <p>
            <a
              href="https://www.compagnie-oceane.fr/"
              target="_blank"
              rel="noopener noreferrer"
              >La Compagnie Océane</a
            >
            assure la liaison <strong>Quiberon – Le Palais :</strong> toute
            l’année pour les passagers et les véhicules (entre 5 à 13
            allers-retours par jour suivant la saison). <br>Pensez à réserver
            vos traversées A/R !
          </p>
          <p>
            <strong>Cie Océane :</strong>
            <a href="tel:+33297313445">+33 2 97 31 34 45</a>
          </p>

          <p>
            <strong>Durée de la traversée :</strong> 45 minutes, arrivée au port de Le Palais
          </p>
          <p>
            <a
              href="https://www.belle-ile.com/organiser/venir-en-bateau-une-ile-plusieurs-ports-de-depart/"
              target="_blank"
              rel="noopener noreferrer"
              >L'office de tourisme</a
            >
            de Belle-Île-en-Mer vous informe sur d'autres ports au départ du
            continent.
          </p>
          <hr>
          <p>Le gîte <i>Le Relais-Côtier</i> est situé à Sauzon.</p>
          <p>Pour rejoindre le gîte à partir du port Le Palais :</p>
          <ul>
            <li>Gare routière (les cars bleus) - Sauzon puis 1km à pied jusqu'au gîte</li>
            <li>15 minutes en voiture</li>
            <li>Navettes (à confirmer)</li>
            <li>
              <a href="https://www.belle-ile.com/organiser/se-deplacer-belle-ile-sans-ma-voiture/taxis-vtc-a-belle-ile/">Taxis</a>
            </li>
          </ul>
          <address>
            Le Relais-Côtier <br>
            Chemin de Port-Puce <br>
            56360 Sauzon
          </address>
          <hr>
          <p>Si vous désirez visiter l'île, vous pourrez louer voitures, scooters, vélos.</p>
          <p>
            <strong>Location de voitures : </strong>
            <a href="https://www.locatourisle.com/" target="_blank" rel="noopener noreferrer">Locatourisle</a>
          </p>
        </div>
      </div>
    </main>
    <script src="assets/js/custom.js" defer></script>
  </body>
</html>
