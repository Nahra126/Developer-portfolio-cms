<?php

session_start();

require_once "includes/db.php";


$sql = "SELECT * FROM profile WHERE id = 1";
$result1 = mysqli_query($conn, $sql);

$profile = mysqli_fetch_assoc($result1);


include "includes/frontend-header.php";
include "includes/frontend-navbar.php";

?>




<!-- ///////HERO SECTION////////// -->

<div class="container py-5">

    <div class="row align-items-center gy-4 ">

        <div class="col-lg-7">

            <h1 class="fw-bold display-5"><?php echo $profile['full_name']; ?></h1>

            <h4 class="text-primary">
                <?php echo $profile['title']; ?>
            </h4>

            <p class="mt-3">
                <?php echo $profile['about']; ?>
            </p>
            
            <div class="d-flex flex-wrap gap-2 mt-4">


                <a href="uploads/resume/<?php echo $profile['resume']; ?>"
                class="btn btn-primary"
                target="_blank">

                    <i class="bi bi-download"></i>

                    Download Resume

                </a>

                <a href="<?php echo $profile['github']; ?>"
                class="btn btn-dark"
                target="_blank">

                    <i class="bi bi-github"></i>

                    GitHub

                </a>

                <a href="<?php echo $profile['linkedin']; ?>"
                class="btn btn-info text-white"
                target="_blank">

                    <i class="bi bi-linkedin"></i>

                    Linkedin

                </a>
            </div>

        </div>
        <?php if(!empty($profile['profile_image'])){ ?>

        <div class="col-lg-5 text-center">
            <img src="uploads/profile/<?php echo $profile['profile_image']; ?>"
                 class="img-fluid rounded-circle shadow"
                 width="420" alt="Profile Image">

                 <?php } ?>

        </div>

    </div>

</div>


<!-- ///////Skills Section////////// -->



<?php

$sql = "SELECT * FROM skills";
$result2 = mysqli_query($conn, $sql);

?>

<section id="Skills" class="py-5 bg-light">

    <div class="container">

        <h2 class="text-center fw-bold mb-5">My Skills</h2>

        <div class="row g-4">

            <?php while($skill = mysqli_fetch_assoc($result2)){ ?>

            <div class="col-md-6 mb-4">

                <div class="card shadow-sm h-100 border-0">

                    <div class="card-body">

                        <h5>
                            <?php echo $skill['skill_name']; ?>
                        </h5>

                        <div class="progress" style="height:20px;">

                            <div class="progress-bar bg-success"
                                 role="progressbar"
                                 style="width: <?php echo $skill['skill_percentage']; ?>%;">

                                <?php echo $skill['skill_percentage']; ?>%

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <?php } ?>

        </div>

    </div>

</section>


<!-- ///////Education Section////////// -->


    <?php

    $sql = "SELECT * FROM education ORDER BY end_year DESC";
    $result3 = mysqli_query($conn, $sql);
    ?>

<section id="Education" class="py-5">

    <div  class="container">

        <h2 class="text-center fw-bold mb-5">

            Education
            
        </h2>

        <div class="row g-4">

<?php while($education = mysqli_fetch_assoc($result3)){ ?>

    <div class="col-12 col-md-6 col-lg-4">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body">

                <h4 class="fw-bold">
                    <?php echo $education['degree']; ?>
                </h4>

                <h6 class="text-primary mb-1">
                    <i class="bi bi-building"></i>
                    <?php echo $education['institute']; ?>
                </h6>

                <p class="text-muted mb-2">
                    <i class="bi bi-calendar3"></i>
                    <?php echo $education['start_year']; ?>
                    -
                    <?php echo $education['end_year']; ?>
                </p>

                <p class="mt-2 mb-0">
                    <?php echo $education['descripton']; ?>
                </p>

            </div>

        </div>

    </div>

<?php } ?>

</div>

    </div>
    
</section>

<!-- ///////Experience  Section////////// -->


    <?php

    $sql = "SELECT * FROM experience ORDER BY end_year DESC ";
    $result4 = mysqli_query($conn, $sql);

   

    ?>
 
 <section id="Experience" class="py-5 bg-light">

    <div class="container">

        <h2 class="text-center fw-bold mb-5">
            Experience
        </h2>

        <div class="row  g-4">

        <?php while($experience = mysqli_fetch_assoc($result4)){ ?>

    <div class="col-md-6 mb-4">

        <div class="card h-100 shadow-sm border-0">

            <div class="card-body">

                        <h4 class="fw-bold">
                            <?php echo $experience['job_title']; ?>
                        </h4>

                        <p class="text-primary mb-1">
                            <i class="bi bi-building"></i>
                            <?php echo $experience['company']; ?>
                        </p>

                        <p class="text-muted">
                            <i class="bi bi-calendar3"></i>
                            <?php echo $experience['start_year']; ?>
                            -
                            <?php echo $experience['end_year']; ?>
                        </p>

                        <p mt-2 mb-0>
                            <?php echo $experience['description']; ?>
                        </p>

            </div>

        </div>

    </div>

<?php } ?>

</div>

    </div>

</section>

<!-- ///////Projects Section////////// -->

<section id="Projects" class="py-5 bg-light">

<div class="container">

    <h2 class="text-center mb-5 fw-bold mb-5">My Projects</h2>

    <div class="row g-4">

<?php

$sql = "SELECT * FROM projects";
$result = mysqli_query($conn, $sql);

while($project = mysqli_fetch_assoc($result)){

?>

<div class="col-12 col-md-6 col-lg-4">

    <div class="card h-100 shadow-sm border-0">

        <img src="uploads/projects/<?php echo $project['project_image']; ?>"
             class="card-img-top img-fluid"
             style="height:220px; object-fit:cover;">

        <div class="card-body d-flex flex-column">

            <h4><?php echo $project['project_name']; ?></h4>

            <p class="text-primary">
                <?php echo $project['technologies']; ?>
            </p>

            <p>
                <?php echo $project['description']; ?>
            </p>

            <div class="mt-3 mt-auto d-flex flex-wrap gap-2">

                <a href="<?php echo $project['github_link']; ?>"
                   target="_blank"
                   class="btn btn-dark btn-sm">
                    <i class="bi bi-github"></i>
                    GitHub
                </a>

                <a href="<?php echo $project['live_demo']; ?>"
                   target="_blank"
                   class="btn btn-primary btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i>
                    Live Demo
                </a>

            </div>

        </div>

    </div>

</div>

<?php } ?>

    </div>

</div>

</section>

<!-- ///////Contact Section////////// -->

<section id="Contact" class="py-5" id="contact">

    <div class="container">

    <?php if (isset($_SESSION['success_message'])) { ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">

                    <i class="bi bi-check-circle-fill me-2"></i>

                    <?php echo $_SESSION['success_message']; ?>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                    </button>

                </div>

        <?php unset($_SESSION['success_message']); ?>

   <?php } ?>

    

        <h2 class="text-center mb-5">Contact Me</h2>

        <div class="row row g-5 align-items-start">

            <!-- Left Side -->
            <div class="col-12 col-lg-5">

                <h4 class="mb-4">Get In Touch</h4>

                <p>
                    <i class="bi bi-envelope-fill me-2 text-primary"></i>
                    <?php echo $profile['email']; ?>
                </p>

                <p>
                    <i class="bi bi-telephone-fill me-2 text-primary"></i>
                    <?php echo $profile['phone']; ?>
                </p>

                <p>
                    <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                    <?php echo $profile['address']; ?>
                </p>

                <p>
                    <i class="bi bi-github text-decoration-none"></i>
                    <a href="<?php echo $profile['github']; ?>" target="_blank">
                        GitHub
                    </a>
                </p>

                <p>
                    <i class="bi bi-linkedin text-decoration-none"></i>
                    <a href="<?php echo $profile['linkedin']; ?>" target="_blank">
                        LinkedIn
                    </a>
                </p>

            </div>

            <!-- Right Side -->
            <div class="col-12 col-lg-7">

    
                 <h4 class="mb-4">Send Message</h4>

                        <form action="contact.php" method="POST">

                            <div class="mb-3">
                                <input type="text"
                                    class="form-control"
                                    placeholder="Your Name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <input type="email"
                                    class="form-control"
                                    placeholder="Your Email"  name="email" required>
                            </div>

                            <div class="mb-3">
                                <input type="text"
                                    class="form-control"
                                    placeholder="Subject" name="subject" required>
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control"
                                        rows="6"
                                        placeholder="Your Message" name="message" required></textarea>
                            </div>

                            <button class="btn btn-primary px-4">
                                <i class="bi bi-send"></i>
                                Send Message
                            </button>

                        </form>

                

            </div>

        </div>

    </div>

</section>

<footer class="bg-dark text-white py-4 mt-5">

    <div class="container text-center">

        <h5><?php echo $profile['full_name']; ?></h5>

        <p class="mb-2">
            <?php echo $profile['title']; ?>
        </p>

        <div class="mb-3">

            <a href="<?php echo $profile['github']; ?>"
               class="text-white me-3"
               target="_blank">
                <i class="bi bi-github fs-4"></i>
            </a>

            <a href="<?php echo $profile['linkedin']; ?>"
               class="text-white me-3"
               target="_blank">
                <i class="bi bi-linkedin fs-4"></i>
            </a>

        </div>

        <p class="mb-0">
            © <?php echo date("Y"); ?> <?php echo $profile['full_name']; ?>.
            All Rights Reserved.
        </p>

    </div>

</footer>

<?php

include "includes/frontend-footer.php";

?>