## Un mic blog în care scriu despre ce vreau

Cum poți face și tu un astfel de site? Simplu:

1. Postările sunt scrise în directorul `content`
2. După ce îți instalezi PHP (eu am testat pe PHP 8) rulezi `php portable.php > index.html`
3. Site-ul poate fi accesat prin `index.html`
4. (optional) Poți compresa puțin fișierul HTML și cel CSS cu `minify index.html` și, respectiv, `minify styles.css`. Eu le am compresate, dar păstrez o copie necompresată a acestora în directorul `uncompressed`.

<details>
<summary>Proiectul include mai multe module pentru PHP</summary>

- [Parsedown](https://parsedown.org/) transformă Markdown în HTML;
- [ParsedownExtra](https://github.com/erusev/parsedown-extra) adaugă suport pentru citări, abrevieri, liste de definiții, tabele, clase și id-uri, blocuri de cod mai bune și Markdown în blocuri HTML;
- [ParsedownExtraPlugin](https://github.com/taufik-nurrohman/parsedown-extra-plugin) adaugă `loading="lazy"` la imagini și la multe alte elemente. Poate fi folosit, de asemenea, pentru [evidențierea sintaxei](https://github.com/taufik-nurrohman/parsedown-extra-plugin#custom-code-block-contents) în blocurile de cod;

</details>

### Acest proiect are licență GPL-3.0

Pentru mai multe informații despre licență, consultați fișierul "LICENSE" sau [gnu.org](https://www.gnu.org/licenses/gpl-3.0.html).
