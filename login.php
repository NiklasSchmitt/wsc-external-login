<?php
    echo "user: $username | pass: $password<br>";

    if ($stmt = mysqli_prepare($wsc_mysqli, "SELECT userID, password, banned, activationCode FROM wcf1_user WHERE username = ?")) {
        mysqli_stmt_bind_param($stmt, "s", $username); mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
        if ($stmt->num_rows == 1) {
            mysqli_stmt_bind_result($stmt, $userID, $wcf_pw, $banned, $activationCode);
            while (mysqli_stmt_fetch($stmt)) {
                if ($activationCode == 0) {
                    if ($banned == 0) {
                        if ('$2a$' == substr($wcf_pw, 0, 4) && hash_equals($wcf_pw, crypt(crypt($password, $wcf_pw), $wcf_pw))) {
                            echo "LOGIN ERFOLGREICH!";
                        } else {
                            echo "Benuzername oder Passwort falsch!";
                        }
                    } else {
                        echo "Benutzeraccount gesperrt.";
                    }
                } else {
                    echo "Bitte aktiviere zuerst deinen Benutzeraccount.";
                }
            }
        } else {
            echo "Benuzername oder Passwort falsch!";
        }
    }
?>
