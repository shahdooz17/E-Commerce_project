<?php 

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
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) {
                if($user['password'] == $hashedPassword) {
                    $_SESSION['user'] = $user;
                    if($user['admin'] == 1) {
                        $_SESSION['admin'] = true;
                    }
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
    function signup($conn, $name, $email, $password) {
        if(inputFilter($name) && inputFilter($email) && inputFilter($password)) {
            $name = inputFilter($name);
            $email = inputFilter($email);
            $password = inputFilter($password);
            $hashedPassword = sha1($password);
            $sql1 = "SELECT * FROM users WHERE email = '$email'";
            $stmt = $conn->prepare($sql1);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return 0;
            } else {
                $sql2 = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
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