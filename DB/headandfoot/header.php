<head>
<title> Hotel
</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<style type="text/css">
    .brand{
        background: #cbb09c !important;
    }
    .brand-text{
            color:#cbb09c !important
    }
    form{
        max-width: 800px;
        margin: 20px auto;
        padding: 40px;
    }
    .costumer{
        width: 50px;
        margin: 20px;
        display: block;
        position: relative;

    }
    .same-line{
        display: flex; /* 2. display flex to the rescue */
        flex-direction: row;
    }
    .same-line form{
        max-width: 12000px;
        margin: 20px auto;
        padding: 40px;
    }
    .same-line input{
        display: block;
    }

</style>
</head>
<body class ="grey lighten-4">
    <nav class="white z-depth-0">
        <div class="container">
            <a href="index.php" class="brand-logo brand-text"> Hotel</a>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
            <li> <a href="adder.php" class="btn brand z-depth-0">Add costumer</a></li>
            </ul>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
                <li> <a href="uses.php" class="btn brand z-depth-0">View Costumer Uses</a></li>
            </ul>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
                <li> <a href="categories.php" class="btn brand z-depth-0">Sales Per Service Category</a></li>
            </ul>
            <ul id="nav-mobile" class="right hide-on-small-and-down">
                <li> <a href="health.php" class="btn brand z-depth-0">Health Queries</a></li>
            </ul>
        </div>
    </nav>

</body>