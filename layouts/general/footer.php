<footer>
        <div class="container section-logo">
            <img class="logo-large" src="<?= webSitePath() ?>/assets/img/logo.png" alt="logo du blog bordeaux street art">
        </div>

        <div class="container section-list">
            <div class="footer-box">
                <ul>
                    <li><h4>Navigation</h4></li>
                    <li><p><a href="">Lien </a></p></li> 
                    <li><p><a href="">Lien </a></p></li>
                    <li><p><a href="">Lien </a></p></li>
                </ul>
            </div>
            <div class="footer-box">
                <ul>
                    <li><h4>Légal</h4></li>
                    <li><p><a href="<?= webSitePath('/mentions-legales.php')?>">Mentions légales</a></p></li>
                    <li><p><a href="<?= webSitePath('/cgu.php')?>">Conditions générales d'utilisation</a></p></li>
                    <li><p><a href="">Lien </a></p></li>
                </ul>
            </div>
            <div class="footer-box">
                <ul>
                    <li><h4>Contact</h4></li>
                    <li><p><a href="">Lien </a></p></li>
                    <li><p><a href="">Lien </a></p></li>
                    <li><p><a href="">Lien </a></p></li>
                </ul>
            </div>
        </div>

        <div class="container-section-law">
            <div class="footer-droits">
                <p>© 2022-<?=intval(date("Y"))+2; ?> BSA - Tous droits réservés</p>
            </div>
        </div>
</footer>