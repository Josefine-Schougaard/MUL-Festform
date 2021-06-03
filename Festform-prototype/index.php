<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tilmeldings formular</title>
    <link href="formfest.css" rel="stylesheet">
</head>
<body>
    <div id="box">
        <h2>Frivillig tilmelding</h2>
        <form class="formgroup w100" action="index.php" method="post" novalidate >
            <div class="sub-group">
                <label>Fornavn</label>
                <input required type="text" placeholder="Fornavn" name="fornavn">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group">
                <label>Efternavn</label>
                <input required type="text" placeholder="Efternavn" name="efternavn">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group left">
                <label>Fødselsdato</label>
                <input required type="date" placeholder="Fødselsdato" name="fdag">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group right">
                <label>Adresse</label>
                <input required type="text" name="adresse" placeholder="Adresse">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group left">
                <label>By</label>
                <input required type="text" name="by" placeholder="By">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group right">
                <label>Postnummer</label>
                <input required type="number" name="postnr" placeholder="Postnummer">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group left">
                <label>Email</label>
                <input required type="email" name="email" placeholder="Email">
                <div class="validation-message"></div>
            </div>
            <div class="sub-group right">
                <label>Telefon nummer</label>
                <input required type="number" name="tlf" placeholder="Telefon nummer">
                <div class="validation-message"></div>
            </div>

            <h3>Vagtønsker</h3>
            <p>Vælg alle de vagter du ønsker at arbejde under festivalen. De ønsker du vælger betyder ikke at du får de vagter. Vi vil dog forsøge at sørge for alle får vagter ud fra ønskerne så vidt som muligt. Har du ingen vagtønsker så klik i checkboxen under skemaet.</p>
            <div class="shifts">
                <table class="shift-table">
                    <thead class="shift-clr-ocean">
                        <tr></tr>
                    </thead>
                    <tbody class="shift-clr-ocean">
                    </tbody>
                </table>
            </div>
            <div class="checks noShifts">
                <input type="checkbox" required>
                <label>Jeg har ikke nogle vagtønsker</label>
                <div class="validation-message"></div>
            </div>

            <div class="comment">
                <label>Kommentar</label>
                <textarea placeholder="Skriv evt. en kommentar her" name="kommentar"></textarea>
            </div>
            <div class="checks requiredCheck">
                <input type="checkbox" required>
                <label>Jeg giver hermed mit samtykke til at dette projekt må indsamle mit data.</label>
                <div class="collapse">Læs mere</div>
                <div class="collapse-content">De data der gives i denne formular vil ikke blive delt med andre. Denne formular er en del af et projekt til uddannelsen Multimediedesign, og er derfor ikke brugt til at behandle data. Ønsker du at få slettet dine oplysninger fra databasen kontakt Josefine B. Schougaard</div>
                <div class="validation-message"></div>
            </div>

            <input type="hidden" class="selectedShifts" name="selectedShifts">
            
            <Button class="butn w100 submit" type="submit" value="submit" name="submit">SEND</Button>
        </form>
        <?php
            //Server connection
            $conn = new mysqli('localhost:3306', 'root', '', 'frivilligdb');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connection_error);
            }


            //Post data to database
            if(isset($_POST['submit'])){
                
                $fnavn = $conn -> real_escape_string ($_POST['fornavn']);
                $enavn = $conn -> real_escape_string ($_POST['efternavn']);
                $fdag = $conn -> real_escape_string ( $_POST['fdag']);
                $adresse = $conn -> real_escape_string ($_POST['adresse']);
                $by = $conn -> real_escape_string ($_POST['by']);
                $postnr = $conn -> real_escape_string ($_POST['postnr']);
                $email = $conn -> real_escape_string ($_POST['email']);
                $phone = $conn -> real_escape_string ($_POST['tlf']);
                $kommentar = $conn -> real_escape_string ($_POST['kommentar']);
                $vagtoensker = json_decode($_POST['selectedShifts'],true);

                $sql = "INSERT INTO person (fnavn,enavn,birthday,adresse,bysted,postnummer,email,tlfnummer,kommentar) VALUES ('$fnavn','$enavn', '$fdag', '$adresse', '$by', $postnr, '$email', $phone, '$kommentar')";

                //check if data transfered
                if (mysqli_query($conn, $sql)){
                    
                    $personid = $conn -> insert_id;
                    $sql2 = ''; 
                    foreach ($vagtoensker as $vagtoenske) {
                        $dag = $conn -> real_escape_string($vagtoenske['shiftDay']);
                        $tid = $conn -> real_escape_string($vagtoenske['shiftTime']);
                        $sql2 = "INSERT INTO vagtoensker (personID,dag,tid) VALUES ($personid, '$dag', '$tid');"; 
                        if(mysqli_query($conn,$sql2)){
                            echo "<p>Dine oplysninger er modtaget!</p>";
                        }else{
                            echo "<p>ERROR: " . $sql2 . ":-" . mysqli_error($conn) . "</p>";
                        } 
                    }
                }else{
                    echo "<p>ERROR: " . $sql . ":-" . mysqli_error($conn) . "</p>";
                }
            }

            //close connection
            mysqli_close($conn);
        ?>
    </div>
    
    <script src="createtable.js"></script>
    <script src="collapse.js"></script>
    <script src="validation.js"></script>
</body>
</html>