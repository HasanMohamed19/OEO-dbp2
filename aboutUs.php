<?php

    include 'header.php';

?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h1>About Us</h1>
                <h2>Our Objective</h2>
                <p>
                    Our main objective is to provide customers with unparalleled halls to conduct their events in. We have created this website to streamline the process of booking a hall and managing client accounts.
                </p>
                <h2>Our Story</h2>
                <p>In 2010, our founder started this company as a means to support event reservations in his hometown. After finding great success with the business, he decided to expand and build halls all over the country. Today, our halls remain the best in the region.</p>
                <h2>The Website</h2>
                <p>This web portal was created by a third party to facilitate bookings and other business transactions between us and the clients. It makes the reservation process much easier for the clients, in addition to making the management easier. This website was built by students from Bahrain Polytechnic, and they are:</p>
                <ul>
                    <li>202101277 - Hasan Mohamed</li>
                    <li>202100523 - Fatema Mahfoodh</li>
                    <li>202100937 - Yousif Alhawaj</li>
                    <li>202101456 - Ali Alfardan</li>
                    <li>202101417 - Danial Alajmi</li>
                </ul>
            </div>
            <img class="col-lg-6 d-none d-lg-block border rounded object-fit-fill p-0" src="images/about_us.jpg">
        </div>
    </div>
</div>

<?php
    include './template/footer.html';
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#about').addClass('active-page');
    });
</script>