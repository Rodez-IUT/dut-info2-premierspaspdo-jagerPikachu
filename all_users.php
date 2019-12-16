<!DOCTYPE html>
<html>
    <head>
	    <link href="css/bootstrap.css" rel="stylesheet"/>
        <meta charset="utf-8" />
        <title>Activite 2</title>

        <?php

            $host = 'localhost';
            $db   = 'my_activities';
            $user = 'root';
            $pass = '';
            $charset = 'utf8';
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                echo $e->getMessage();
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        ?>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h1>All Users</h1>


                    <form action="all_users.php" method="get">

                        <!-- selection de la lettre -->
                        <label>Start with letter </label>
                        <input type="text" name="letter" <?php if(isset($_GET['letter'])){echo "value='".$_GET['letter']."' ";}?>/>
                        
                        <!-- selection du statut -->
                        <label>And status is </label>
                        <select name="status">
                            <option value="1" <?php if(isset($_GET['letter']) && $_GET['status']){echo "selected";}?>>Waiting for account validation</option>
                            <option value="2" <?php if(isset($_GET['letter']) && $_GET['status']){echo "selected";}?>>Active account</option>
                        </select>
                        
                        <!-- bouton ok-->
                        <input type="submit" value="OK" /><br />
                    </form>


                    <table class="table table-bordered table-striped">

                        <?php

                            if (isset($_GET['letter'])) {     // le formulaire à été envoyé

                                echo "<tr>";
                                    echo "<th>Id</th>";
                                    echo "<th>Username</th>";
                                    echo "<th>Email</th>";
                                    echo "<th>Status</th>";
                                echo "<tr>";

                                // on récupère les valeurs du formulaire
                                $status_id = $_GET['status'];
                                $lettreDebut = $_GET['letter'];


                                $stmt = $pdo->query('SELECT users.id AS id, username, email, name
                                                    FROM users
                                                    JOIN status
                                                    ON users.status_id = status.id
                                                    WHERE status_id = '.$status_id.'
                                                    AND username LIKE \''.$lettreDebut.'%'.'\'');

                                while ($row = $stmt->fetch()) {
                                    echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".$row['username']."</td>";
                                        echo "<td>".$row['email']."</td>";
                                        echo "<td>".$row['name']."</td>";
                                    echo "</tr>";
                                }

                                

                            }

                        ?>

                    </table>			

                </div>

            </div>

        </div>

    </body>
</html>