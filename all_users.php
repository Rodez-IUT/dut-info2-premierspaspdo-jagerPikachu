<!DOCTYPE html>

    <head>
        <meta charset="utf-8" />
        <link href="css/bootstrap.css" rel="stylesheet" />
        <title>Affichage users</title>

        <!-- Connexion à la base de donées -->
        <?php
            $host = 'localhost';
            $db = 'my_activities';
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
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        ?>

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <h1>All users</h1>

                    <?php
                        $premiereLettre ="e".'%';
                        $statusID = 1;
                    ?>

                    <!-- Création du tableau -->
                    <table class="table table-bordered table-striped"> 
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Status</th>

                            <?php
                                $stmt = $pdo->query("SELECT users.id AS id, username, email, name, status_id
                                                     FROM users
                                                     JOIN status
                                                     ON users.status_id = status.id
                                                     WHERE username LIKE '$premiereLettre'
                                                     AND status_id = $statusID");
 

                                // écriture des lignes du tableau
                                while ($row = $stmt->fetch()) {

                                    echo "<tr>";
                                    echo "<td>".$row['id']."</td>";
                                    echo "<td>".$row['username']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        <tr>
                    </table>

                </div>    
            </div>
        </div>                        
    </body>

</html>