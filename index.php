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
    <title>60 ans - Belle-Île-en-Mer</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <style>
      @font-face{font-family:PlayfairDisplay-Regular;font-style:normal;src:local("PlayfairDisplay Regular"),local("PlayfairDisplay-Regular"),url('assets/fonts/playfair-display/PlayfairDisplay-Regular.otf') format("opentype");font-display:swap}@font-face{font-family:Roboto-Regular;font-style:normal;src:local("Roboto Regular"),local("Roboto-Regular"),url('assets/fonts/roboto/Roboto-Regular.ttf') format("TrueType");font-display:swap}.fa{font-family:var(--fa-style-family, "Font Awesome 6 Free");font-weight:var(--fa-style,900)}.fa{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:var(--fa-display,inline-block);font-style:normal;font-variant:normal;line-height:1;text-rendering:auto}.fa-info::before{content:"\f129"}.fa-bed::before{content:"\f236"}.fa-cutlery::before{content:"\f2e7"}.fa-ship::before{content:"\f21a"}.fa-quote-left::before{content:"\f10d"}.fa-xmark::before{content:"\f00d"}.fa-plus::before{content:"\2b"}:host,:root{--fa-style-family-classic:"Font Awesome 6 Free";--fa-font-solid:normal 900 1em/1 "Font Awesome 6 Free"}body{background-image:url('assets/img/bg-belle-ile.webp');background-repeat:no-repeat;background-position:center;background-size:cover;font-family:PlayfairDisplay-Regular,serif;background-color:#16a085}img{width:100%;display:block}h1,h2,h3{margin:0}h1{font-size:clamp(1.5rem,-1.7338rem + 8.6379vw,3.125rem)}h2{font-size:2rem;color:#c0392b}h3{font-size:1.5rem}ol{counter-reset:item}ol li{display:block}ol li:before{content:counter(item) ". ";font-weight:700;counter-increment:item;color:#c0392b}.info-pic{height:100%;max-width:650px;-o-object-fit:cover;object-fit:cover}p{line-height:25px;margin-bottom:10px}a{outline:0;color:#16a085}hr{height:1px;background-color:rgba(0,0,0,0);border:none;border-top:1px solid #bdc3c7}.red{color:#c0392b}header{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;-ms-flex-align:center;align-items:center;row-gap:2rem;min-width:270px}.birth-title{display:-ms-flexbox;display:flex;-ms-flex-pack:center;justify-content:center}@media (max-width:599px){.birth-title{-ms-flex-direction:column;flex-direction:column;-ms-flex-align:center;align-items:center}}.birthday{color:#ecf0f1;text-shadow:1px 1px 1px #16a085;padding:0 2rem;border-radius:10px}main{height:100vh}#display-countdown{top:var(--offset-content);position:absolute;left:50%;transform:translateX(-50%);min-width:165px;width:50%;margin:0 auto 1rem;padding:2rem;text-align:center;font-size:clamp(2rem,1.3793rem + 2.7586vw,5rem);color:#fff;background-color:#16a085;border-radius:10px;text-shadow:1px 1px 1px #2980b9}.container{position:relative;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;-ms-flex-align:center;align-items:center;margin:0 auto;padding:0;width:80%}@media (min-width:600px){.container{padding:3%}}nav{display:-ms-flexbox;display:flex;-ms-flex-pack:distribute;justify-content:space-around;width:80%}nav .nav-item{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;-ms-flex-align:center;align-items:center}nav .nav-item .icon{position:relative;display:-ms-flexbox;display:flex;-ms-flex-pack:center;justify-content:center;-ms-flex-align:center;align-items:center;width:70px;height:70px;border-radius:50%;background-color:#fff;color:#16a085;font-size:clamp(1.5rem,1.4059rem + .396vw,2rem)}@media (max-width:599px){.container{width:98%;margin:5% auto}nav{width:100%}nav .nav-item .icon{width:50px;height:50px;border-radius:50%}}nav .nav-item_text{font-family:Roboto-Regular,sans-serif;font-size:clamp(1rem,.6674rem + .8884vw,2rem);color:#fff}.content{position:absolute;width:90%;min-width:270px;min-height:500px;border-radius:5px;padding:5%;margin-bottom:20px;background-color:#fff}.content figure{margin:0 1rem 10px 0;float:left}.content figure img{border-radius:5px}@media (max-width:899px){.content figure{margin:0;float:none}}.content-header{display:-ms-flexbox;display:flex;-ms-flex-pack:justify;justify-content:space-between}.content-header:nth-child(1){margin-bottom:1rem}.content-header .fa-xmark{font-size:2rem;height:30px;color:#1abc9c;transform-origin:center}blockquote{display:flow-root;font-size:clamp(1.1rem,1.0718rem + .1188vw,1.25rem);background-color:#ecf0f1;min-width:190px;border-left:10px solid #bdc3c7;margin:0 10px;padding:.5rem;border-top-right-radius:5px;border-bottom-right-radius:5px}.hide{visibility:hidden;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;clip:rect(0,0,0,0);border:0}.fa-quote-left{font-size:2rem;color:#16a085;margin-right:10px}table{table-layout:fixed;width:33%}@media (max-width:599px){.content-header .fa-xmark{font-size:1.5rem}blockquote{border-left:6px solid #bdc3c7;margin:1.2em 0}table{width:100%}}table thead th{background-color:#16a085;color:#fff;padding:5px}
    </style>
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
    <link rel="stylesheet" href="assets/css/style.min.css" as="style" onload="this.onload=null; this.rel='stylesheet';">
    <noscript><link rel="stylesheet" href="assets/css/style.min.css"></noscript>
  </head>
  <body>
    <header>
      <div class="birth-title">
        <h1 class="birthday">Belle-Île-en-Mer</h1>
        <h1 class="birthday">60 ans &#x1F382; Denis</h1>
      </div>
      <nav>
        <div data-icon="invite" class="nav-item">
          <i data-icon="invite" class="icon fa fa-info" aria-hidden="false"></i>
          <div data-icon="invite" class="nav-item_text">Invite</div>
        </div>
        <div data-icon="bed" class="nav-item">
          <i data-icon="bed" class="icon fa fa-bed" aria-hidden="false"></i>
          <div data-icon="bed" class="nav-item_text">Se&nbsp;loger</div>
        </div>
        <div data-icon="cutlery" class="nav-item">
          <i data-icon="cutlery" class="icon fa fa-cutlery" aria-hidden="false"></i>
          <div data-icon="cutlery" class="nav-item_text">À&nbsp;table</div>
        </div>
        <div data-icon="ship" class="nav-item">
          <i data-icon="ship" class="icon fa fa-ship" aria-hidden="false"></i>
          <div data-icon="ship" class="nav-item_text">Accès</div>
        </div>
        <div data-icon="plus" class="nav-item">
          <i data-icon="plus" class="icon fa fa-plus" aria-hidden="false"></i>
          <div data-icon="plus" class="nav-item_text">Y penser</div>
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
        <div class="content invite hide">
          <div class="content-header">
            <h2>Invitation</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>
          <figure>
            <img
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
            <a href="mailto:alvardsandz@gmail.com">alvardsandz@gmail.com</a>,
            par téléphone ou via le formulaire ci-dessous avant le 20 septembre.
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
            Je rajouterai, au fur et à mesure, d’autres informations sur ce site, mais n’hésitez pas à
            me contacter si vous avez des questions.
          </p>

          <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST" accept-charset="UTF-8">
            <fieldset>
              <input type="text" name="lastname" id="name" value="" autocomplete="on" placeholder="Prénoms" required minlength="4" maxlength="25" pattern="^[A-zÀ-ÿ ]*$">
              <div class="alldays">
                <div class="day">
                  <label for="friday">Vendredi</label>
                  <input type="checkbox" name="day[]" id="friday" value="Vendredi">
                </div>
                <div class="day">
                  <label for="saturday">Samedi</label>
                  <input type="checkbox" name="day[]" id="saturday" value="Samedi">
                </div>
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
          <p><em class="red">Pensez à prendre des draps, sinon vous pourrez en louer sur place !</em></p>
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
                <td>0</td>
                <td>0</td>
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
          <p><strong>En train : </strong></p>
          <ol>
            <li>jusqu'à Auray</li>
            <li>Auray - Quiberon : bus n°1</li>
          </ol>
          <hr>
          <p><strong>En voiture</strong> jusqu'à Quiberon : </p>
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
        <div class="content plus hide">
          <div class="content-header">
            <h2>Y penser</h2>
            <i class="fa fa-xmark" aria-hidden="false"></i>
          </div>
          <p>C'est la Bretagne ! Il y a un microclimat sur l'île, il peut faire beau un 5 novembre.</p>
          <p>Alors n'oubliez pas vos chaussures de marche afin de fouler les sentiers côtiers.</p>
          <p>Les filles, si vous avez des talons pour le soir, on pourrait se faire un tango&nbsp;^^.</p>
        </div>
      </div>
    </main>
    <script src="assets/js/custom.min.js" defer></script>
  </body>
</html>
