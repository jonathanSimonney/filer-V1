<?php

    $formOk = false;
    $errorMessage = '';

    try{
            $db = new PDO("mysql:host=localhost;dbname=filer","root","password");

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $request = "SELECT `password`,`indic` FROM `users` WHERE `users`.`username` = :username;";
            $statement = $db->prepare($request);
            $statement->execute([
                'username' => $_POST["username"]
            ]);

            $arrayResult = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (array_key_exists(0, $arrayResult)) {
                $expectedPassword = $arrayResult[0]["password"];
                if ($expectedPassword == $_POST["password"]) {
                    $formOk = true;
                    $errorMessage = "";

                    session_start();
                    $_SESSION["isLoggedIn"] =true;
                    $_SESSION["username"] = $_POST["username"];

                    $request = "SELECT `id` FROM `users` WHERE `users`.`username` = :username;";
                    $statement = $db->prepare($request);
                    $statement->execute([
                        'username' => $_POST["username"]
                    ]);

                    $arrayResult = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $_SESSION["idUser"] = $arrayResult[0]["id"];
                }else{
                    $formOk = false;
                    $errorMessage = "Sorry, but your password does not correspond to your username. Try to take into account the following : ".htmlspecialchars($arrayResult[0]["indic"]).".";
                }
            }else{
                $formOk = false;
                $errorMessage = "Sorry, but your username is not attributed. Try to type another username.";
            }

            $db = null;
        }

        catch(PDOException $e){
            echo $e;
        }

        $arrayReturned = [$formOk,$errorMessage];
        echo json_encode($arrayReturned);