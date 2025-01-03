<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin - Manage Menu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries & Stylesheets -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Hero Start -->
        <div class="container-xxl py-5 bg-dark hero-header mb-5">
            <div class="container text-center my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Manage Weekly Menu</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php?controller=auth&action=logout">Logout</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Manage Menu</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Menu Management Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Add New Item</h5>
                    <h1 class="mb-5">Create Menu Item</h1>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <form method="post">
                                <input type="hidden" name="action" value="add">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select class="form-select" name="day_of_week" id="day_of_week">
                                                <option>Monday</option>
                                                <option>Tuesday</option>
                                                <option>Wednesday</option>
                                                <option>Thursday</option>
                                                <option>Friday</option>
                                                <option>Saturday</option>
                                                <option>Sunday</option>
                                            </select>
                                            <label for="day_of_week">Day of Week</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select class="form-select" name="meal_type" id="meal_type">
                                                <option value="breakfast">Breakfast</option>
                                                <option value="lunch">Lunch</option>
                                                <option value="dinner">Dinner</option>
                                            </select>
                                            <label for="meal_type">Meal Type</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" name="item_name" id="item_name" required placeholder="Item Name">
                                            <label for="item_name">Item Name</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" name="price" id="price" step="0.01" required placeholder="Price">
                                            <label for="price">Price</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">
                                            <i class="fa fa-plus me-2"></i>Add Menu Item
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Menu Items Table -->
                <div class="text-center wow fadeInUp mt-5" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Current Menu</h5>
                    <h1 class="mb-5">Existing Menu Items</h1>
                </div>
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Day</th>
                                    <th>Meal</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($allMenuItems as $menuItem): ?>
                                <tr>
                                    <td><?= $menuItem['id'] ?></td>
                                    <td><?= $menuItem['day_of_week'] ?></td>
                                    <td class="text-capitalize"><?= $menuItem['meal_type'] ?></td>
                                    <td><?= htmlspecialchars($menuItem['item_name']) ?></td>
                                    <td>$<?= number_format($menuItem['price'], 2) ?></td>
                                    <td>
                                        <form method="post" style="display:inline">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="id" value="<?= $menuItem['id'] ?>">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" name="item_name" value="<?= htmlspecialchars($menuItem['item_name']) ?>">
                                                <input type="number" class="form-control form-control-sm" step="0.01" name="price" value="<?= $menuItem['price'] ?>">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <form method="post" style="display:inline" onsubmit="return confirm('Delete this item?')">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= $menuItem['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Menu Management End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
