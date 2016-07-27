<?php

/**
*
* @file class-page.php
* This is a Page class for the website.
* @author Joey Garcia
* @version 1.0
* @copyright 2016 Practice Website
*/
class Page
{

/**
*
* Initialize the class properties needed for this class.
*/
private $title;
private $website_name;
private $keywords = 'practicing, class, learning';
private $description = 'Welcome to this website.';
private $menus = array(
'home' => 'index.php',
'ask' => 'ask.php',
'database' => 'database.php',
'contact' => 'contact.php',
'services' => 'services.php',
);
public $content = '';

public function __construct($title = '', $website_name = '', $keywords = '', $description = '')
{

if ($title != '') {
$this->title = $title;
}

if ($website_name != '') {
$this->website_name = $website_name;
}

if ($keywords != '') {
$this->keywords = $keywords;
}

if ($description != '') {
$this->description = $description;
}
}

public function __set($name, $value)
{
$this->name = $value;
}

public function display()
{
echo '<!DOCTYPE html>', "\n";
echo '<html>', "\n";
echo '<head>', "\n";
echo '<meta charset="UTF-8">', "\n";
$this->display_title();
$this->display_keywords();
$this->display_description();
$this->display_styles();
echo '</head>', "\n";
echo '<body>', "\n";
$this->display_header();
echo '<main role="main">', "\n";
echo $this->content, "\n";
echo '</main>', "\n";
$this->display_footer()  . "\n";
echo '</body>', "\n";
echo '</html>';
}

public function displayTitle()
{
echo '<title>', $this->title, ' | ', $this->website_name, '</title>', "\n";
}

public function displayKeywords()
{
echo '<meta name="keywords" content="', $this->keywords, '">', "\n";
}

public function displayDescription()
{
echo '<meta name="description" content="', $this->description, '">', "\n";
}

public function displayStyles()
{
?>

<style type="text/css">
/* CSS for this website */
html, body, p, h1, h2, h3, h4, h5, h6 {display:block; }
body {background-color:#ffffff; color:#444444; size:100%; line-height:1; }
h1, h2, h3, h4, h5, h6 {font-weight:700; word-wrap:break-word; }
h2, h3, h4, h5, h6 {margin:1.5em 1.5em 0; }
h1 {margin-top:2em 2em 0; size:33px; }
h2 {size:27px; }
h3 {23px; }
h4, h5, h6 {size:16px; }
p {text-decoration:none; size:16px; }
a, a:hover, a:visited, a:active  {color:#333333; }
</style>

<?php
}

public function displayHeader()
{
?>

<header id="header" role="banner">
<div id="sitename">
<h1><?php echo $this->title; ?></h1>
</div>
<div id="site-description">
<p><?php echo $this->description; ?></p>
</div>
<?php
echo '<nav id="menu" class="menu" role="navigation">', "\n";
echo '<ul id="main-nav" style="list-style-type:none">';
$this->display_menu($this->menus);
echo '</ul>';
echo '</nav>', "\n";
echo '</header>', "\n";
}

public function displayMenu($menus)
{
// Calculate menu size
$width = 100/count($menus);

foreach ($menus as $name => $url) {
$this->display_menu_buttons($width, $name, $url, !$this->is_url_current_page($url));
}
}

public function isUrlCurrentPage($url)
{
if (strpos($_SERVER["PHP_SELF"], $url) === false) {
return false;
} else {
return true;
}
}

public function displayMenuButtons($width, $name, $url, $active = true)
{
if ($active) {
echo '<li id="menu" style="width:', $width, '%">';
echo '<a href="', $url, '"><span class="menu">', $name, '</span></a>';
echo '</li>';
} else {
echo '<li style="width:', $width, '%">';
echo '<a href="', $url, '"><span class="menu">', $name, '</span></a>';
echo '</li>';
}
}

public function displayFooter()
{
?>

<footer id="footer" role="contentinfo">
<div class="copyright">
Copyright &copy; <?php echo date("Y"); ?> Practice Website All rights Reserved.
</div>
</footer>
<?php
}
}
