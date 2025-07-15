<?php
# Connexion à la BD
include '../connexion/connexion.php'; //
# Appel de la page qui fait les affichages
require_once('../models/select/select-user.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <?php require_once('style.php') ?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php
        require_once('Active.php');
        $ActiveUser = 1;
        require_once('aside.php');
        ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <?php
            #pour afficher les massage  
            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
            ?>
                <div class="alert-primary alert text-center"><?php echo $_SESSION['msg']; ?> </div>
            <?php }
            unset($_SESSION['msg']);
            if (isset($_GET['newUser']) || isset($_GET['iduser'])) {
            ?>
                <div class="row">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-title text-center"><?= $title ?></h4>
                                <div class="form-body">
                                    <form class="form" enctype="multipart/form-data" action="<?= $url ?>" method="post">
                                        <div class="row">
                                            <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback1" class="sr-only">First Name <span class="text-danger">*</span></label>
                                                <input type="text" autocomplete="off" id="feedback1" class="form-control" placeholder="First Name" name="firstName">
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback1" class="sr-only">Name <span class="text-danger">*</span></label>
                                                <input type="text" autocomplete="off" id="feedback1" class="form-control" placeholder="Name" name="name">
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback4" class="sr-only">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" autocomplete="off" id="feedback4" class="form-control" placeholder="Last Name" name="LastName">
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback2" class="sr-only">Phone Number <span class="text-danger">*</span></label>
                                                <input type="phone" autocomplete="off" id="feedback2" class="form-control" placeholder="Enter a phone number" name="phone">
                                            </div>
                                            <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback2" class="sr-only">Pass word <span class="text-danger">*</span></label>
                                                <input type="password" autocomplete="off" id="feedback2" class="form-control" placeholder="Enter a password" name="pwd">
                                            </div>
                                            <!-- <div class="form-group col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                                <label for="feedback2" class="sr-only">Photo <span class="text-danger">*</span></label>
                                                <input type="file" autocomplete="off" id="feedback2" class="form-control" placeholder="Select a photo" name="photo"> 
                                                
                                            </div> -->
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile01"><i class="bi bi-upload"></i></label>
                                                <input type="file" name="picture" class="form-control" id="inputGroupFile01">
                                            </div>

                                            <div class="form-actions d-flex justify-content-end">
                                                <button type="reset" class="btn btn-danger me-1">Cancel</button>
                                                <button type="submit" name="valider" class="btn btn-primary "><?= $btn ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="row">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <a href="user.php?newUser">Add a new user</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>


            <div class="page-heading">

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">
                                List of users
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-hover datatable-minimal">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Names</th>
                                            <th>Phone</th>
                                            <th>Profil</th>
                                            <th>PassWord</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 0;
                                        while ($iduser = $getData->fetch()) {
                                            $n++;
                                        ?>
                                            <tr>
                                                <th scope="row"><?= $n; ?></th>
                                                <td> <?= $iduser["nom"] . " " . $iduser["postnom"] . " " . $iduser["prenom"] ?></td>
                                                <td><?= $iduser["phone"] ?></td>
                                                <td> <img src="../assets/profil/<?= $iduser["photo"] ?>" width='50' height="50" style="object-fit: cover;"></td>
                                                <td><?= $iduser["pwd"] ?></td>
                                                <td>
                                                    <a href='user.php?iduser=<?= $iduser['id'] ?>' class="btn btn-primary btn-sm "><i class="bi bi-pencil-square"></i></a>
                                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer ?')" href='../models/delete/del-user-post.php?idSupcat=<?= $iduser['id'] ?>' class="btn btn-danger btn-sm "><i class="bi bi-trash3-fill"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2024 &copy; G_Shop</p>
                    </div>
                    <div class="float-end">
                        <p>Design with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="#">Glad</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>


    <script src="../assets/compiled/js/app.js"></script>



    <!-- Need: Apexcharts -->

    <script src="../assets/static/js/pages/dashboard.js"></script>
    <?php require_once('script.php') ?>

</body>

</html>