<?PHP
session_start();
print("<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\">");
print("<script src=\"//code.jquery.com/jquery-1.11.0.min.js\"></script>");
print("<div class=\"navbar\">");
print("<div><a href=\"panier.php\">Mon Panier</a></div>");

if ($_SESSION['loggued_on_user'] != "") {
    print("<div><a href=\"account.php\">My Account</a></div>");
    print("<div><a href=\"sessions/logout.php\">Log Out</a></div>");
} else {
    print("<div><a href=\"users/new_user.php\">Sign up</a></div><div><a href=\"sessions/login_form.php\">Login</a></div>");
}
print("</div>");
