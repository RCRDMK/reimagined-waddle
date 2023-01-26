        <link rel="stylesheet" href="css/navbar-stylesheet.css">

        <!-- Navbar für normale Bildschirme -->
        
        <nav class="navbar" id="navbar" aria-label="Navigationsleiste für normale Bildschirme">
           
        <ul id="navbar-liste">
            
            <li><a href="index.php"><img id="home-logo" src="ressourcen/logo.png" alt="home" height="100"></a></li>
            <li><a class="nav-elemente" id="anmelden" href="anmelden.php">Anmelden</a></li>
            <li><a class="nav-elemente" id="registrieren" href="registrieren.php">Registrieren</a></li>

        <li>
        <label for="suche" id="suchelabel">
        <form action="suche.php" method="POST">
        <input type="text" name="suche" id="suche" title="suche" aria-labelledby="suchelabel" placeholder="Suche...">
        <button type="submit">Suche</button>
      </form>
    </label>
  </li>
          </ul>
        
        </nav>

        <!-- Navbar für kleine Bildschirme und Smartphones -->
        <input type="checkbox" id="hamburger-check" />
        <label id="hamburger-menu" for="hamburger-check">
          <nav id="hamburger" aria-label="Menü für Smartphones">
            <h3>Menu</h3>
            <ul>
            <li><a href="index.php"><img id="hamburger-home-logo" src="ressourcen/logo.png" alt="home" width="100" height="100"/></a></li>
            <li><a id="hamburger-anmelden" href="anmelden.php">Anmelden</a></li>
            <li><a id="hamburger-registrieren" href="registrieren.php">Registrieren</a></li>
            <li><a id="hamburger-impressum" href="impressum.php">Impressum</a></li>
            <li><a id="hamburger-nutzungsbedingung" href="eula.php">Nutzungsbedingungen</a></li>
            <li><a id="hamburger-datenschutz" href="datenschutz.php"> Datenschutz</a></li>
            </ul>
          </nav>
        </label>

        <div class="overlay"></div>