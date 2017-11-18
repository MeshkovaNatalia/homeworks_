<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Single Page Shop - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Start Bootstrap</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="/cart.php" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Cart</a>
                    </li>
                    <li>
                        <?=$userInfo?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Shop Name</p>
                <div class="list-group">
                    <?php
                        if (!empty($categories)) {
                            $cHtml = '';
                            $i = 0;
                            foreach ($categories as $c1) {
                                if ($c1['id'] == $categoryId) {
                                    $cClass = 'list-group-item active';
                                } else {
                                    $cClass = 'list-group-item';
                                }
                                $cHtml .= '<a href="?category=' . $c1['id'] . '" class="' . $cClass . '">' . $c1['name'] . '</a>';
                                $i ++;
                            }
                            echo $cHtml;
                        }
                    ?>
                </div>
            </div>

            <div class="col-md-9">

                <?php
                    if (!empty($products)) {

                        $numStars = rand(3, 5);
                        $ratingHtml = '';
                        for ($i = 1; $i <= 5; $i++) {
                            $rClass = 'glyphicon glyphicon-star';
                            if ($i <= $numStars) {
                                $rClass = 'glyphicon glyphicon-star-empty';
                            }
                            $ratingHtml .= '<span class="' . $rClass . '"></span>';
                        }
                        $numRev = rand(3, 29);
                        $pHtml = '';
                        foreach ($products as $p1) {
                            if (!empty($_SESSION['u'])) {
                                $btn = '<a href="/cart.php?id=' . $p1['id'] . '" id="' . $p1['id'] . '" class="add-to-cart-link btn btn-success" data-toggle="modal" data-target="#myModal">Add to Cart</a>';
                            } else {
                                $btn = '<a href="/login.php" class="btn btn-info" role="button">Log In</a> or <a href="/register.php" class="btn btn-info" role="button">Register</a>';
                            }
                            $imgUrl = 'http://placehold.it/800x300';
                            if (strlen($p1['image_url']) > 0) {
                                $imgUrl = $p1['image_url'];
                            }
                            $pHtml .= '<div class="thumbnail">
                    <img class="img-responsive" src="' . $imgUrl . '" alt="' . $p1['title'] . '">
                    <div class="caption-full">
                        <h4 class="pull-right">$' . $p1['price'] . '</h4>
                        <h4><a href="#">' . $p1['title'] . '</a>
                        </h4>
                        <div class="text-right">
                            ' . $btn . '
                        </div>
                        <div>' . $p1['description'] . '</div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">' . $numRev . ' reviews</p>
                        <p>' . $ratingHtml . ' ' . $numStars . ' stars</p>
                    </div>
                </div>';
                        }
                        echo $pHtml;
                    }

                    if ($numGoods > $pLimit) {
                        /*
                         *
                         <nav aria-label="Page navigation">
                          <ul class="pagination">
                            <li>
                              <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                              <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                         *
                         */
                        // echo '<p>Num goods: ' . $numGoods . ' Current page: ' . $pNum . '</p>';
                        $addPages = 1;
                        $pagerHtml = '<nav aria-label="page navigation"><ul class="pagination pagination-lg"> ';
                        $j = 1;
                        while ($addPages) {
                            if (preg_match('|(.*)&page=(\d+)|', $_SERVER['REQUEST_URI'], $m1)) {
                                // echo '<pre>' . var_export($m1, 1) . '</pre>';
                                $uri = '/?category=' . $categoryId . '&page=' . $j;
                            } else {
                                $uri = $_SERVER['REQUEST_URI'] . '&page=' . $j;
                            }
                            if ($pNum == $j) {
                                $pClass = ' class="active"';
                            } else {
                                $pClass = '';
                            }
                            $pagerHtml .= '<li><a href="' . $uri . '"' . $pClass . '>' . $j . '</a></li>';
                            if ($j * $pLimit > $numGoods) {
                                $addPages = 0;
                            }
                            $j ++;
                        }
                        $pagerHtml .= '</ul></nav>';

                        echo $pagerHtml;
                    }

                ?>


                <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">10 days ago</span>
                            <p>This product was great in terms of quality. I would definitely buy another!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">12 days ago</span>
                            <p>I've alredy ordered another one!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">15 days ago</span>
                            <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Our E-commerce <?=$year?></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title w-100" id="myModalLabel">Modal title</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
            </div>
            <!--Footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.add-to-cart-link').click(function(){
            var prod = $(this).parent().parent().children('h4');
            $('.modal-body').append(prod);
        })
    });
</script>

</body>

</html>
