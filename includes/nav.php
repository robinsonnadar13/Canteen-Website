 <a class="navbar-brand" href="#">
    <img src="logo2.png" width="50" height="45" alt="" loading="lazy">
  </a>
  
  <div class="nav-links">
   foreach ($navItems as $item) {
   echo "<li><a href=\"$item[slug]\">$item[title]</a></li>";
}
  </div>

  