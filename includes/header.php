<!DOCTYPE html>
<html>
<head>
<title>App</title>
<link rel="stylesheet" href="assets/css/style.css">


<script src="assets/js/app.js" defer></script>

<!-- Dashboard Auto-Load (added without interfering) -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("content-area")) {
    fetch("ajax/load_page.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "page=dashboard"
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById("content-area").innerHTML = data;
    });
  }
});
</script>

</head>
<body>
<header class="header">
  <h2>My Simple App</h2>
</header>
