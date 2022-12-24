<?php

require "../../utils/templates.php";

?>
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):
    template_header('Home')
    ?>

    <div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Place</th>
                <th scope="col">Year of Iniciation</th>
                <th scope="col">Year of end</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <!--REPLACE TO THE FOR CICLE-->
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
            </tbody>
        </table>
    </div>

    <?=template_footer()?>
<?php else:
    header(" location: ../auth");
endif;
?>
