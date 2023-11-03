<?php
require_once "autoload.php";

?>
<?php
include "header.php";
?>

<body>


    <style>
        #delete_button {
            position: absolute;
            width: 80px;
            height: 50px;
            float: right;
            right: 0;
            bottom: 0;
            border: none;
            padding: 4px;
            font-size: 14px;
            box-shadow: 0px 1px 2px 1px;
        }

        .uploadprofile {
            min-height: 200px;
            position: relative;
        }
    </style>

    <div class="container">
        <h2 class="" ;>Delete Post</h2>
        <div class="uploadprofile">
            <form action="" method="Post" id="change_profile_form" class="text-center mt-2">
                <div class="text-center">
                    Are you sure you want to delete post?
                    </div>
                    <input class="btn btn-outline-dark ms-auto mb-2 me-2" type="submit" id="delete_button" value="Delete">
                



            </form>
        </div>
    </div>
</body>