<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Klaper App</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f9fafb;
        }

        .form-control {
            border-color: #d9dfeb;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            background-color: #f9fafb;
        }

        .form-control:focus {
            border-color: #0054a6;
            box-shadow: 0 0 0 0.25rem rgba(0, 84, 166, 0.25);
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334e68;
        }

        .btn-primary {
            background-color: #0054a6;
            border-color: #0054a6;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
        }

        .btn-primary:hover {
            background-color: #003c7a;
            border-color: #003c7a;
        }

        .btn-neutral {
            background-color: #f9fafb;
            border-color: #f9fafb;
            color: #334e68;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
        }

        .btn-neutral:hover {
            background-color: #f0f2f5;
            border-color: #f0f2f5;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bolder {
            font-weight: 700;
        }

        .ls-tight {
            letter-spacing: -0.025em;
        }

        .h-12 {
            height: 3rem;
        }

        .h-24 {
            height: 6rem;
        }

        .w-full {
            width: 100%;
        }

        .pe-2 {
            padding-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="px-5 py-5 p-lg-0" style="height: 100vh;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 min-h-lg-screen d-flex flex-column justify-content-center py-lg-16 px-lg-20 position-relative">
                <div class="row h-100">
                    <div class="col-lg-10 col-md-9 col-xl-7 mx-auto">
                        <div class="text-center mb-12">
                            <!-- <a class="d-inline-block" href="#">
                            <img src="https://preview.webpixels.io/web/img/logos/clever-primary-sm.svg" class="h-12" alt="...">
                		        </a> -->
                            <span class="d-inline-block d-lg-block h1 mb-lg-6 me-3">👋</span>
                            <h1 class="ls-tight font-bolder h2">
                                Masuk
                            </h1>
                            <p class="mt-2">Aplikasi Klaper Siswa</p>
                        </div>
                        <form class="" method="post"
                            action="<?= route_to('login') ?>">
                            <?php if (session()->getFlashdata('error')) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="username" class="form-control" id="username" name="username" placeholder="Masukkan username anda">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="current-password">
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="check_example" id="check_example">
                                    <label class="form-check-label" for="check_example">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary w-full">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>