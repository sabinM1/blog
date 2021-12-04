<?php
// portable-php v.0.1
// Render each of the Markdown files from a folder in a <section>, with date-and-title as #id.

setlocale(LC_ALL, 'ro_RO', 'ro', 'rou_rou', 'ro-RO', 'ro_RO.utf8', 'ro_RO.utf-8', 'ro_RO.UTF8', 'ro_RO.UTF-8'); // sunt denumiri diferite pentru diferite sisteme

date_default_timezone_set('Europe/Bucharest');

$site_title = 'Blog-ul lui Sabin';
$site_desc = 'Blog în care scriu despre ce vreau';
$site_style = 'style.css';
$site_icon = 'img/icon.png';
$site_url = 'https://sabinm1.github.io/blog';

include('dependencies/Parsedown.php');
include('dependencies/ParsedownExtra.php');
include('dependencies/ParsedownExtraPlugin.php');

function create_slug($string){
  $string = strtolower($string);
  $string = strip_tags($string);
  $string = stripslashes($string);
  $string = html_entity_decode($string);
  $string = str_replace('\'', '', $string);
  $string = trim(preg_replace('/[^a-z0-9]+/', '-', $string), '-');
  return $string;
}

$files = [];
foreach (new DirectoryIterator(__DIR__.'/content/') as $file) {
  if ( $file->getType() == 'file' && strpos($file->getFilename(),'.md') ) {
    $files[] = $file->getFilename();
  }
}
rsort($files);

foreach ($files as $file) {

  $filename_no_ext = substr($file, 0, strrpos($file, "."));
  $file_path = __DIR__.'/content/'.$file;
  $file = fopen($file_path, 'r');
  $post_date = strftime("%A, %e %B %Y", strtotime($filename_no_ext));
  $post_title = trim(fgets($file),'#');
  $post_slug = create_slug($post_title.$filename_no_ext);
  fclose($file);

  $parsedown = new ParsedownExtraPlugin();

  // Allow single line breaks
  $parsedown->setBreaksEnabled(true);
  // Add image dimensions, lazy loading and figures
  $parsedown->imageAttributes = ['width', 'height'];
  $parsedown->imageAttributes = ['loading' => 'lazy'];
  $parsedown->figuresEnabled = true;
  // Remove the id and #links on footnotes
  $parsedown->footnoteLinkAttributes = function() {return ['href' => '#'];};
  $parsedown->footnoteReferenceAttributes = function() {return ['id' => null];};
  $parsedown->footnoteBackLinkAttributes = function() {return ['href' => '#'];};
  $parsedown->footnoteBackReferenceAttributes = function() {return ['id' => null];};

  $toc .= '<li><a href="#'.$post_slug.'"><span>'.$post_title.'</span></a> <time datetime="'.$filename_no_ext.'">'.$post_date.'</time></li>';
  $posts .= '<section tabindex="0" role="document" aria-label="'.$post_title.'" id="'.$post_slug.'">'.$parsedown->text(file_get_contents($file_path)).'</section>';
  $despre = '<section tabindex="0" role="document" aria-label="Despre" id="despre">'.$parsedown->text(file_get_contents('content/_extra/Despre.md')).' <form method="POST" action="https://www.formrocket.me/api/forms/46656298/blog/51662581323500320/post/showSuccessMessageOnDone"><p><input type="text" name="text" placeholder="Nume" aria-required="true" required style="height: 45px; width: 100%; margin-bottom: 16px; padding: 16px; font-size: 16px; background: #f5f5f5; border: 1px solid #a7a7a7; border-radius: 2px; transition: all 0.2s ease;"></p><p><input type="email" name="email" placeholder="Email" aria-required="true" required></p> <p><textarea name="mesaj" rows="4" placeholder="Propunerea/Întrebarea/Comentariul tău aici" aria-required="true" required></textarea></p><p><input type="submit" value="Trimite"></p></form></section>';
}
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $site_title; ?></title>
    <meta name="title" content="<?php echo $site_title; ?>">
    <meta name="description" content="<?php echo $site_desc; ?>">
    <link rel="icon" href="data:image/png;base64,<?php echo base64_encode(file_get_contents($site_icon)); ?>">
    <!-- og tags -->
    <meta property="og:title" content="<?php echo $site_title; ?>">
    <meta property="og:description" content="<?php echo $site_desc; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $site_url; ?>">
    <meta property="og:image" content="<?php echo $site_icon; ?>">
    <!-- other -->
    <meta name="twitter:card" content="summary">
    <style>
        <?php echo file_get_contents($site_style);?>
    </style>
</head>

<body>
    <header>
        <h1>
            <a href="#acasa"><?php echo $site_title; ?></a>
        </h1>
    </header>
    <main>
        <div style="text-align: justify">
            <!-- pentru postari -->
            <section tabindex="0"> <!-- id="acasa" -->
                <nav>
                    <ul class="toc">
                        <?php echo $toc; ?>
                    </ul>
                </nav>
            </section>
            <?php echo $despre; ?>
            <?php echo $posts; ?>
            <section tabindex="0" role="document" aria-label="Home" id="home">
                <nav>

                    <ul class="toc">
                        <?php echo $toc; ?>
                    </ul>

                </nav>
            </section>
          </div>
    </main>
    <footer>
        <noscript>
            <small>
                <p>Am observat că ai dezactivat JavaScript, foarte bine! Acest blog necesită JS doar pentru evidențierea termenilor în blocurile de cod, ceea ce nu este neapărat necesar.<br><br></p>
            </small>
        </noscript>
        <small>Ultima modificare a fost <?php echo strftime("%A, %e %B %Y"); ?></small>
        <small><a href="#despre">Despre</a></small>
    </footer>
    <div class="copyleft">
        <small><a href="https://github.com/sabinM1/blog/blob/master/LICENSE" target="_blank" rel="noopener noreferrer">🄯 Copyleft Maxim Sabin <?php echo date("Y");?></a></small>
    </div>
    <!--  Generat de către portable-php
      <?php echo date("l jS \of F Y h:i:s A"); ?>
      într-un timp de: <?php echo $executionTime = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; ?> secunde -->
</body>
<!-- Punem JS la sfârșit pentru a se încărca pagina mai repede -->
<script async src="./dependencies/microlight.js"></script>
</html>
