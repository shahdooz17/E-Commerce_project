<?php
session_start();

if(!isset($_SESSION['admin'])){
	header('location: /signin.php');
}

function title() {
    global $title;
    if(isset($title))
        echo $title;
    else
        echo 'Home';
}
function inputFilter($value) {
    if($value != ''){
        $value = trim($value); # " shahi elsayed " = "shahi elsayed"
        $value = stripslashes($value); # "shahi\'" = "shahi'"
        $value = htmlspecialchars($value); # "<script>" = "&lt;script&gt;"
        return $value;
    } else {
        return false;
    }
}
function signin($conn, $email, $password) {
    if(inputFilter($email) && inputFilter($password)) {
        $email = inputFilter($email);
        $password = inputFilter($password);
        $hashedPassword = sha1($password);
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if($admin) {
            if($admin['password'] == $hashedPassword) {
                $_SESSION['admin'] = $admin;
                header('Location: index.php');
                return 2;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
}

function signup($conn, $username, $email, $password) {
    if(inputFilter($username) && inputFilter($email) && inputFilter($password)) {
        $username = inputFilter($username);
        $email = inputFilter($email);
        $password = inputFilter($password);
        $hashedPassword = sha1($password);
        $sql1 = "SELECT * FROM admin WHERE email = '$email'";
        $stmt = $conn->prepare($sql1);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if($admin) {
            return 0;
        } else {
            $sql2 = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
            $stmt = $conn->prepare($sql2);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return 2;
            } else {
                return 1;
            }
        }
    }
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "shop_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>