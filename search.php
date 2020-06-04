
<head>
    <link rel="icon" href="img/DRIVENSE image icon 2.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/search.css">
    <title>Drivense | Search Results</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="/homepage.html"><img src="img/DRIVENSE image.png" width="150px" style="background: white;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
        aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggle-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/homepage.html">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">My Textbooks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Account</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0" action="search.php" method="POST">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                <button name="submit-search" class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    <?php

    require 'pdo_connect.php';

    $conn = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

    if (isset($_POST['submit-search'])) {
        // Get the value from the search form
        $search = !empty($_POST['search']) ? trim($_POST['search']) : null;
        echo '<h2 style="text-align:center; margin-top:-15px;margin-bottom:20px;">Search Results for "'. $search .'"</h2>';
        
        // Construct and prepare the SQL statement 
        $searchQuery = "%$search%";
        $sql = "SELECT * FROM textbooks WHERE Title LIKE :Title OR
        ISBN LIKE :ISBN OR AUTHOR LIKE :Author";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['Title' => $searchQuery, 'ISBN' => $searchQuery, 'Author' => $searchQuery]);

        echo "<div class='container'>";
        echo "<div class='row'>";

        $count = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $t = $count%3;
            
            echo ($t == 2) ? "<div class='col-md-4'>" : "<div class='col-md-4'>";
            echo "<div class='card mb-4 shadow-sm'>";
            echo "<img class='img-thumbnail' width='300px' src='".$row['Image']."'>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'>".$row['Title'] ."<br>".$row['ISBN']."</p>";
            echo "<div class='d-flex justify-content-between align-items-center'>";
            echo "<div class='btn-group'>";
            echo "<a href='".$row['URL']."'>Start Reading</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

            $count++;
        }
       
        echo "</div>";
        echo "</div>";
    }

    ?>
</body>